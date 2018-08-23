<template>
  <div class="queue">
    <h2>Download Queue</h2>
    <ul>
      <queue-item
        v-for="item in queue"
        v-bind:key="item.id"
        v-bind:queue_item="item"
        v-bind:type="item.type"
      />
    </ul>
  </div>
</template>

<script>
import Vue from 'vue'
import QueueItem from '@/components/Queue/QueueItem'

export default {
  name: 'Queue',
  components: {
    'queue-item': QueueItem
  },
  methods: {
    processQueue: function (queueType) {
      fetch(`/static/php/Queue/${queueType}.php`)
        .then(response => {
          if (response.status !== 200) {
            return []
          }
          return response.json()
        })
        .then(queueItems => {
          let cache = []
          queueItems.forEach(queueItem => {
            let newQueueItem = {}
            newQueueItem.progress = Math.round((((queueItem.size - queueItem.sizeleft) / queueItem.size) * 100) * 10) / 10 + '%'
            if (newQueueItem.progress === 'NaN%') {
              newQueueItem.timeleft = this.$store.state.strings.calculating
              newQueueItem.progress = '0%'
            }
            if (queueItem.status === 'Queued') {
              newQueueItem.timeleft = this.$store.state.strings.queued
            } else if (queueItem.status === 'Downloading') {
              let seconds = Math.floor((new Date(queueItem.estimatedCompletionTime) - new Date()) / 1000)
              let interval = Math.floor(seconds / 60)
              if (Math.floor(seconds) > 5) {
                // If time is less than 5 Seconds we can assume its done
                // (status wont be Downloading...) or somthings wrong so we should show Calculating
                newQueueItem.timeleft = Math.floor(seconds) + ' Seconds'
              } else {
                newQueueItem.timeleft = this.$store.state.strings.calculating
              }
              if (interval >= 1) {
                newQueueItem.timeleft = interval + (interval > 1 ? ' Minutes' : ' Minute')
              }
              interval = Math.floor(seconds / 3600)
              if (interval >= 1) {
                newQueueItem.timeleft = interval + (interval > 1 ? ' Hours' : ' Hour')
              }
              interval = Math.floor(seconds / 86400)
              if (interval >= 1) {
                newQueueItem.timeleft = interval + (interval > 1 ? ' Days' : ' Day')
              }
              interval = Math.floor(seconds / 604800)
              if (interval >= 1) {
                newQueueItem.timeleft = interval + (interval > 1 ? ' Weeks' : ' Week')
              }
              interval = Math.floor(seconds / 2592000)
              if (interval >= 1) {
                newQueueItem.timeleft = interval + (interval > 1 ? ' Months' : ' Month')
              }
              interval = Math.floor(seconds / 31536000)
              if (interval >= 1) {
                newQueueItem.timeleft = interval + (interval > 1 ? ' Years' : ' Year')
              }
              if (newQueueItem.timeleft !== this.$store.state.strings.calculating && newQueueItem.timeleft !== this.$store.state.strings.queued) {
                newQueueItem.timeleft = this.$store.state.strings.eta.replace('??', newQueueItem.timeleft)
              }
            }
            newQueueItem.status = queueItem.status
            if (queueType === 'shows') {
              newQueueItem.season_number = (queueItem.episode.seasonNumber.toString().length > 1 ? queueItem.episode.seasonNumber.toString() : '0' + queueItem.episode.seasonNumber.toString())
              newQueueItem.episode_number = (queueItem.episode.episodeNumber.toString().length > 1 ? queueItem.episode.episodeNumber.toString() : '0' + queueItem.episode.episodeNumber.toString())
              newQueueItem.episode_title = queueItem.episode.title
              newQueueItem.name = queueItem.series.title
              newQueueItem.img_url = queueItem.series.images.filter(img => {
                return img.coverType === 'poster'
              })[0].url || ''
              newQueueItem.type = 'show'
            } else if (queueType === 'movies') {
              newQueueItem.name = queueItem.movie.title
              newQueueItem.img_url = queueItem.movie.images.filter(img => {
                return img.coverType === 'poster'
              })[0].url || ''
              newQueueItem.type = 'movie'
            }
            newQueueItem.id = queueItem.id
            cache.push(newQueueItem.id)
            if (this[queueType] !== [] && typeof this[queueType].find(item => (item.id === newQueueItem.id)) !== 'undefined') {
              Vue.set(this[queueType], this[queueType].findIndex(item => item.id === newQueueItem.id), newQueueItem)
            } else {
              this[queueType].push(newQueueItem)
            }
          })
          this[queueType].forEach(queueItem => {
            if (!cache.includes(queueItem.id)) {
              Vue.delete(this[queueType], this[queueType].findIndex(item => item.id === queueItem.id))
            }
          })
        })
        .catch(err => {
          console.log(err)
        })
    },
    clearAll: function () {
      this.shows = []
      this.movies = []
    }
  },
  data () {
    return {
      shows: [],
      movies: [],
      update: null
    }
  },
  computed: {
    queue () {
      let queue = this.shows.concat(this.movies)
      function compare (a, b) {
        if (parseInt(a.progress.replace('%', '')) > parseInt(b.progress.replace('%', ''))) {
          return -1
        }
        if (parseInt(a.progress.replace('%', '')) < parseInt(b.progress.replace('%', ''))) {
          return 1
        }
        return 0
      }
      return queue.sort(compare)
    }
  },
  created () {
    this.clearAll()
    this.processQueue('shows')
    this.processQueue('movies')
  },
  mounted () {
    this.update = setInterval(() => {
      console.log('Updating...')
      this.processQueue('shows')
      this.processQueue('movies')
    }, 30000)
  },
  beforeDestroy () {
    clearInterval(this.update)
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
