<template>
<li>
  <div class="bg_img" v-bind:style="{ 'background-image': 'url(' + (activity.series ? activity.series.images.art : activity.images.art) + ')' }">
    <span>{{ activity.playback.user }}</span>
    <span>{{ activity.playback.state }}</span>
  </div>
  <div class="img" v-bind:style="{ 'background-image': 'url(' + (activity.series ? activity.series.images.poster : activity.images.poster) + ')' }">
  </div>
  <div class="info" v-bind:data-type="activity.mediatype">
    <p v-if="activity.mediatype == 'episode'">
      <span>Series:</span>
      {{ activity.series.title }}
    </p>
    <p v-if="activity.mediatype == 'episode'">
      <span>Episode Title:</span>
      {{ activity.title }}
    </p>
    <p v-if="activity.mediatype == 'episode'">
      <span>Season:</span>
      {{ activity.series.season }}
    </p>
    <p v-if="activity.mediatype == 'episode'">
      <span>Episode:</span>
      {{ activity.series.episode }}
    </p>
    <p v-if="activity.mediatype == 'movie'">
      <span>Movie Title:</span>
      {{ activity.title }}
    </p>
  </div>
  <div id="progress">
    <span class="progress_text">{{ activity.playback.progress.time | MediaTime((activity.playback.runtime.length > 7)) }} / {{ activity.playback.runtime | MediaTime() }}</span>
    <span class="percent_text">{{ activity.playback.progress_percent }}</span>
    <span class="progress" v-bind:style="{ 'width': activity.playback.progress.percent + '%'}"></span>
  </div>
</li>
</template>

<script>
export default {
  name: 'activity-item',
  props: [
    'activity'
  ]
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
div {
  &.bg_img,
  &.img {
    height: 270px;
    width: 480px;
    background:
      url(/img/placeholder.jpg),
    rgb(36, 36, 36);
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
  }
  &.bg_img {
    span {
      text-align: right;
      top: 0px;
      left: 0;
      right: 0;
      width: 100%;
      display: inline-block;
      box-sizing: border-box;
      z-index: 1;
      text-transform: uppercase;
      letter-spacing: 1px;
      font-size: 12px;
      padding: 10px;
      color: rgb(0, 0,0 );
      &:first-child {
        text-align: left;
        background-color: rgba(237, 237, 237, 0.8)
      }
      &:last-child {
        top: -40px;
        position: relative;
      }
    }
  }
  &.img {
    height: 209px;
    width: 132px;
    background: url(/img/placeholder.jpg),rgb(36, 36, 36);
    background-size: cover;
    background-position: 50%;
    background-repeat: no-repeat;
    position: absolute;
    top: 60px;
    left: 20px;
  }
  &.info {
    text-align: center;
    position: absolute;
    top: 95px;
    left: 162px;
    width: 318px;
    height: 114px;
    &[data-type="movie"] {
      top: 145px;
    }
    p {
      margin: 5px 5px 5px 5px;
      overflow: hidden;
      white-space: nowrap;
      text-overflow: ellipsis;
      font-size: 13px;
      color: rgb(238, 238, 238);
      span {
        font-weight: 700;
        font-size: 12px;
        color: rgb(153, 153, 153);
      }
    }
  }
  &#progress {
    position: absolute;
    top: 265px;
    left: 162px;
    width: 318px;
    height: 4px;
    background-color: rgba(0,0,0,.3);
    span.progress {
      height: 100%;
      width: 0;
      background-color: rgba(249, 190, 3, 0.8);
      position: absolute;
      top: 0;
      left: 0;
      transition: width 200ms;
    }
    span.percent_text,
    span.progress_text {
      font-size: 10px;
      position: absolute;
      width: 100%;
      top: -18px;
      font-weight: 600;
      color: rgb(238, 238, 238);
      text-align: right
    }
    span.progress_text {
      color: rgb(153, 153, 153);
      text-align: left
    }
  }
}
</style>
