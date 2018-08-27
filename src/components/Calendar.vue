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
  metaInfo: {
    title: 'Calendar'
  },
  components: {
    'calendar-item': CalendarItem
  },
  methods: {
    processCalendar: function (calendarType) {
      fetch(`/static/php/Calendar/${calendarType}.php?start=${this.month.start}&end=${this.month.end}`)
        .then(response => {
          if (response.status !== 200) {
            return []
          }
          return response.json()
        })
        .then(calendarItems => {
          let cache = []
          calendarItems.forEach(calendarItem => {
            let newCalendarItem = {}
            let airTime
            if (calendarType === 'shows') {
              newCalendarItem.season_number = (calendarItem.seasonNumber.toString().length > 1 ? calendarItem.seasonNumber.toString() : '0' + calendarItem.seasonNumber.toString())
              newCalendarItem.episode_number = (calendarItem.episodeNumber.toString().length > 1 ? calendarItem.episodeNumber.toString() : '0' + calendarItem.episodeNumber.toString())
              newCalendarItem.episode_title = calendarItem.title
              newCalendarItem.name = calendarItem.series.title
              newCalendarItem.img_url = calendarItem.series.images.filter(img => {
                return img.coverType === 'poster'
              })[0].url || ''
              if (calendarItem.airDateUtc < new Date().toISOString()) {
                if (new Date(new Date(calendarItem.airDateUtc).getTime() + calendarItem.series.runtime * 60000).toISOString() < new Date().toISOString()) {
                  newCalendarItem.status_class = 'pending'
                  newCalendarItem.status_text = this.$store.state.strings.pending
                } else {
                  newCalendarItem.status_class = 'airing'
                  newCalendarItem.status_text = this.$store.state.strings.onAir
                }
              }
              airTime = new Date(calendarItem.airDateUtc)
            } else if (calendarType === 'movies') {
              newCalendarItem.name = calendarItem.title
              newCalendarItem.img_url = calendarItem.images.filter(img => {
                return img.coverType === 'poster'
              })[0].url || ''
              if (calendarItem.physicalRelease < new Date().toISOString()) {
                newCalendarItem.status_class = 'pending'
                newCalendarItem.status_text = this.$store.state.strings.pending
              }
              if (new Date(this.month.start).toLocaleString('en-nz', { month: 'long' }) !== new Date(calendarItem.physicalRelease).toLocaleString('en-nz', { month: 'long' }) || typeof calendarItem.physicalRelease === 'undefined') {
                return
              }
              airTime = new Date(calendarItem.physicalRelease)
            }
            if (calendarItem.hasFile) {
              newCalendarItem.status_class = 'downloaded'
              newCalendarItem.status_text = this.$store.state.strings.downloaded
            } else if (calendarItem.downloading) {
              newCalendarItem.status_class = 'downloading'
              newCalendarItem.status_text = this.$store.state.strings.downloading
            } else if (typeof newCalendarItem.status_text === 'undefined') {
              newCalendarItem.status_class = 'want'
              let seconds = Math.floor((airTime - new Date()) / 1000)
              let interval = Math.floor(seconds / 60)
              if (Math.floor(seconds) > -1) {
                newCalendarItem.status_text = Math.floor(seconds) + (seconds > 1 ? ' Seconds' : (seconds === 0 ? ' Seconds' : ' Second'))
              }
              if (interval >= 1) {
                newCalendarItem.status_text = interval + (interval > 1 ? ' Minutes' : ' Minute')
              }
              interval = Math.floor(seconds / 3600)
              if (interval >= 1) {
                newCalendarItem.status_text = interval + (interval > 1 ? ' Hours' : ' Hour')
              }
              interval = Math.floor(seconds / 86400)
              if (interval >= 1) {
                newCalendarItem.status_text = interval + (interval > 1 ? ' Days' : ' Day')
              }
              interval = Math.floor(seconds / 604800)
              if (interval >= 1) {
                newCalendarItem.status_text = interval + (interval > 1 ? ' Weeks' : ' Week')
              }
              newCalendarItem.status_text = this.$store.state.strings.want.replace('??', newCalendarItem.status_text)
            }
            newCalendarItem.id = calendarItem.id
            cache.push(newCalendarItem.id)
            if (this[calendarType] !== [] && typeof this[calendarType].find(item => (item.id === newCalendarItem.id)) !== 'undefined') {
              Vue.set(this[calendarType], this[calendarType].findIndex(item => item.id === newCalendarItem.id), newCalendarItem)
            } else {
              if (calendarType === 'shows') {
                if (this.shows.findIndex(item => (item.name === newCalendarItem.name && item.status_class === 'want')) === -1) {
                  this.shows.push(newCalendarItem)
                }
              } else if (calendarType === 'movies') {
                this.movies.push(newCalendarItem)
              }
            }
          })
          this[calendarType].forEach(calendarItem => {
            if (!cache.includes(calendarItem.id)) {
              Vue.delete(this[calendarType], this[calendarType].findIndex(item => item.id === calendarItem.id))
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
      this.processCalendar('shows')
      this.processCalendar('movies')
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
      update: null
    }
  },
  created () {
    this.setMonth(new Date())
  },
  mounted () {
    this.update = setInterval(() => {
      console.log('Updating...')
      this.processCalendar('shows')
      this.processCalendar('movies')
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
