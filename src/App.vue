<template>
<div id="app">
  <navigation/>
  <router-view/>
</div>
</template>

<script>
import Navigation from '@/components/Navigation'

export default {
  name: 'App',
  components: {
    'navigation': Navigation
  }
}
</script>

<style>
* {
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  cursor: default;
  user-select: none;
}
body {
  font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
  color: rgb(238, 238, 238);
  background:
    url(./assets/noise.png),
    url(./assets/background.png) top left / cover no-repeat fixed,
    rgba(0, 0, 0, 0);
  line-height: 1.7;
  overflow: overlay;
  width: 100%;
  height: 100%;
  padding: 0;
  margin: 0;
}
@font-face {
  font-family: 'fontello';
  src: url('./assets/font/fontello.eot?96551581');
  src: url('./assets/font/fontello.ttf?96551581') format('truetype');
  font-weight: normal;
  font-style: normal;
}
[class^="icon-"]::before {
  font-family: "fontello";
  font-style: normal;
  font-weight: normal;
  speak: none;
  display: inline-block;
  text-decoration: inherit;
  width: 1em;
  margin-right: .2em;
  text-align: center;
  font-variant: normal;
  text-transform: none;
  line-height: 1em;
}

.icon-th-outline:before { content: '\e800'; }
.icon-th:before { content: '\e801'; }
.icon-th-large-outline:before { content: '\e802'; }
.icon-th-large:before { content: '\e803'; }
.icon-th-list:before { content: '\e804'; }
.icon-th-list-outline:before { content: '\e805'; }
.icon-download-outline:before { content: '\e806'; }
.icon-download:before { content: '\e807'; }
.icon-home:before { content: '\e808'; }
.icon-home-outline:before { content: '\e809'; }
.icon-warning:before { content: '\e80a'; }
.icon-warning-empty:before { content: '\e80b'; }
.icon-ok:before { content: '\e80c'; }
.icon-ok-outline:before { content: '\e80d'; }
.icon-calendar-outline:before { content: '\e80e'; }
.icon-calendar:before { content: '\e80f'; }
.icon-videocam:before { content: '\e810'; }
.icon-videocam-outline:before { content: '\e811'; }
.icon-clock:before { content: '\e812'; }
.icon-cog:before { content: '\e813'; }
.icon-cog-outline:before { content: '\e814'; }
.icon-wrench-outline:before { content: '\e815'; }
.icon-wrench:before { content: '\e816'; }
.icon-info-outline:before { content: '\e817'; }
.icon-info:before { content: '\e818'; }
.icon-chart-pie-outline:before { content: '\e819'; }
.icon-chart-pie:before { content: '\e81a'; }
</style>
