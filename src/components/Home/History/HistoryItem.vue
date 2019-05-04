<template>
<li>
  <div class="img" v-bind:style="{ 'background-image': 'url(' + (history.series ? history.series.poster : history.poster) + ')' }">
    <span>{{ history.watched.user }}</span>
    <span>{{ history.watched.stopped | moment("from", "now") }}</span>
  </div>
  <div class="info">
    <p v-if="history.mediatype == 'episode'" class="title">
      <span>{{ history.series.season }}x{{ history.series.episode }}</span>
      {{ history.title }}
    </p>
    <p class="name">{{ (history.series ? history.series.title : history.title) }}</p>
  </div>
</li>
</template>

<script>
export default {
  name: 'history-item',
  props: [
    'history'
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
      background-color: rgba(238, 238, 238, 0.8);
      color: rgb(0, 0,0 );
      padding: 0;
      &:first-child {
        padding: 5px 10px 0;
      }
      &:last-child {
        padding: 0 10px 5px;
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
