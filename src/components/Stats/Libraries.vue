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
