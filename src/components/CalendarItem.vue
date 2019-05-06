<template>
<li v-if="shouldShow()">
  <div class="img" v-bind:style="{ 'background-image': 'url(' + (calendar.series ? calendar.series.poster : calendar.poster) + ')' }">
    <span v-bind:class="currentClass">{{ currentText }}</span>
  </div>
  <div class="info">
    <p v-if="calendar.series" class="title">
      <span>{{ calendar.series.season }}x{{ calendar.series.episode }}</span>
      {{ calendar.title }}
    </p>
    <p class="name">{{ (calendar.series ? calendar.series.title : calendar.title) }}</p>
  </div>
</li>
</template>

<script>
export default {
  name: 'calendar-item',
  props: [
    'calendar'
  ],
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
  },
  computed: {
    currentClass () {
      if (this.calendar.downloaded) return 'downloaded'
      if (this.calendar.downloading.status === ('downloading' || 'queued')) {
        if (this.calendar.downloading.message === 'ok') return 'downloading'
        return 'warning'
      }
      let cd = new Date().toISOString()
      if (this.calendar.release.air) {
        // TV
        if (this.calendar.release.air < cd) {
          let dt = new Date(this.calendar.release.air)
          dt.setMinutes(dt.getMinutes() + this.calendar.release.runtime)
          if (dt.getUTCDate() < cd) return 'pending'
          return 'airing'
        }
      } else {
        // Movie
        if (this.calendar.release.physical < cd) return 'pending'
        if (this.calendar.release.cinema < cd && this.calendar.release.status.includes('cinema')) return 'cinema'
      }
      return 'want'
    },
    currentText () {
      if (this.currentClass === 'warning') return 'check download'
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
      text-align: right;
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
      }
      &.airing,
      &.cinema {
        background-color: rgba(214, 214, 56, 0.8);
        color: rgb(0, 0,0 );
        text-align: left;
      }
      &.pending {
        background-color: rgba(215, 57, 57, 0.8);             /* http://colorizer.org/ */
        text-align: left;
      }
      &.downloading {
        background-color: rgba(143, 44, 189, 0.8);
        text-align: left;
      }
      &.warning {
        background-color: hsla(24, 62%, 46%, 0.8);
        text-align: left;
      }
      &.downloaded {
        background-color: rgba(44, 189, 78, 0.8);
        text-align: left;
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