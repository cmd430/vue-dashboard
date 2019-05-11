<template>
  <div id="home">
    <activity v-if="(this.$store.state.settings.showActivity === true)" />
    <history v-if="(this.$store.state.settings.showHistory === true)"/>
    <recent v-if="(this.$store.state.settings.showRecent === true)"/>
  </div>
</template>

<script>
import Activity from '@/components/Home/Activity'
import History from '@/components/Home/History'
import Recent from '@/components/Home/Recent'

export default {
  name: 'Home',
  meta: {
    title: 'Home'
  },
  components: {
    'activity': Activity,
    'history': History,
    'recent': Recent
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
