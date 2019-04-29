<template>
  <div id="navigation">
    <ul class="left">
      <li>
        <router-link tag="li" to="/" exact>
          <i class="icon-home"></i>
          Home
        </router-link>
      </li>
      <li>
        <router-link tag="li" to="/calendar">
          <i class="icon-calendar"></i>
          Calendar
        </router-link>
      </li>
      <li>
        <router-link tag="li" to="/queue">
          <i class="icon-th-list"></i>
          Download Queue
        </router-link>
      </li>
    </ul>
    <ul class="right">
      <li>
        <router-link tag="li" to="/stats">
          <i class="icon-chart-pie"></i>
          Stats
        </router-link>
      </li>
      <li>
        <router-link tag="li" to="/settings">
          <i class="icon-cog"></i>
          Settings
        </router-link>
      </li>
    </ul>
  </div>
</template>

<script>
</script>

<style scoped>
div#navigation {
  top: 0;
  height: 54px;
  margin-bottom: 60px;
  background-color: rgba(0, 0, 0, 0.3);
}
ul {
  list-style-type: none;
  margin: 0;
  padding: 0 40px;
  position: absolute;
  display: inline-block;
}
ul.left {
  left: 0;
}
ul.right {
  right: 0;
}
li {
  cursor: pointer;
  display: inline-block;
  padding: 6px;
  line-height: 1.9;
  color: rgb(153, 153, 153);
  transition: color 100ms;
}
li:hover {
  color: rgb(238, 238, 238);
}
li.router-link-active,
li.router-link-exact-active {
  color: rgb(249, 190, 3);
}

@font-face {
  font-family: 'fontello';
  src: url('~@/assets/fontello.eot?96551581');
  src: url('~@/assets/fontello.ttf?96551581') format('truetype');
  font-weight: normal;
  font-style: normal;
}
[class^="icon-"]::before {
  font-family: "fontello";
  font-style: normal;
  font-weight: normal;
  display: inline-block;
  text-decoration: inherit;
  width: 1em;
  margin-right: .2em;
  text-align: center;
  font-variant: normal;
  text-transform: none;
  line-height: 1em;
}
.icon-th-outline:before { content: '\e800'; }
.icon-th:before { content: '\e801'; }
.icon-th-large-outline:before { content: '\e802'; }
.icon-th-large:before { content: '\e803'; }
.icon-th-list:before { content: '\e804'; }
.icon-th-list-outline:before { content: '\e805'; }
.icon-download-outline:before { content: '\e806'; }
.icon-download:before { content: '\e807'; }
.icon-home:before { content: '\e808'; }
.icon-home-outline:before { content: '\e809'; }
.icon-warning:before { content: '\e80a'; }
.icon-warning-empty:before { content: '\e80b'; }
.icon-ok:before { content: '\e80c'; }
.icon-ok-outline:before { content: '\e80d'; }
.icon-calendar-outline:before { content: '\e80e'; }
.icon-calendar:before { content: '\e80f'; }
.icon-videocam:before { content: '\e810'; }
.icon-videocam-outline:before { content: '\e811'; }
.icon-clock:before { content: '\e812'; }
.icon-cog:before { content: '\e813'; }
.icon-cog-outline:before { content: '\e814'; }
.icon-wrench-outline:before { content: '\e815'; }
.icon-wrench:before { content: '\e816'; }
.icon-info-outline:before { content: '\e817'; }
.icon-info:before { content: '\e818'; }
.icon-chart-pie-outline:before { content: '\e819'; }
.icon-chart-pie:before { content: '\e81a'; }
</style>
