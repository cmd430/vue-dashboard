<template>
  <div class="calendar">
    <div id="navigation">
      <button id="prev_month" @click="setMonth(month.previous)" title="Previous Month">
        <i class="icon-left"></i>
      </button>
      <h1 id="month" @click="setMonth(new Date())" title="Return to Current Month">{{ month.name }}</h1>
      <button id="next_month" @click="setMonth(month.next)" title="Next Month">
        <i class="icon-right"></i>
      </button>
    </div>
    <h1>TV Shows</h1>
    <ul>
      <calendar-item
        v-for="show in calendar.series"
        :key="show.id"
        :calendar="show"
        :month="month"
        :display="display"
      />
    </ul>
    <h1>Movies</h1>
    <ul>
      <calendar-item
        v-for="movie in calendar.movies"
        :key="movie.id"
        :calendar="movie"
        :month="month"
        :display="display"
      />
    </ul>
  </div>
</template>

<script>
import CalendarItem from '@/components/CalendarItem'

const nonRelativeDateFormat = 'ddd D, h:mm a' // Thu 10, 3:00 pm

export default {
  name: 'Calendar',
  meta: {
    title: 'Calendar'
  },
  components: {
    'calendar-item': CalendarItem
  },
  data () {
    return {
      month: {},
      calendar: {
        series: null,
        movies: null
      },
      display: this.$store.state.settings.relativeCaldendar ? 'relative' : nonRelativeDateFormat,
      update: null
    }
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
    },
    toggleDisplay (e) {
      if (e.key === 'Tab') {
        e.preventDefault()
        if (this.display === 'relative') {
          this.display = nonRelativeDateFormat
        } else {
          this.display = 'relative'
        }
      }
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
    document.addEventListener('keydown', this.toggleDisplay)
  },
  beforeDestroy () {
    clearInterval(this.update)
    document.removeEventListener('keydown', this.toggleDisplay)
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
    &.movie {
      height: 321px
    }
  }
}
#navigation {
  position: absolute;
  width: 350px;
  right: 0;
  margin: 0 124px;
  #month,
  #prev_month,
  #next_month {
    color: rgb(153, 153, 153);
    &:hover {
      color: rgb(238, 238, 238);
    }
    &:active {
      color: rgb(249, 190, 3);
    }
  }
  #month {
    position: relative;
    left: 50%;
    transform: translateX(-50%);
    margin: 0;
    display: inline-block;
    cursor: pointer;
    text-transform: uppercase;
    letter-spacing: 5px;
    font-size: 26px;
    font-weight: 400;
  }
  #prev_month,
  #next_month {
    top: 0;
    position: absolute;
    display: inline-block;
    font-weight: 800;
    letter-spacing: 1px;
    line-height: 1.6;
    border: 0;
    font-size: 26px;
    background-color: rgba(0, 0, 0, 0);
    transition: color 100ms;
    cursor: pointer;
    outline: none;
  }
  #prev_month {
    left: 0;
  }
  #next_month {
    right: 0;
    text-align: right;
    letter-spacing: -10px;
  }
}
</style>
