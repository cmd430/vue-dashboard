<template>
  <div class="calendar">
    <div id="navigation">
      <button id="prev_month" v-on:click="setMonth(month.previous)">Previous Month</button>
      <h2 id="month">{{ month.name }}</h2>
      <button id="next_month" v-on:click="setMonth(month.next)">Next Month</button>
    </div>
    <h2>TV Shows</h2>
    <ul>
      <calendar-item
        v-for="show in shows"
        v-bind:key="show.id"
        v-bind:calendar_item="show"
        v-bind:type="'show'"
      />
    </ul>
    <h2>Movies</h2>
    <ul>
      <calendar-item
        v-for="movie in movies"
        v-bind:key="movie.id"
        v-bind:calendar_item="movie"
        v-bind:type="'movie'"
      />
    </ul>
  </div>
</template>

<script>
import Vue from 'vue'

import CalendarItem from '@/components/Calendar/CalendarItem'

export default {
  name: 'Calendar',
  components: {
    'calendar-item': CalendarItem
  },
  methods: {
    getShows: function () {
      fetch('/static/php/Calendar/shows.php?start=' + this.month.start + '&end=' + this.month.end)
        .then(response => {
          if (response.status !== 200) {
            return []
          }
          return response.json()
        })
        .then(shows => {
          shows.forEach(episode => {
            let status = {}
            if (episode.hasFile) {
              status.status_class = 'downloaded'
              status.status_text = this.$store.state.strings.downloaded
            } else if (episode.downloading) {
              status.status_class = 'downloading'
              status.status_text = this.$store.state.strings.downloading
            } else if (episode.airDateUtc < new Date().toISOString()) {
              if (new Date(new Date(episode.airDateUtc).getTime() + episode.series.runtime * 60000).toISOString() < new Date().toISOString()) {
                status.status_class = 'pending'
                status.status_text = this.$store.state.strings.pending
              } else {
                status.status_class = 'airing'
                status.status_text = this.$store.state.strings.onAir
              }
            } else {
              status.status_class = 'want'
              let now = new Date()
              let airTime = new Date(episode.airDateUtc)
              let diffMilliseconds = (airTime - now)
              let diffDays = Math.floor(diffMilliseconds / 86400000)
              let diffHours = Math.floor((diffMilliseconds % 86400000) / 3600000)
              let diffMinutes = Math.floor(((diffMilliseconds % 86400000) % 3600000) / 60000)
              if (diffDays === 0) {
                if (diffHours === 0) {
                  status.status_text = this.$store.state.strings.want.replace('??', diffMinutes + (diffMinutes > 1 ? ' Minutes' : ' Minute'))
                } else {
                  status.status_text = this.$store.state.strings.want.replace('??', diffHours + (diffHours > 1 ? ' Hours' : ' Hour'))
                }
              } else if (diffDays > 0) {
                status.status_text = this.$store.state.strings.want.replace('??', diffDays + (diffDays > 1 ? ' Days' : ' Day'))
              } else {
                return
              }
            }
            status.season_number = (episode.seasonNumber.toString().length > 1 ? episode.seasonNumber.toString() : '0' + episode.seasonNumber.toString())
            status.episode_number = (episode.episodeNumber.toString().length > 1 ? episode.episodeNumber.toString() : '0' + episode.episodeNumber.toString())
            status.episode_title = episode.title
            status.name = episode.series.title
            status.img_url = episode.series.images.filter(img => {
              return img.coverType === 'poster'
            })[0].url || ''
            status.id = episode.id
            if (this.shows !== [] && typeof this.shows.find(item => (item.id === status.id)) !== 'undefined') {
              Vue.set(this.shows, this.shows.findIndex(item => item.id === status.id), status)
            } else {
              if (this.shows.findIndex(item => (item.name === status.name && item.status_class === 'want')) === -1) {
                this.shows.push(status)
              }
            }
          })
        })
        .catch(err => {
          console.log(err)
        })
    },
    getMovies: function () {
      fetch('/static/php/Calendar/movies.php?start=' + this.month.start + '&end=' + this.month.end)
        .then(response => {
          if (response.status !== 200) {
            return []
          }
          return response.json()
        })
        .then(movies => {
          movies.forEach(movie => {
            let status = {}
            if (movie.hasFile) {
              status.status_class = 'downloaded'
              status.status_text = this.$store.state.strings.downloaded
            } else if (movie.downloading) {
              status.status_class = 'downloading'
              status.status_text = this.$store.state.strings.downloading
            } else if (movie.physicalRelease < new Date().toISOString()) {
              status.status_class = 'pending'
              status.status_text = this.$store.state.strings.pending
            } else {
              status.status_class = 'want'
              let now = new Date()
              let airTime = new Date(movie.physicalRelease)
              if (new Date(this.month.start).toLocaleString('en-nz', { month: 'long' }) !== new Date(movie.physicalRelease).toLocaleString('en-nz', { month: 'long' }) || typeof movie.physicalRelease === 'undefined') {
                return
              }
              let diffMilliseconds = (airTime - now)
              let diffDays = Math.floor(diffMilliseconds / 86400000)
              let diffHours = Math.floor((diffMilliseconds % 86400000) / 3600000)
              let diffMinutes = Math.floor(((diffMilliseconds % 86400000) % 3600000) / 60000)
              if (diffDays === 0) {
                if (diffHours === 0) {
                  status.status_text = this.$store.state.strings.want.replace('??', diffMinutes + (diffMinutes > 1 ? ' Minutes' : ' Minute'))
                } else {
                  status.status_text = this.$store.state.strings.want.replace('??', diffHours + (diffHours > 1 ? ' Hours' : ' Hour'))
                }
              } else if (diffDays > 0) {
                status.status_text = this.$store.state.strings.want.replace('??', diffDays + (diffDays > 1 ? ' Days' : ' Day'))
              } else {
                return
              }
            }
            status.name = movie.title
            status.img_url = movie.images.filter(img => {
              return img.coverType === 'poster'
            })[0].url || ''
            status.id = movie.id
            if (this.movies !== [] && typeof this.movies.find(item => (item.id === status.id)) !== 'undefined') {
              Vue.set(this.movies, this.movies.findIndex(item => item.id === status.id), status)
            } else {
              this.movies.push(status)
            }
          })
        })
        .catch(err => {
          console.log(err)
        })
    },
    setMonth: function (date) {
      let year = date.getFullYear()
      let month = date.getMonth()
      let start = new Date(year, month, 1).toISOString()
      let end = new Date(year, month + 1, 1).toISOString()
      let name = new Date(start).toLocaleString('en-nz', { month: 'long' })
      let previous = new Date(year, month - 1, 1)
      let next = new Date(year, month + 1, 1)
      this.month = {
        start: start,
        end: end,
        name: name,
        previous: previous,
        next: next
      }
      this.clearAll()
      this.getShows()
      this.getMovies()
    },
    clearAll: function () {
      this.shows = []
      this.movies = []
    }
  },
  data () {
    return {
      month: {},
      shows: [],
      movies: []
    }
  },
  created () {
    this.setMonth(new Date())
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
#navigation {
  position: absolute;
  width: 550px;
  right: 0;
  margin: 0 124px;
}
#prev_month,
#next_month {
  top: 0;
  width: 170px;
  position: absolute;
  display: inline-block;
  padding: 13px 16px;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: 1px;
  border: 0;
  font-size: 12px;
  line-height: 1.5;
  border-radius: 3px;
  border-color: rgb(204, 204, 204);
  color: rgb(255, 255, 255);
  background-color: rgba(255, 255, 255, 0.25);
  transition: background-color 100ms;
  cursor: pointer;
}
#prev_month:hover,
#next_month:hover {
  background-color: rgba(255, 255, 255, 0.3);
}
#prev_month {
  left: 0;
}
#next_month {
  right: 0;
}
#month {
  text-transform: uppercase;
  letter-spacing: 5px;
  font-size: 26px;
  font-weight: 400;
  text-align: center;
  margin: 0;
}
</style>
