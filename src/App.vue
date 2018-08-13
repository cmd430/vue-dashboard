<template>
<div id="app">
  <router-view/>
</div>
</template>

<script>
export default {
  name: 'App'
}
</script>

<style>
body{
  font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: rgb(238, 238, 238);
  background:
    url(./assets/noise.png),
    url(./assets/background.png) top left / cover no-repeat fixed,
    rgba(0, 0, 0, 0);
  line-height: 1.71428571;
  overflow: overlay;
  width: 100%;
  height: 100%;
  padding: 0;
  margin: 0;
  min-width: 953px;
}
#app {
  margin-top: 60px;
}
</style>
