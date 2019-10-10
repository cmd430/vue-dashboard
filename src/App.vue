<template>
  <div id="app">
    <navigation display="header"/>
    <router-view/>
    <navigation display="footer"/>
  </div>
</template>

<script>
import Navigation from '@/components/Navigation.vue'

export default {
  name: 'Dashboard',
  components: {
    'navigation': Navigation
  }
}
</script>

<style lang="scss">
html, body {
  height: 100%;
  padding: 0;
  margin: 0;
}
body {
  font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;
  color: rgb(238, 238, 238);
  background:
    url('~@/assets/noise.png'),
    url('~@/assets/background.png') top left / cover no-repeat fixed,
    rgba(0, 0, 0, 0);
  line-height: 1.7;
  overflow: overlay;
  #app {
    box-sizing: border-box;
    min-height: 100%;
    padding: 0 0 50px;
    position: relative;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    cursor: default;
    user-select: none;
    h1 {
      text-align: left;
      margin: 20px 107px;
      font-size: 28px;
      font-weight: 100;
      letter-spacing: 1px;
    }
    h2 {
      text-align: left;
      margin: 0 0 20px 0;
      left: -20px;
      position: relative;
      font-size: 18px;
      font-weight: 100;
      letter-spacing: 1px;
    }
  }
}

@font-face {
  font-family: 'icons';
  src: url('~@/assets/icons.eot?83491505');
  src: url('~@/assets/icons.woff2?83491505') format('woff2'),
       url('~@/assets/icons.woff?83491505') format('woff'),
       url('~@/assets/icons.ttf?83491505') format('truetype');
  font-weight: normal;
  font-style: normal;
}
@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(359deg);
  }
}

[class^="icon-"] {
  &::before {
    font-family: "icons";
    font-style: normal;
    font-weight: normal;
    display: inline-block;
    text-decoration: inherit;
    width: 1em;
    margin-right: .2em;
    text-align: center;
    font-variant: normal;
    text-transform: none;
    line-height: 1em;
  }
  &.spin {
    animation: spin 2s infinite linear;
    display: inline-block;
  }
}
.icon-menu:before { content: '\e800'; }
.icon-th:before { content: '\e801'; }
.icon-hourglass:before { content: '\e802'; }
.icon-th-large:before { content: '\e803'; }
.icon-th-list:before { content: '\e804'; }
.icon-reload:before { content: '\e805'; }
.icon-upload:before { content: '\e806'; }
.icon-download:before { content: '\e807'; }
.icon-home:before { content: '\e808'; }
.icon-play:before { content: '\e80c'; }
.icon-pause:before { content: '\e80d'; }
.icon-warning:before { content: '\e80e'; }
.icon-calendar:before { content: '\e80f'; }
.icon-attention:before { content: '\e810'; }
.icon-cog:before { content: '\e813'; }
.icon-cancel:before { content: '\e816'; }
.icon-ok:before { content: '\e817'; }
.icon-info:before { content: '\e818'; }
.icon-chart-pie:before { content: '\e81a'; }
.icon-clock:before { content: '\e820'; }
.icon-reloading:before { content: '\e832'; }
.icon-down-open:before { content: '\f004'; }
.icon-up:before { content: '\f005'; }
.icon-right:before { content: '\f006'; }
.icon-left:before { content: '\f007'; }
.icon-github:before { content: '\f09b'; }
.icon-network:before { content: '\f20e'; }
.icon-television:before { content: '\f26c'; }
.icon-lock:before { content: '\f512'; }
.icon-unlock:before { content: '\f513'; }
</style>
