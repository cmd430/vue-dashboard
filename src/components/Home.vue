<template>
  <div id="home">
    <calendar/>
    <queue/>
  </div>
</template>

<script>
import Calendar from '@/components/Calendar'
import Queue from '@/components/Queue'

export default {
  name: 'Home',
  components: {
    'calendar': Calendar,
    'queue': Queue
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
