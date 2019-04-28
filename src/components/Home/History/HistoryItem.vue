<template>
<li>
  <div class="img" v-bind:style="{ 'background-image': 'url(' + history_item.image + ')' }">
    <span>{{ history_item.user }}</span>
    <span>{{ history_item.last_watch }}</span>
  </div>
  <div class="info" v-bind:title="history_item.media_type == 'episode' ? 'Season: ' + history_item.season + ' Episode: ' + history_item.episode + '\r\nEpisode Title: ' + history_item.episode_title + '\r\nShow: ' + history_item.title : 'Movie Title: ' + history_item.title">
    <p v-if="history_item.media_type == 'episode'" class="title">
      <span>{{ history_item.season }}x{{ history_item.episode }}</span>
      {{ history_item.episode_title }}
    </p>
    <p class="name">{{ history_item.title }}</p>
  </div>
</li>
</template>

<script>
export default {
  name: 'history-item',
  props: [
    'history_item'
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
  background-color: rgba(238, 238, 238, 0.8);
  color: rgb(0, 0,0 );
  padding: 0;
}
.img span:first-child {
  padding: 5px 10px 0;
}
.img span:last-child {
  padding: 0 10px 5px;
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
