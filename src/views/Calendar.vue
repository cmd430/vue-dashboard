<template>
  <div class="calendar">
    <div id="navigation">
      <button id="prev_month" @click="setMonth(month.previous)">Previous Month</button>
      <h1 id="month" @click="setMonth(new Date())">{{ month.name }}</h1>
      <button id="next_month" @click="setMonth(month.next)">Next Month</button>
    </div>
    <h1>TV Shows</h1>
    <ul>
      <calendar-item
        v-for="show in calendar.series"
        :key="show.id"
        :calendar="show"
      />
    </ul>
    <h1>Movies</h1>
    <ul>
      <calendar-item
        v-for="movie in calendar.movies"
        :key="movie.id"
        :calendar="movie"
      />
    </ul>
  </div>
</template>

<script>
import CalendarItem from '@/components/CalendarItem'

export default {
  name: 'Calendar',
  metaInfo: {
    title: 'Calendar'
  },
  components: {
    'calendar-item': CalendarItem
  },
  methods: {
    processCalendar: function () {
      fetch(`/php/calendar.php?start=${this.month.start}&end=${this.month.end}`)
        .then(response => {
          if (response.status !== 200) {
            return []
          }
          return response.json()
        })
        .then(calendar => {
          this.calendar = calendar
        })
        .catch(err => {
          console.error('[Calendar]', err)
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
      this.processCalendar()
    }
  },
  data () {
    return {
      month: {},
      calendar: {
        series: null,
        movies: null
      },
      update: null
    }
  },
  created () {
    this.setMonth(new Date())
  },
  mounted () {
    this.update = setInterval(() => {
      console.log('[Calendar] Updating...')
      this.processCalendar()
    }, 30000)
  },
  beforeDestroy () {
    clearInterval(this.update)
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
ul {
  display: flex;
  flex-wrap: wrap;
  align-items: stretch;
  justify-content: flex-start;
  padding: 0 96px;
  list-style-type: none;
  &:empty::after {
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
  &::v-deep li { /* use ::v-deep to select child componets */
    display: inline-block;
    padding: 10px;
    box-sizing: border-box;
    width: 190px;
    height: 351px;
  }
}
#navigation {
  position: absolute;
  width: 550px;
  right: 0;
  margin: 0 124px;
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
    &:hover {
      background-color: rgba(255, 255, 255, 0.3);
    }
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
    cursor: pointer;
  }
}
</style>
