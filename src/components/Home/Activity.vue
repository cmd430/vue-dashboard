<template>
  <div class="activity">
    <h2>Current Activity</h2>
    <ul>
      <activity-item
        v-for="item in activity"
        v-bind:key="item.id"
        v-bind:activity_item="item"
      />
    </ul>
  </div>
</template>

<script>
import Vue from 'vue'
import ActivityItem from '@/components/Home/Activity/ActivityItem'

export default {
  name: 'Activity',
  components: {
    'activity-item': ActivityItem
  },
  methods: {
    processActivity: function () {
      fetch('/static/php/Home/activity.php')
        .then(response => {
          if (response.status !== 200) {
            return []
          }
          return response.json()
        })
        .then(activityItems => {
          let cache = []
          activityItems.forEach(activityItem => {
            let newActivityItem = activityItem
            cache.push(newActivityItem.id)
            let runtimeMS = newActivityItem.playback.runtime_ms
            let rHour = Math.floor(runtimeMS / (1000 * 60 * 60)).toString()
            let rMin = Math.floor(runtimeMS / (1000 * 60)).toString()
            let rSec = Math.floor((runtimeMS % (60 * 1000)) / 1000).toString()
            rHour = (rHour === '0' ? '' : (rHour.length === 2 ? rHour : '0' + rHour) + ':')
            rMin = (rMin.length === 2 ? rMin : '0' + rMin) + ':'
            rSec = (rSec.length === 2 ? rSec : '0' + rSec)
            let progressMS = newActivityItem.playback.progress_ms
            let pHour = Math.floor(progressMS / (1000 * 60 * 60)).toString()
            let pMin = Math.floor(progressMS / (1000 * 60)).toString()
            let pSec = Math.floor((progressMS % (60 * 1000)) / 1000).toString()
            pHour = (rHour === '' ? '' : (pHour.length === 2 ? pHour : '0' + pHour) + ':')
            pMin = (pMin.length === 2 ? pMin : '0' + pMin) + ':'
            pSec = (pSec.length === 2 ? pSec : '0' + pSec)
            newActivityItem.playback.progress_text = pHour + pMin + pSec
            newActivityItem.playback.duration_text = rHour + rMin + rSec
            if (this.activity !== [] && typeof this.activity.find(item => (item.id === newActivityItem.id)) !== 'undefined') {
              Vue.set(this.activity, this.activity.findIndex(item => item.id === newActivityItem.id), newActivityItem)
            } else {
              this.activity.push(newActivityItem)
            }
          })
          this.activity.forEach(activityItem => {
            if (!cache.includes(activityItem.id)) {
              Vue.delete(this.activity, this.activity.findIndex(item => item.id === activityItem.id))
            }
          })
        })
        .catch(err => {
          console.log(err)
        })
    },
    clearAll: function () {
      this.activity = []
    }
  },
  data () {
    return {
      activity: [],
      update: null
    }
  },
  created () {
    this.clearAll()
    this.processActivity()
  },
  mounted () {
    this.update = setInterval(() => {
      console.log('Updating...')
      this.processActivity()
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
