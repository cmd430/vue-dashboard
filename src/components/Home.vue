<template>
  <div id="home">
    <activity/>
    <history/>
    <recent/>
    <queue/>
  </div>
</template>

<script>
import Activity from '@/components/Home/Activity'
import History from '@/components/Home/History'
import Recent from '@/components/Home/Recent'
import Queue from '@/components/Queue'

export default {
  name: 'Home',
  components: {
    'activity': Activity,
    'history': History,
    'recent': Recent,
    'queue': Queue
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
