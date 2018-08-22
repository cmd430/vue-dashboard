<template>
  <div class="history">
    <h2>Recent Plays</h2>
    <ul>
      <history-item
        v-for="item in history"
        v-bind:key="item.id"
        v-bind:history_item="item"
      />
    </ul>
  </div>
</template>

<script>
import Vue from 'vue'
import HistoryItem from '@/components/Home/History/HistoryItem'

export default {
  name: 'History',
  components: {
    'history-item': HistoryItem
  },
  methods: {
    processHistory: function () {
      fetch('/static/php/Home/history.php')
        .then(response => {
          if (response.status !== 200) {
            return []
          }
          return response.json()
        })
        .then(historyItems => {
          historyItems.forEach(historyItem => {
            let newHistoryItem = historyItem
            newHistoryItem.id = historyItem.id
            let seconds = Math.floor((new Date() - new Date(historyItem.last_watch * 1000)) / 1000)
            let interval = Math.floor(seconds / 60)
            newHistoryItem.last_watch = Math.floor(seconds) + (seconds > 1 ? ' Seconds' : ' Second')
            if (interval >= 1) {
              newHistoryItem.last_watch = interval + (interval > 1 ? ' Minutes' : ' Minute')
            }
            interval = Math.floor(seconds / 3600)
            if (interval >= 1) {
              newHistoryItem.last_watch = interval + (interval > 1 ? ' Hours' : ' Hour')
            }
            interval = Math.floor(seconds / 86400)
            if (interval >= 1) {
              newHistoryItem.last_watch = interval + (interval > 1 ? ' Days' : ' Day')
            }
            interval = Math.floor(seconds / 604800)
            if (interval >= 1) {
              newHistoryItem.last_watch = interval + (interval > 1 ? ' Weeks' : ' Week')
            }
            interval = Math.floor(seconds / 2592000)
            if (interval >= 1) {
              newHistoryItem.last_watch = interval + (interval > 1 ? ' Months' : ' Month')
            }
            interval = Math.floor(seconds / 31536000)
            if (interval >= 1) {
              newHistoryItem.last_watch = interval + (interval > 1 ? ' Years' : ' Year')
            }
            newHistoryItem.last_watch = newHistoryItem.last_watch + ' Ago'
            if (this.history !== [] && typeof this.history.find(item => (item.id === newHistoryItem.id)) !== 'undefined') {
              Vue.set(this.history, this.history.findIndex(item => item.id === newHistoryItem.id), newHistoryItem)
            } else {
              this.history.push(newHistoryItem)
            }
          })
        })
        .catch(err => {
          console.log(err)
        })
    },
    clearAll: function () {
      this.history = []
    }
  },
  data () {
    return {
      history: [],
      update: null
    }
  },
  created () {
    this.clearAll()
    this.processHistory()
  },
  mounted () {
    this.update = setInterval(() => {
      console.log('Updating...')
      this.processHistory()
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
