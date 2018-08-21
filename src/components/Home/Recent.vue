<template>
  <div class="activity">
    <h2>Recent</h2>
    <ul>
      <recent-item
        v-for="item in recent"
        v-bind:key="item"
        v-bind:recent_item="item"
      />
    </ul>
  </div>
</template>

<script>
import Vue from 'vue'
import RecentItem from '@/components/Home/Recent/RecentItem'

export default {
  name: 'Recent',
  components: {
    'recent-item': RecentItem
  },
  methods: {
    processRecent: function () {
      fetch('/static/php/Home/recent.php')
        .then(response => {
          if (response.status !== 200) {
            return []
          }
          return response.json()
        })
        .then(recentItems => {
          // TODO
        })
        .catch(err => {
          console.log(err)
        })
    },
    clearAll: function () {
      this.recent = []
    }
  },
  data () {
    return {
      recent: [],
      update: null
    }
  },
  created () {
    this.clearAll()
    this.processRecent()
  },
  mounted () {
    this.update = setInterval(() => {
      console.log('Updating...')
      this.processRecent()
    }, 5000)
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h1, h2 {
  text-align: left;
  margin: 20px 107px;
  font-size: 28px;
  font-weight: 100;
  letter-spacing: 1px;
}
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
</style>
