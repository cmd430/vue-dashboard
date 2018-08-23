<template>
<li>
  <div class="img" v-bind:style="{ 'background-image': 'url(' + queue_item.img_url + ')' }">
    <span v-if="queue_item.status === 'Downloading'" class="downloading">
      <span>{{ queue_item.timeleft }}</span>
      <span>{{ queue_item.progress }}</span>
    </span>
    <span v-else class="queued">
      <span>{{ queue_item.timeleft }}</span>
    </span>
  </div>
  <div class="info">
    <p v-if="type == 'show'" class="title">
      <span>{{ queue_item.season_number }}x{{ queue_item.episode_number }}</span>
      {{ queue_item.episode_title }}
    </p>
    <p class="name">{{ queue_item.name }}</p>
  </div>
</li>
</template>

<script>
export default {
  name: 'queue-item',
  props: [
    'queue_item',
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
}
.img span.downloading,
.img span.queued {
  background-color: rgba(143, 44, 189, 0.8);
  color: rgb(238, 238, 238);
  padding: 0;
}
span.downloading span:first-child {
  padding: 5px 10px 0;
}
span.downloading span:last-child {
  padding: 0 10px 5px;
}
span.queued span {
  padding: 10px;
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
