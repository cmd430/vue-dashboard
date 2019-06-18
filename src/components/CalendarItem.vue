<template>
<li v-if="shouldShow()" :class="((this.calendar.release.cinema > new Date().toISOString()) ? 'faded' : '')">
  <div class="img" :style="{ 'background-image': 'url(' + (calendar.series ? calendar.series.poster : calendar.poster) + ')' }">
    <span :class="currentClass">{{ currentText }}</span>
  </div>
  <div class="info">
    <p v-if="calendar.series" class="title" v-title>
      <span>{{ calendar.series.season }}x{{ calendar.series.episode }}</span>
      {{ calendar.title }}
    </p>
    <p class="name" v-title>{{ (calendar.series ? calendar.series.title : calendar.title) }}</p>
  </div>
</li>
</template>

<script>
export default {
  name: 'calendar-item',
  props: [
    'calendar'
  ],
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
          if(new Date(this.calendar.release.cinema).getMonth() === new Date().getMonth()) {
            return 'cinema'
          }
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
        if (this.currentClass === 'want') return this.$moment(this.calendar.release.air).fromNow()
      } else {
        // Movie
        if (this.currentClass === 'cinema') return 'in cinemas'
        if (this.currentClass === 'want') {
          let physical = this.calendar.release.physical
          if (physical !== null) return this.$moment(physical).fromNow()
          return this.$moment(this.calendar.release.cinema).fromNow()
        }
      }
      return 'unknown'
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
        if (a || b) return true
      }
      return false
    }
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
        background-color: hsla(24, 62%, 46%, 0.8);
      }
      &.downloaded {
        background-color: rgba(44, 189, 78, 0.8);
      }
    }
  }
  .info {
    text-align: center;
    p {
      width: 160px;
      margin: 5px 0 5px 5px;
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
</style>
