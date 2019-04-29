<template>
<li>
  <section>
    <div>
      <p>Total Files: <span>{{ libraries.total.files }}</span></p>
      <p>Total Plays: <span>{{ libraries.total.plays }}</span></p>
      <p>Total Watch Time: <span>{{ friendlyTimeUnit(libraries.total.time_watched) }}</span></p>
    </div>
  </section>
  <section>
    <div>
      <p>TV Shows: <span>{{ libraries.shows.total.series }}</span></p>
      <p>TV Seasons: <span>{{ libraries.shows.total.seasons }}</span></p>
      <p>TV Episodes: <span>{{ libraries.shows.total.episodes }}</span></p>
      <p>Total Episodes Played: <span>{{ libraries.shows.plays }}</span></p>
      <p>Time Spent Watching TV Episodes: <span>{{ friendlyTimeUnit(libraries.shows.time_watched) }}</span></p>
    </div>
  </section>
  <section>
    <div>
      <p>Movies: <span>{{ libraries.movies.total }}</span></p>
      <p>Movies Played: <span>{{ libraries.movies.plays }}</span></p>
      <p>Time Spent Watching Movies: <span>{{ friendlyTimeUnit(libraries.movies.time_watched) }}</span></p>
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

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
li {
  display: inline-block;
  padding: 10px;
  position: relative;
  box-sizing: content-box;
}
p {
  display: table;
  font-size: 16px;
  user-select: none;
  color: rgb(238, 238, 238);
  text-align: left;
  margin: 0;
}
span {
  text-align: center;
  color: rgb(153, 153, 153);
}
section {
  height: 135px;
  min-width: 300px;
  margin-right: 20px;
  margin-bottom: 20px;
  display: inline-block;
  padding: 20px;
  position: relative;
  vertical-align: text-top;
}
section::before{
  content: '';
  background: rgba(0, 0, 0, 0.3);
  position: absolute;
  left: 0;
  top: 0px;
  height: 100%;
  width: 100%;
  border-radius: 4px;
}
div {
  position: relative;
}
</style>
