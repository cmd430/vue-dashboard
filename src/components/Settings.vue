<template>
  <div id="settings">
    <h1>Settings</h1>
    <section id="home" class="left">
      <h4>Home Settings</h4>
      <div class="checkbox">
        <label>
          Show Activity
          <input type="checkbox" v-model="showActivity" />
          <span></span>
        </label>
      </div>
      <div class="checkbox">
        <label>
          Show Recently Watched
          <input type="checkbox" v-model="showHistory" />
          <span></span>
        </label>
      </div>
      <div class="checkbox">
        <label>
          Show Recently Added
          <input type="checkbox" v-model="showRecent" />
          <span></span>
        </label>
      </div>
    </section>
    <section id="calendar" class="center">
      <h4>Calendar Settings</h4>
      <div class="checkbox">
        <label>
          Hide Episodes and Movies that are '{{ this.$store.state.strings.downloaded }}'
          <input type="checkbox" v-model="showDownloaded" />
          <span></span>
        </label>
      </div>
      <div class="checkbox">
        <label>
          Only Show Next Unaired Episode
          <input type="checkbox" v-model="showNextUnairedOnly" />
          <span></span>
        </label>
      </div>
    </section>
    <section id="queue" class="right">
      <h4>Queue Settings</h4>
      <p>No Settings</p>
    </section>
  </div>
</template>

<script>
export default {
  name: 'Settings',
  metaInfo: {
    title: 'Settings'
  },
  components: {},
  methods: {},
  data () {
    return {}
  },
  computed: {
    showActivity: {
      get () {
        return this.$store.state.settings.showActivity
      },
      set (value) {
        this.$store.commit('showActivity', value)
      }
    },
    showHistory: {
      get () {
        return this.$store.state.settings.showHistory
      },
      set (value) {
        this.$store.commit('showHistory', value)
      }
    },
    showRecent: {
      get () {
        return this.$store.state.settings.showRecent
      },
      set (value) {
        this.$store.commit('showRecent', value)
      }
    },
    showDownloaded: {
      get () {
        return this.$store.state.settings.showDownloaded
      },
      set (value) {
        this.$store.commit('showDownloaded', value)
      }
    },
    showNextUnairedOnly: {
      get () {
        return this.$store.state.settings.showNextUnairedOnly
      },
      set (value) {
        this.$store.commit('showNextUnairedOnly', value)
      }
    }
  },
  created () {}
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
p {
  display: table;
  font-size: 12px;
  user-select: none;
  color: rgb(153, 153, 153);
  text-align: center;
  margin: 0;
}
div#settings {
  margin-bottom: 40px;
}
h1, h2, h4 {
  text-align: left;
  margin: 20px 107px;
  font-size: 28px;
  font-weight: 100;
  letter-spacing: 1px;
}
h4 {
  font-size: 18px;
  margin: 0 0 20px 0;
  left: -20px;
  position: relative;
}
section {
  width: 400px;
  margin-right: 20px;
  margin-bottom: 40px;
  display: inline-block;
  box-sizing: border-box;
  padding: 0 20px;
  position: relative;
}
section.left {
  margin-left: 147px;
}
/*
section.center {}
section.right {}
*/
section::before{
  content: '';
  background: rgba(0, 0, 0, 0.3);
  position: absolute;
  top: 40px;
  left: 0px;
  height: calc(100% - 30px);
  width: 100%;
  border-radius: 4px;
}
div.checkbox {
  position: relative;
  height: 20px;
  width: 100px;
}
div.checkbox:not(:last-child) {
  margin-bottom: 10px;
}
label {
  display: inline-block;
  position: absolute;
  padding-left: 25px;
  cursor: pointer;
  font-size: 12px;
  user-select: none;
  color: rgb(153, 153, 153);
  width: 250px;
}
label input[type=checkbox] {
  position: absolute;
  opacity: 0;
  cursor: pointer;
}
label span {
  position: absolute;
  top: 0;
  left: 0;
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
