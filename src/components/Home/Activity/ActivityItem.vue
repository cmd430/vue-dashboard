<template>
<li>
  <div class="img" v-bind:style="{ 'background-image': 'url(' + activity_item.images.poster + ')' }">
    <span>{{ activity_item.state }} - {{ activity_item.progress_percent }}%</span>
  </div>
  <div class="info">
    <p v-if="activity_item.media_type == 'episode'" class="title">
      <span>{{ activity_item.series.season }}x{{ activity_item.series.episode }}</span>
      {{ activity_item.series.episode_title }}
    </p>
    <p v-if="activity_item.media_type == 'episode'" class="name">{{ activity_item.series.title }}</p>
    <p v-if="activity_item.media_type == 'movie'" class="name">{{ activity_item.title }}</p>
  </div>
</li>
</template>

<script>
export default {
  name: 'activity-item',
  props: [
    'activity_item'
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
  background-color: rgba(238, 238, 238, 0.8);
  color: rgb(0, 0,0 );
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
  font-size: 12px;
}
.info .name {
  font-size: 13px;
}
</style>
