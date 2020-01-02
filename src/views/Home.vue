<template>
  <div id="home" ref="home">
    <activity v-if="(this.$store.state.settings.showActivity === true)" />
    <history v-if="(this.$store.state.settings.showHistory === true)"/>
    <recent v-if="(this.$store.state.settings.showRecent === true)"/>
    <missing v-if="(this.$store.state.settings.showMissing === true)"/>
  </div>
</template>

<script>
import Activity from '@/components/Home/Activity'
import History from '@/components/Home/History'
import Recent from '@/components/Home/Recent'
import Missing from '@/components/Home/Missing'

export default {
  name: 'Home',
  meta: {
    title: 'Home'
  },
  components: {
    'activity': Activity,
    'history': History,
    'recent': Recent,
    'missing': Missing
  },
  data () {
    return {
      update: null
    }
  },
  methods: {
    updateCache: function () {
      this.$store.commit('maxHomeItems', Math.floor((this.$refs.home.getBoundingClientRect().width - (96 * 2)) / 190))
    }
  },
  mounted () {
    this.updateCache()
    this.update = setInterval(() => {
      this.updateCache()
    }, 5000)
  },
  beforeDestroy () {
    clearInterval(this.update)
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
