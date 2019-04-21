<template>
<li>
  <section>
    <div>
      <p>Total Files: <span>{{ libraries.total.files }}</span></p>
      <p>Total Plays: <span>{{ libraries.total.plays }}</span></p>
      <p>Total Watch Time: <span>{{ friendlyUnit(libraries.total.time_watched) }}</span></p>
    </div>
  </section>
  <section>
    <div>
      <p>TV Shows: <span>{{ libraries.shows.total.series }}</span></p>
      <p>TV Seasons: <span>{{ libraries.shows.total.seasons }}</span></p>
      <p>TV Episodes: <span>{{ libraries.shows.total.episodes }}</span></p>
      <p>Total Episodes Played: <span>{{ libraries.shows.plays }}</span></p>
      <p>Time Spent Watching TV Episodes: <span>{{ friendlyUnit(libraries.shows.time_watched) }}</span></p>
    </div>
  </section>
  <section>
    <div>
      <p>Movies: <span>{{ libraries.movies.total }}</span></p>
      <p>Movies Played: <span>{{ libraries.movies.plays }}</span></p>
      <p>Time Spent Watching Movies: <span>{{ friendlyUnit(libraries.movies.time_watched) }}</span></p>
    </div>
  </section>
</li>
</template>

<script>
export default {
  name: 'libraries',
  props: [
    'libraries'
  ],
  methods: {
    friendlyUnit: function (seconds) {
      let levels = [
          [Math.floor(seconds / 31536000), 'years'],
          [Math.floor((seconds % 31536000) / 86400), 'days'],
          [Math.floor(((seconds % 31536000) % 86400) / 3600), 'hours'],
          [Math.floor((((seconds % 31536000) % 86400) % 3600) / 60), 'minutes'],
          [(((seconds % 31536000) % 86400) % 3600) % 60, 'seconds'],
      ]
      let returntext = ''
      for (let i = 0, max = levels.length; i < max; i++) {
          if ( levels[i][0] === 0 ) continue
          returntext += ' ' + levels[i][0] + ' ' + (levels[i][0] === 1 ? levels[i][1].substr(0, levels[i][1].length-1): levels[i][1])
      }
      return returntext.trim()
    }
  }
}
</script>
