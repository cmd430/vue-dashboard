<template>
<li>
  <div class="img" :style="{ 'background-image': 'url(' + (missing.series ? missing.series.poster : missing.poster) + ')' }">
    <span>Missing</span>
  </div>
  <div class="info">
    <p v-if="missing.mediatype == 'episode'" class="title" v-title>
      <span>{{ missing.series.season }}x{{ missing.series.episode }}</span>
      {{ missing.title }}
    </p>
    <p class="name" v-title>{{ (missing.series ? missing.series.title : missing.title) }}</p>
  </div>
</li>
</template>

<script>
export default {
  name: 'missing-item',
  props: [
    'missing'
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
      background-color: rgba(215, 57, 57, 0.8);
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
