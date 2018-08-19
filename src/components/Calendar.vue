<template>
  <div class="calendar">
    <div id="navigation">
      <button id="prev_month" v-on:click="setMonth(month.previous)">Previous Month</button>
      <h2 id="month">{{ month.name }}</h2>
      <button id="next_month" v-on:click="setMonth(month.next)">Next Month</button>
      <label>
        Hide '{{strings.downloaded}}'
        <input type="checkbox" v-model="hideDownloaded" />
        <span></span>
      </label>
    </div>
    <h2>TV Shows</h2>
    <ul>
      <calendar-item
        v-for="show in shows"
        v-bind:key="show.id"
        v-bind:calendar_item="show"
        v-bind:type="'show'"
        v-bind:hideDownloaded="hideDownloaded"
      />
    </ul>
    <h2>Movies</h2>
    <ul>
      <calendar-item
        v-for="movie in movies"
        v-bind:key="movie.id"
        v-bind:calendar_item="movie"
        v-bind:type="'movie'"
        v-bind:hideDownloaded="hideDownloaded"
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
              status.status_text = this.strings.downloaded
            } else if (episode.downloading) {
              status.status_class = 'downloading'
              status.status_text = this.strings.downloading
            } else if (episode.airDateUtc < new Date().toISOString()) {
              if (new Date(new Date(episode.airDateUtc).getTime() + episode.series.runtime * 60000).toISOString() < new Date().toISOString()) {
                status.status_class = 'pending'
                status.status_text = this.strings.pending
              } else {
                status.status_class = 'airing'
                status.status_text = this.strings.onAir
              }
            } else {
              status.status_class = 'want'
              let now = new Date()
              let airTime = new Date(episode.airDateUtc)
              let diffMilliseconds = (airTime - now) // milliseconds between now & airTime
              let diffDays = Math.floor(diffMilliseconds / 86400000) // days
              let diffHours = Math.floor((diffMilliseconds % 86400000) / 3600000) // hours
              let diffMinutes = Math.floor(((diffMilliseconds % 86400000) % 3600000) / 60000) // minutes
              if (diffDays === 0) {
                if (diffHours === 0) {
                  status.status_text = this.strings.want.replace('??', diffMinutes + (diffMinutes > 1 ? ' Minutes' : ' Minute'))
                } else {
                  status.status_text = this.strings.want.replace('??', diffHours + (diffHours > 1 ? ' Hours' : ' Hour'))
                }
              } else if (diffDays > 0) {
                status.status_text = this.strings.want.replace('??', diffDays + (diffDays > 1 ? ' Days' : ' Day'))
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
              status.status_text = this.strings.downloaded
            } else if (movie.downloading) {
              status.status_class = 'downloading'
              status.status_text = this.strings.downloading
            } else if (movie.physicalRelease < new Date().toISOString()) {
              status.status_class = 'pending'
              status.status_text = this.strings.pending
            } else {
              status.status_class = 'want'
              let now = new Date()
              let airTime = new Date(movie.physicalRelease)
              let diffMilliseconds = (airTime - now) // milliseconds between now & airTime
              let diffDays = Math.floor(diffMilliseconds / 86400000) // days
              let diffHours = Math.floor((diffMilliseconds % 86400000) / 3600000) // hours
              let diffMinutes = Math.floor(((diffMilliseconds % 86400000) % 3600000) / 60000) // minutes
              if (diffDays === 0) {
                if (diffHours === 0) {
                  status.status_text = this.strings.want.replace('??', diffMinutes + (diffMinutes > 1 ? ' Minutes' : ' Minute'))
                } else {
                  status.status_text = this.strings.want.replace('??', diffHours + (diffHours > 1 ? ' Hours' : ' Hour'))
                }
              } else if (diffDays > 0) {
                status.status_text = this.strings.want.replace('??', diffDays + (diffDays > 1 ? ' Days' : ' Day'))
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
      movies: [],
      strings: {
        downloaded: 'In Plex',
        downloading: 'Downloading',
        pending: 'Pending',
        onAir: 'On Air',
        want: 'In ??'
      },
      hideDownloaded: true
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
label {
  display: inline-block;
  top: 12px;
  margin-left: -117px;
  position: absolute;
  padding-right: 25px;
  cursor: pointer;
  font-size: 12px;
  user-select: none;
}
label input[type=checkbox] {
  position: absolute;
  opacity: 0;
  cursor: pointer;
}
label span {
  position: absolute;
  top: 0;
  right: 0;
  height: 19px;
  width: 19px;
  border-radius: 3px;
  border-color: rgb(204, 204, 204);
  color: rgb(255, 255, 255);
  background-color: rgba(255, 255, 255, 0.25);
}
label:hover input[type=checkbox] ~ span {
  background-color: rgba(255, 255, 255, 0.3);
}
span::after {
  content: "";
  position: absolute;
  display: none;
}
label input[type=checkbox]:checked ~ span::after {
  display: block;
}
label span::after {
  left: 6px;
  top: 3px;
  width: 4px;
  height: 8px;
  border: solid rgb(238, 238, 238);
  border-width: 0 3px 3px 0;
  transform: rotate(40deg);
}
</style>
