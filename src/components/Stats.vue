<template>
  <div id="stats">
    <ul>
      <libraries v-bind:libraries="stats.libraries"/>
      <diskspace v-bind:diskspace="stats.diskspace"/>
      <bandwidth v-bind:bandwidth="stats.bandwidth"/>
    </ul>
  </div>
</template>

<script>
import Libraries from '@/components/Stats/Libraries'
import Diskspace from '@/components/Stats/Diskspace'
import Bandwidth from '@/components/Stats/Bandwidth'

export default {
  name: 'Stats',
  metaInfo: {
    title: 'Stats'
  },
  components: {
    'libraries': Libraries,
    'diskspace': Diskspace,
    'bandwidth': Bandwidth
  },
  methods: {
    showStats: function () {
      fetch(`/static/php/Stats/stats.php`)
        .then(response => {
          if (response.status !== 200) {
            return []
          }
          return response.json()
        })
        .then(statItems => {
          this.stats = statItems
        })
        .catch(err => {
          console.log(err)
        })
    }
  },
  data () {
    return {
      stats: [],
      update: null
    }
  },
  created () {
    this.showStats()
  },
  mounted () {
    this.update = setInterval(() => {
      console.log('Updating...')
      this.showStats()
    }, 1000)
  },
  beforeDestroy () {
    clearInterval(this.update)
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>
ul {
  display: flex;
  flex-wrap: wrap;
  align-items: stretch;
  justify-content: flex-start;
  padding: 0 96px;
  list-style-type: none;
}
ul:empty::after {
  content: "Nothing to Show";
  width: 100%;
  font-size: 13px;
  color: rgb(153, 153, 153);
  text-align: center;
  padding: 15px;
  margin: 0 27px 0 11px;
  background: rgba(0, 0, 0, 0.1);
  border-radius: 4px;
}
li {
  display: inline-block;
  padding: 10px;
  position: relative;
  box-sizing: content-box;
}
p {
  display: table;
  font-size: 16px;
  user-select: none;
  color: rgb(238, 238, 238);
  text-align: left;
  margin: 0;
}
span {
  text-align: center;
  color: rgb(153, 153, 153);
}
section {
  height: 135px;
  min-width: 300px;
  margin-right: 20px;
  margin-bottom: 20px;
  display: inline-block;
  padding: 20px;
  position: relative;
  vertical-align: text-top;
}
section::before{
  content: '';
  background: rgba(0, 0, 0, 0.3);
  position: absolute;
  left: 0;
  top: 0px;
  height: 100%;
  width: 100%;
  border-radius: 4px;
}
div {
  position: relative;
}
</style>
