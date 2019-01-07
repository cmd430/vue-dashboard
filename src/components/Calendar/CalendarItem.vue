<template>
<li v-if="(this.$store.state.settings.showDownloaded === true && calendar_item.status_class === 'downloaded') === false">
  <div class="img" v-bind:style="{ 'background-image': 'url(' + calendar_item.img_url + ')' }">
    <span v-bind:class="calendar_item.status_class">{{ calendar_item.status_text }}</span>
    <span v-if="type == 'show'" class="title" v-bind:title="'Season: ' + calendar_item.season_number + ' Episode: ' + calendar_item.episode_number + '\r\nEpisode Title: ' + calendar_item.episode_title + '\r\nShow: ' + calendar_item.name"></span>
    <span v-if="type != 'show'" class="title" v-bind:title="'Movie Title: ' + calendar_item.name"></span>
  </div>
  <div class="info">
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
  ]
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
li {
  display: inline-block;
  padding: 10px;
  box-sizing: border-box;
  width: 190px;
  height: 351px;
}
div.img {
  height: 270px;
  width: 170px;
  background:
    url(/img/placeholder.jpg),
  rgb(36, 36, 36);
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
}
.img span {
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
}
.img span.want {
  background-color: rgba(238, 238, 238, 0.8);
  color: rgb(0, 0,0 );
}
.img span.airing {
  background-color: rgba(214, 214, 56, 0.8);
  color: rgb(0, 0,0 );
}
.img span.pending {
  background-color: rgba(215, 57, 57, 0.8);             /* http://colorizer.org/ */
  color: rgb(238, 238, 238);
}
.img span.downloading {
  background-color: rgba(143, 44, 189, 0.8);
  color: rgb(238, 238, 238);
}
.img span.downloaded {
  background-color: rgba(44, 189, 78, 0.8);
  color: rgb(238, 238, 238);
}
.img span.title {
  position: relative;
  margin-top: -40px;
  width: 100%;
  height: 100%;
  padding: 0;
  background: rgba(0, 0, 0, 0);
}
div.info {
  text-align: center;
}
.info p {
  width: 160px;
  margin: 5px 0 5px 5px;
  overflow: hidden;
  white-space: nowrap;
  text-overflow: ellipsis;
}
.info .title {
  font-size: 12px;
}
.title span {
  font-weight: 700;
  font-size: 14px;
}
.info .name {
  font-size: 13px;
}
</style>
