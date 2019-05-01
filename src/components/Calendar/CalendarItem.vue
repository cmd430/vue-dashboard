<template>
<li v-if="shouldShow()">
  <div class="img" v-bind:style="{ 'background-image': 'url(' + calendar_item.img_url + ')' }">
    <span v-bind:class="calendar_item.status_class">{{ calendar_item.status_text }}</span>
  </div>
  <div class="info" v-bind:title="type == 'show' ? 'Season: ' + calendar_item.season_number + ' Episode: ' + calendar_item.episode_number + '\r\nEpisode Title: ' + calendar_item.episode_title + '\r\nShow: ' + calendar_item.name : 'Movie Title: ' + calendar_item.name">
    <p v-if="type == 'show'" class="title">
      <span>{{ calendar_item.season_number }}x{{ calendar_item.episode_number }}</span>
      {{ calendar_item.episode_title }}
    </p>
    <p class="name">{{ calendar_item.name }}</p>
  </div>
</li>
</template>

<script>
export default {
  name: 'calendar-item',
  props: [
    'calendar_item',
    'type'
  ],
  methods: {
    shouldShow () {
      // showDownloaded is dumb (im dumb)
      // true = hide
      // false = show
      let a = (this.$store.state.settings.showNextUnairedOnly === true && this.calendar_item.nextEpisode === true)
      let b = (this.$store.state.settings.showNextUnairedOnly === false && this.calendar_item.status_class !== 'downloaded')
      let c = (this.$store.state.settings.showDownloaded === true && this.calendar_item.status_class !== 'downloaded')
      let d = (this.$store.state.settings.showDownloaded === false && this.calendar_item.status_class === 'downloaded')
      if (a || b || (a && c) || d) {
        return true
      }
      return false
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
div.img {
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
    &.airing {
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
div.info {
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
</style>
