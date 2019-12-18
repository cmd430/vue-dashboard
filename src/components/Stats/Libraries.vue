<template>
<li>
  <section>
    <div>
      <p>Total Files: <span>{{ (libraries ? libraries.total.files : 0) }}</span></p>
      <p>Total Plays: <span>{{ (libraries ? libraries.total.plays : 0) }}</span></p>
      <p>Total Watch Time: <span>{{ (libraries ? libraries.total.time_watched : 0) | HumanizedDuration() }}</span></p>
    </div>
  </section>
  <section>
    <div>
      <p>TV Shows: <span>{{ (libraries ? libraries.shows.total.series : 0) }}</span></p>
      <p>TV Seasons: <span>{{ (libraries ? libraries.shows.total.seasons : 0) }}</span></p>
      <p>TV Episodes: <span>{{ (libraries ? libraries.shows.total.episodes : 0) }}</span></p>
      <p>Total Episodes Played: <span>{{ (libraries ? libraries.shows.plays : 0) }}</span></p>
      <p>Time Spent Watching TV Episodes: <span>{{ (libraries ? libraries.shows.time_watched : 0) | HumanizedDuration() }}</span></p>
    </div>
  </section>
  <section>
    <div>
      <p>Movies: <span>{{ (libraries ? libraries.movies.total : 0) }}</span></p>
      <p>Movies Played: <span>{{ (libraries ? libraries.movies.plays : 0) }}</span></p>
      <p>Time Spent Watching Movies: <span>{{ (libraries ? libraries.movies.time_watched : 0) | HumanizedDuration() }}</span></p>
    </div>
  </section>
</li>
</template>

<script>
export default {
  name: 'libraries',
  props: [
    'libraries'
  ]
}
</script>
