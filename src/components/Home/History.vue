<template>
  <div class="history">
    <h2>History</h2>
    <ul>
      <history-item
        v-for="item in history"
        v-bind:key="item"
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
          // TODO
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
