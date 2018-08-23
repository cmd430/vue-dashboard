<template>
<li>
  <div class="bg_img" v-bind:style="{ 'background-image': 'url(' + activity_item.images.art + ')' }">
    <span>{{ activity_item.state }}</span>
  </div>
  <div class="img" v-bind:style="{ 'background-image': 'url(' + activity_item.images.poster + ')' }">
  </div>
  <div class="info" v-bind:data-type="activity_item.media_type">
    <p v-if="activity_item.media_type == 'episode'">
      <span>Series:</span>
      {{ activity_item.series.title }}
    </p>
    <p v-if="activity_item.media_type == 'episode'">
      <span>Episode Title:</span>
      {{ activity_item.series.episode_title }}
    </p>
    <p v-if="activity_item.media_type == 'episode'">
      <span>Season:</span>
      {{ activity_item.series.season }}
    </p>
    <p v-if="activity_item.media_type == 'episode'">
      <span>Episode:</span>
      {{ activity_item.series.episode }}
    </p>
    <p v-if="activity_item.media_type == 'movie'">
      <span>Movie Title:</span>
      {{ activity_item.title }}
    </p>
  </div>
  <div id="progress">
    <span class="text">{{ activity_item.progress_percent }}</span>
    <span class="progress" v-bind:style="{ 'width': activity_item.progress_percent }"></span>
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
  width: 480px;
  height: 270px;
  position: relative;
  box-sizing: content-box;
}
div.bg_img,
div.img {
  height: 270px;
  width: 480px;
  background:
    url(/img/placeholder.jpg),
  rgb(36, 36, 36);
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
}
.bg_img span {
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
div.img {
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
div.info {
  text-align: center;
  position: absolute;
  top: 95px;
  left: 162px;
  width: 318px;
  height: 114px;
}
div.info[data-type="movie"] {
  top: 145px;
}
.info p {
  margin: 5px 5px 5px 5px;
  overflow: hidden;
  white-space: nowrap;
  text-overflow: ellipsis;
  font-size: 13px;
  color: rgb(238, 238, 238);
}
.info p span {
  font-weight: 700;
  font-size: 12px;
  color: rgb(153, 153, 153);
}
div#progress {
  text-align: center;
  position: absolute;
  top: 260px;
  left: 162px;
  width: 318px;
  height: 8px;
  border-radius: 2px;
  background-color: rgba(0,0,0,.3);
}
div#progress span.progress {
  height: 100%;
  width: 0;
  border-radius: 2px;
  background-color: rgba(249, 190, 3, 0.5);
  position: absolute;
  top: 0;
  left: 0;
  transition: width 200ms;
}
#progress span.text {
  font-size: 14px;
  position: relative;
  width: 100%;
  height: 20px;
  top: -10px;
  font-weight: 600;
}
</style>
