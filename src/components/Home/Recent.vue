<template>
  <div class="recent">
    <h2>Recently Added</h2>
    <ul>
      <recent-item
        v-for="item in recent"
        v-bind:key="item.id"
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
      fetch('/php/Home/recent.php')
        .then(response => {
          if (response.status !== 200) {
            return []
          }
          return response.json()
        })
        .then(recentItems => {
          this.recent = []
          recentItems.forEach(recentItem => {
            let newRecentItem = recentItem
            newRecentItem.id = recentItem.added_at
            let seconds = Math.floor((new Date() - new Date(recentItem.added_at * 1000)) / 1000)
            let interval = Math.floor(seconds / 60)
            newRecentItem.added_at = Math.floor(seconds) + (seconds > 1 ? ' Seconds' : ' Second')
            if (interval >= 1) {
              newRecentItem.added_at = interval + (interval > 1 ? ' Minutes' : ' Minute')
            }
            interval = Math.floor(seconds / 3600)
            if (interval >= 1) {
              newRecentItem.added_at = interval + (interval > 1 ? ' Hours' : ' Hour')
            }
            interval = Math.floor(seconds / 86400)
            if (interval >= 1) {
              newRecentItem.added_at = interval + (interval > 1 ? ' Days' : ' Day')
            }
            interval = Math.floor(seconds / 604800)
            if (interval >= 1) {
              newRecentItem.added_at = interval + (interval > 1 ? ' Weeks' : ' Week')
            }
            interval = Math.floor(seconds / 2592000)
            if (interval >= 1) {
              newRecentItem.added_at = interval + (interval > 1 ? ' Months' : ' Month')
            }
            interval = Math.floor(seconds / 31536000)
            if (interval >= 1) {
              newRecentItem.added_at = interval + (interval > 1 ? ' Years' : ' Year')
            }
            newRecentItem.added_at = this.$store.state.strings.ago.replace('??', newRecentItem.added_at)
            if (this.recent !== [] && typeof this.recent.find(item => (item.id === newRecentItem.id)) !== 'undefined') {
              Vue.set(this.recent, this.recent.findIndex(item => item.id === newRecentItem.id), newRecentItem)
            } else {
              this.recent.push(newRecentItem)
            }
          })
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
    }, 30000)
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
