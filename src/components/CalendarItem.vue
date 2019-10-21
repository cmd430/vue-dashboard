<template>
<li v-if="shouldShow()" :class="extended ? 'extended' : ''">
  <div class="img" :style="{ 'background-image': 'url(' + (calendar.series ? calendar.series.poster : calendar.poster) + ')' }" v-on:click="extended = !extended">
    <span :class="currentClass">{{ currentText }}</span>
  </div>
  <div class="info">
    <p v-if="calendar.series" class="title" v-title>
      <span>{{ calendar.series.season }}x{{ calendar.series.episode }}</span>
      {{ calendar.title }}
    </p>
    <p class="name" v-title>{{ (calendar.series ? calendar.series.title : calendar.title) }}</p>
  </div>
  <div :class="'extended-info ' + currentClass">
    <div class="top-info">
      <p class="network" v-title>
        <i class="icon-network"></i>{{ calendar.series ? calendar.series.network : calendar.studio }}
      </p>
      <p class="runtime" v-title>
        <i class="icon-clock"></i>{{ formatRuntime(calendar.release.runtime) }}
      </p>
    </div>
    <div class="scroll">
      <p v-if="calendar.overview === ''">Overview is not currently available for this item.</p>
      <p>{{ calendar.overview }}</p>
    </div>
  </div>
</li>
</template>

<script>
export default {
  name: 'calendar-item',
  props: [
    'calendar',
    'month',
    'display'
  ],
  data () {
    return {
      extended: false
    }
  },
  computed: {
    currentClass () {
      if (this.calendar.downloaded) return 'downloaded'
      let downloading = this.calendar.downloading.status === 'downloading'
      let queued = this.calendar.downloading.status === 'queued'
      let paused = this.calendar.downloading.status === 'paused'
      let starting = this.calendar.downloading.status === 'warning' // Seems to only be when first added...
      if (downloading || queued || paused || starting) return 'downloading'
      let completed = this.calendar.downloading.status === 'completed'
      let warning = this.calendar.downloading.message === 'warning'
      if ((completed && warning)) return 'warning'
      if (this.calendar.downloading.status === 'stalled') return 'stalled'
      let cd = new Date().toISOString()
      if (this.calendar.release.air) {
        // TV
        if (this.calendar.release.air < cd) {
          let finished = new Date(this.calendar.release.air).getTime() + this.calendar.release.runtime * (60 * 1000)
          if (new Date(finished).toISOString() < cd) return 'pending'
          return 'airing'
        }
      } else {
        // Movie
        if (this.calendar.release.physical < cd) return 'pending'
        if (this.calendar.release.cinema < cd && this.calendar.release.status.includes('cinema')) {
          if (new Date(this.calendar.release.cinema).getMonth() === new Date().getMonth()) {
            return 'cinema'
          }
        } else if (this.calendar.release.cinema < cd && !this.calendar.release.status.includes('cinema')) {
          return 'unknown'
        }
      }
      return 'want'
    },
    currentText () {
      let stalled = this.currentClass === 'stalled'
      let warning = this.currentClass === 'warning'
      if (stalled || warning) return 'requires attention'
      if (this.currentClass === 'pending') return 'pending'
      if (this.currentClass === 'downloading') return 'downloading'
      if (this.currentClass === 'downloaded') return 'in plex'
      if (this.calendar.release.air) {
        // TV
        if (this.currentClass === 'airing') return 'on air'
        if (this.currentClass === 'want') return this.display === 'relative' ? this.$moment(this.calendar.release.air).fromNow() : this.$moment(this.calendar.release.air).format(this.display)
      } else {
        // Movie
        if (this.currentClass === 'cinema') return 'in cinemas'
        if (this.currentClass === 'want') {
          let physical = this.calendar.release.physical
          if (physical !== null) return this.display === 'relative' ? this.$moment(physical).fromNow() : this.$moment(physical).format(this.display)
          return this.$moment(this.calendar.release.cinema).fromNow()
        }
      }
      return 'unknown'
    }
  },
  watch: {
    extended (val) {
      if (val === true) this.$el.lastChild.querySelector('.scroll').scrollTop = 0
    }
  },
  methods: {
    shouldShow () {
      if (this.calendar.series) {
        // TV
        let a = (this.$store.state.settings.showNextUnairedOnly === true && this.calendar.release.status === 'next')
        let b = (this.$store.state.settings.showNextUnairedOnly === false && this.currentClass !== 'downloaded')
        let c = (this.$store.state.settings.hideDownloaded === true && this.currentClass !== 'downloaded')
        let d = (this.$store.state.settings.hideDownloaded === false && this.currentClass === 'downloaded')
        let e = (this.$store.state.settings.alwaysShowToday === true && this.calendar.release.status === 'today')
        if (a || b || (a && c) || d || e) return true
      } else {
        // Movie
        let a = (this.$store.state.settings.hideDownloaded === true && this.currentClass !== 'downloaded')
        let b = (this.$store.state.settings.hideDownloaded === false)
        let c = (this.$store.state.settings.showCinemaRelease === true)
        let d = (new Date(this.calendar.release.physical).getMonth() === new Date(this.month.start).getMonth())
        if ((a || b) && (c || d)) return true
      }
      return false
    },
    formatRuntime (r) {
      let hours = r / 60 ^ 0
      let minutes = r % 60
      return hours > 0 ? `${hours}h ${minutes}m` : `${minutes}m`
    },
    overflow (e) {
      let scroll = e.target
      if (e.type === 'mouseenter') {
        scroll.style.overflow = 'hidden auto'
      } else if (e.type === 'mouseleave') {
        scroll.style.overflow = 'hidden'
      }
    }
  },
  mounted () {
    let scroll = this.$el.lastChild.querySelector('.scroll')
    scroll.addEventListener('mouseenter', this.overflow)
    scroll.addEventListener('mouseleave', this.overflow)
  },
  beforeDestroy () {
    let scroll = this.$el.lastChild.querySelector('.scroll')
    scroll.removeEventListener('mouseenter', this.overflow)
    scroll.removeEventListener('mouseleave', this.overflow)
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
div {
  .img {
    height: 270px;
    width: 170px;
    background:
      url(/img/placeholder.jpg),
    rgb(36, 36, 36);
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    cursor: pointer;
    span {
      top: 0px;
      left: 0;
      right: 0;
      width: 100%;
      display: block;
      box-sizing: border-box;
      z-index: 1;
      text-transform: uppercase;
      letter-spacing: 1px;
      font-size: 12px;
      padding: 10px;
      color: rgb(238, 238, 238);
      &.want {
        background-color: rgba(238, 238, 238, 0.8);
        color: rgb(0, 0,0 );
        text-align: right;
      }
      &.airing,
      &.cinema {
        background-color: rgba(214, 214, 56, 0.8);
        color: rgb(0, 0,0 );
      }
      &.pending {
        background-color: rgba(215, 57, 57, 0.8);             /* http://colorizer.org/ */
      }
      &.downloading {
        background-color: rgba(143, 44, 189, 0.8);
      }
      &.warning {
        background-color: rgba(190, 102, 44, 0.8);
      }
      &.downloaded {
        background-color: rgba(44, 189, 78, 0.8);
      }
      &.unknown {
        background-color: rgba(190, 102, 44, 0.8);
      }
    }
  }
  .info {
    text-align: center;
    p {
      margin: 5px;
      overflow: hidden;
      white-space: nowrap;
      text-overflow: ellipsis;
    }
    span {
      font-weight: 700;
      font-size: 14px;
    }
    .title {
      font-size: 12px;
    }
    .name {
      font-size: 13px;
    }
  }
}
li {
  transition: width 200ms linear;
  &.extended {
    width: 570px;
    .extended-info {
      width: 380px;
      &::before {
        border-left: 15px solid;
      }
    }
  }
  .extended-info {
    position: absolute;
    top: 10px;
    left: 180px;
    width: 0px;
    height: 270px;
    background-color: rgba(0, 0, 0, 0.3);
    overflow: hidden;
    z-index: 1;
    transition: width 200ms linear;
    &::before {
      position: absolute;
      content: '';
      width: 0;
      height: 0;
      border-top: 20px solid transparent;
      border-bottom: 20px solid transparent;
      border-left: 0 solid;
      transition: border-left 200ms linear;
    }
    &.want {
      &::before {
         border-left-color: rgba(238, 238, 238, 0.8);
      }
    }
    &.airing,
    &.cinema {
      &::before {
        border-left-color: rgba(214, 214, 56, 0.8);
      }
    }
    &.pending {
      &::before {
        border-left-color: rgba(215, 57, 57, 0.8);
      }
    }
    &.downloading {
      &::before {
        border-left-color: rgba(143, 44, 189, 0.8);
      }
    }
    &.warning {
      &::before {
        border-left-color: rgba(190, 102, 44, 0.8);
      }
    }
    &.downloaded {
      &::before {
        border-left-color: rgba(44, 189, 78, 0.8);
      }
    }
    &.unknown {
      &::before {
        border-left-color: rgba(190, 102, 44, 0.8);
      }
    }
    .top-info {
      position: absolute;
      width: 380px;
      height: 20px;
      padding: 10px 0;
      z-index: 1;
      font-size: 12px;
      letter-spacing: 1px;
      font-variant: small-caps;
      text-align: right;
      overflow: hidden;
      white-space: nowrap;
      text-overflow: clip;
      color: rgb(238, 238, 238);
      .runtime,
      .network {
        display: inline;
        margin: 0 12px 0 0;
        .icon-network {
          margin-right: 5px;
        }
        .icon-clock {
          margin-right: 2px;
        }
      }
    }
    .scroll {
      width: 360px;
      height: 220px;
      margin: 40px 0 10px 10px;
      padding-right: 10px;
      overflow: hidden;
      white-space: nowrap;
      white-space: initial;
      user-select: text;
      cursor: auto;
      p {
        width: 360px;
        font-size: 12px;
        color: rgb(153, 153, 153);
      }
    }
  }
}

</style>
