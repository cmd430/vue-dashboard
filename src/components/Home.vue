<template>
  <div id="home">
    <activity/>
    <history/>
    <recent/>
  </div>
</template>

<script>
import Activity from '@/components/Home/Activity'
import History from '@/components/Home/History'
import Recent from '@/components/Home/Recent'

export default {
  name: 'Home',
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
