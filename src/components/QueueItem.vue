<template>
<li>
  <div class="img" v-bind:style="{ 'background-image': 'url(' + (queue.series ? queue.series.poster : queue.poster) + ')' }">
    <span v-if="queue.downloading.status === 'downloading'" class="downloading">
      <span>{{ queue.downloading.timeleft }}</span>
      <span>{{ queue.downloading.progress }}</span>
    </span>
    <!-- These next two v-if blocks might not be correct -->
    <span v-if="queue.downloading.status === 'warning'">
      <span>check download</span>
    </span>
    <span v-if="queue.downloading.status === 'queued'">
      <span>queued</span>
    </span>
  </div>
  <div class="info">
    <p v-if="queue.series" class="title">
      <span>{{ queue.series.season }}x{{ queue.series.episode }}</span>
      {{ queue.title }}
    </p>
    <p class="name">{{ (queue.series ? queue.series.title : queue.title) }}</p>
  </div>
</li>
</template>

<script>
export default {
  name: 'queue-item',
  props: [
    'queue'
  ]
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
div {
  &.img {
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
      &.downloading,
      &.queued {
        background-color: rgba(143, 44, 189, 0.8);
        color: rgb(238, 238, 238);
        padding: 0;
      }
      &.warning {
        background-color: hsla(24, 62%, 46%, 0.8);
        color: rgb(238, 238, 238);
        padding: 0;
      }
      &.downloading span:first-child {
        padding: 5px 10px 0;
      }
      &.downloading span:last-child {
        padding: 0 10px 5px;
      }
      &.queued span,
      &.warning span {
        padding: 10px;
      }
    }
  }
  &.info {
    text-align: center;
    p {
      width: 160px;
      margin: 5px 0 5px 5px;
      overflow: hidden;
      white-space: nowrap;
      text-overflow: ellipsis;
    }
    .title {
      font-size: 12px;
      span {
        font-weight: 700;
        font-size: 14px;
      }
    }
    .name {
      font-size: 13px;
    }
  }
}
</style>
