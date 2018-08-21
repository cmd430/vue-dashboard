<template>
  <div class="queue">
    <h2>Download Queue</h2>
    <ul>
      <queue-item
        v-for="show in shows"
        v-bind:key="show.id"
        v-bind:queue_item="show"
        v-bind:type="'show'"
      /><!-- Fix :empty not working... --><queue-item
        v-for="movie in movies"
        v-bind:key="movie.id"
        v-bind:queue_item="movie"
        v-bind:type="'movie'"
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
            let now = new Date()
            let estimatedCompletionTime = new Date(queueItem.estimatedCompletionTime)
            let diffMilliseconds = (estimatedCompletionTime - now)
            let diffDays = Math.floor(diffMilliseconds / 86400000)
            let diffHours = Math.floor((diffMilliseconds % 86400000) / 3600000)
            let diffMinutes = Math.floor(((diffMilliseconds % 86400000) % 3600000) / 60000)
            let diffSeconds = Math.floor((((diffMilliseconds % 86400000) % 3600000) % 3600000) / 60000)
            if (diffDays === 0) {
              if (diffHours === 0) {
                if (diffMinutes === 0) {
                  newQueueItem.timeleft = this.$store.state.strings.eta.replace('??', diffSeconds + (diffSeconds > 1 ? ' Seconds' : ' Second'))
                } else {
                  newQueueItem.timeleft = this.$store.state.strings.eta.replace('??', diffMinutes + (diffMinutes > 1 ? ' Minutes' : ' Minute'))
                }
              } else {
                newQueueItem.timeleft = this.$store.state.strings.eta.replace('??', diffHours + (diffHours > 1 ? ' Hours' : ' Hour'))
              }
            } else if (diffDays > 0) {
              newQueueItem.timeleft = this.$store.state.strings.eta.replace('??', diffDays + (diffDays > 1 ? ' Days' : ' Day'))
            }
            if (newQueueItem.progress === 'NaN%' || newQueueItem.progress === '0%') {
              newQueueItem.timeleft = this.$store.state.strings.calculating
              newQueueItem.progress = '0%'
            }
            if (typeof newQueueItem.timeleft === 'undefined' || diffSeconds === 0) {
              newQueueItem.timeleft = this.$store.state.strings.importing
            }
            if (queueType === 'shows') {
              newQueueItem.season_number = (queueItem.episode.seasonNumber.toString().length > 1 ? queueItem.episode.seasonNumber.toString() : '0' + queueItem.episode.seasonNumber.toString())
              newQueueItem.episode_number = (queueItem.episode.episodeNumber.toString().length > 1 ? queueItem.episode.episodeNumber.toString() : '0' + queueItem.episode.episodeNumber.toString())
              newQueueItem.episode_title = queueItem.episode.title
              newQueueItem.name = queueItem.series.title
              newQueueItem.img_url = queueItem.series.images.filter(img => {
                return img.coverType === 'poster'
              })[0].url || ''
            } else if (queueType === 'movies') {
              newQueueItem.name = queueItem.movie.title
              newQueueItem.img_url = queueItem.movie.images.filter(img => {
                return img.coverType === 'poster'
              })[0].url || ''
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
  content: 'Nothing to Show';
  width: 100%;
  font-size: 13px;
  color: rgb(153, 153, 153);
  text-align: center;
  padding: 15px;
  margin-left: 50%;
  transform: translateX(-50%);
}
</style>
