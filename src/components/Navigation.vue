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
      <router-link tag="li" to="/settings">
        <i class="icon-cog"></i>
        Settings
      </router-link>
    </li>
    <li v-show="false"> <!-- Disabled for now -->
      <router-link tag="li" to="/about">
        <i class="icon-info"></i>
        About
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
</style>
