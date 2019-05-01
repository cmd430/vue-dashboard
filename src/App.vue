<template>
  <div id="app">
    <navigation/>
    <router-view/>
  </div>
</template>

<script>
import Navigation from '@/components/Navigation/Navigation.vue'

export default {
  name: 'App',
  components: {
    'navigation': Navigation
  },
  metaInfo: {
    title: '',
    titleTemplate: (titleChunk) => {
      return titleChunk ? `Dashboard | ${titleChunk}` : 'Dashboard'
    }
  },
  data () {
    return {}
  },
  methods: {}
}
</script>

<style lang="scss">
body {
  font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;
  color: rgb(238, 238, 238);
  background:
    url('~@/assets/noise.png'),
    url('~@/assets/background.png') top left / cover no-repeat fixed,
    rgba(0, 0, 0, 0);
  line-height: 1.7;
  overflow: overlay;
  width: 100%;
  height: 100%;
  padding: 0;
  margin: 0;
  #app {
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    cursor: default;
    user-select: none;
    h1, h2 {
      text-align: left;
      margin: 20px 107px;
      font-size: 28px;
      font-weight: 100;
      letter-spacing: 1px;
    }
  }
}
</style>
