<template>
<li>
  <div class="img" :style="{ 'background-image': 'url(' + (recent.series ? recent.series.poster : recent.poster) + ')' }">
    <span>{{ recent.added | moment("from", "now") }}</span>
  </div>
  <div class="info">
    <p v-if="recent.mediatype == 'episode'" class="title" v-title>
      <span>{{ recent.series.season }}x{{ recent.series.episode }}</span>
      {{ recent.title }}
    </p>
    <p class="name" v-title>{{ (recent.series ? recent.series.title : recent.title) }}</p>
  </div>
</li>
</template>

<script>
export default {
  name: 'recent-item',
  props: [
    'recent'
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
      padding: 10px;
      background-color: rgba(44, 189, 78, 0.8);
      color: rgb(238, 238, 238);
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
