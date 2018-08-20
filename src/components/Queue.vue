<template>
  <div class="queue">
    <h2>Download Queue</h2>
    <ul>
      <queue-item
        v-for="show in shows"
        v-bind:key="show.id"
        v-bind:queue_item="show"
        v-bind:type="'show'"
      />
      <queue-item
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
    getShows: function () {
      fetch('/static/php/Queue/shows.php')
        .then(response => {
          if (response.status !== 200) {
            return []
          }
          return response.json()
        })
        .then(shows => {
          let cache = []
          shows.forEach(episode => {
            let status = {}
            status.progress = this.strings.downloading + ' ' + Math.round((((episode.size - episode.sizeleft) / episode.size) * 100) * 10) / 10 + '%'
            status.season_number = (episode.episode.seasonNumber.toString().length > 1 ? episode.episode.seasonNumber.toString() : '0' + episode.episode.seasonNumber.toString())
            status.episode_number = (episode.episode.episodeNumber.toString().length > 1 ? episode.episode.episodeNumber.toString() : '0' + episode.episode.episodeNumber.toString())
            status.episode_title = episode.episode.title
            status.name = episode.series.title
            status.img_url = episode.series.images.filter(img => {
              return img.coverType === 'poster'
            })[0].url || ''
            status.id = episode.id
            cache.push(status.id)
            if (this.shows !== [] && typeof this.shows.find(item => (item.id === status.id)) !== 'undefined') {
              Vue.set(this.shows, this.shows.findIndex(item => item.id === status.id), status)
            } else {
              this.shows.push(status)
            }
          })
          this.shows.forEach(show => {
            if (!cache.includes(show.id)) {
              Vue.delete(this.shows, this.shows.findIndex(item => item.id === show.id))
            }
          })
        })
        .catch(err => {
          console.log(err)
        })
    },
    getMovies: function () {
      fetch('/static/php/Queue/movies.php')
        .then(response => {
          if (response.status !== 200) {
            return []
          }
          return response.json()
        })
        .then(movies => {
          let cache = []
          movies.forEach(movie => {
            let status = {}
            status.progress = this.strings.downloading + ' ' + Math.round((((movie.size - movie.sizeleft) / movie.size) * 100) * 10) / 10 + '%'
            status.name = movie.title
            status.img_url = movie.images.filter(img => {
              return img.coverType === 'poster'
            })[0].url || ''
            status.id = movie.id
            cache.push(status.id)
            if (this.movies !== [] && typeof this.movies.find(item => (item.id === status.id)) !== 'undefined') {
              Vue.set(this.movies, this.movies.findIndex(item => item.id === status.id), status)
            } else {
              this.movies.push(status)
            }
          })
          this.movies.forEach(movie => {
            if (!cache.includes(movie.id)) {
              Vue.delete(this.movie, this.movie.findIndex(item => item.id === movie.id))
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
      strings: {
        downloading: ''
      }
    }
  },
  created () {
    this.clearAll()
    this.getShows()
    this.getMovies()
    setInterval(() => {
      console.log('Updating...')
      this.getShows()
      this.getMovies()
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
