<template>
  <div id="settings">
    <h1>Settings</h1>
    <div class="wrapper">
      <section id="home">
        <h2>Home Settings</h2>
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
        <div class="checkbox">
          <label>
            Show Missing Items
            <input type="checkbox" v-model="showMissing" />
            <span></span>
          </label>
        </div>
      </section>
      <section id="calendar">
        <h2>Calendar Settings</h2>
        <div class="checkbox">
          <label>
            Hide Episodes and Movies that are 'In Plex'
            <input type="checkbox" v-model="hideDownloaded" />
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
        <div class="checkbox">
          <label>
            Always Show Todays Episodes
            <input type="checkbox" v-model="alwaysShowToday" />
            <span></span>
          </label>
        </div>
        <div class="checkbox">
          <label>
            Show Movie Cinema Release
            <input type="checkbox" v-model="showCinemaRelease" />
            <span></span>
          </label>
        </div>
        <div class="checkbox">
          <label>
            Use Relative Date (Temporarily Toggle with 'Tab')
            <input type="checkbox" v-model="relativeCaldendar" />
            <span></span>
          </label>
        </div>
      </section>
      <section id="queue">
        <h2>Queue Settings</h2>
        <div class="checkbox">
          <label>
            Show stalled downloads
            <input type="checkbox" v-model="showStalled" />
            <span></span>
          </label>
        </div>
      </section>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Settings',
  meta: {
    title: 'Settings'
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
    showMissing: {
      get () {
        return this.$store.state.settings.showMissing
      },
      set (value) {
        this.$store.commit('showMissing', value)
      }
    },
    hideDownloaded: {
      get () {
        return this.$store.state.settings.hideDownloaded
      },
      set (value) {
        this.$store.commit('hideDownloaded', value)
      }
    },
    showNextUnairedOnly: {
      get () {
        return this.$store.state.settings.showNextUnairedOnly
      },
      set (value) {
        this.$store.commit('showNextUnairedOnly', value)
      }
    },
    alwaysShowToday: {
      get () {
        return this.$store.state.settings.alwaysShowToday
      },
      set (value) {
        this.$store.commit('alwaysShowToday', value)
      }
    },
    showCinemaRelease: {
      get () {
        return this.$store.state.settings.showCinemaRelease
      },
      set (value) {
        this.$store.commit('showCinemaRelease', value)
      }
    },
    relativeCaldendar: {
      get () {
        return this.$store.state.settings.relativeCaldendar
      },
      set (value) {
        this.$store.commit('relativeCaldendar', value)
      }
    },
    showStalled: {
      get () {
        return this.$store.state.settings.showStalled
      },
      set (value) {
        this.$store.commit('showStalled', value)
      }
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
div {
  #settings {
    margin-bottom: 40px;
  }
  .wrapper {
    padding: 0 147px;
  }
  .checkbox {
    position: relative;
    height: 20px;
    &:not(:last-child) {
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
      max-width: 335px;
      input[type=checkbox] {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        &:checked ~ span::after {
          display: block;
        }
      }
      &:hover input[type=checkbox] ~ span {
        background-color: rgba(255, 255, 255, 0.3);
      }
      span {
        position: absolute;
        top: 0;
        left: 0;
        height: 19px;
        width: 19px;
        border-radius: 3px;
        border-color: rgb(204, 204, 204);
        color: rgb(255, 255, 255);
        background-color: rgba(255, 255, 255, 0.25);
        &::after {
          content: '';
          position: absolute;
          display: none;
          left: 6px;
          top: 3px;
          width: 4px;
          height: 8px;
          border: solid rgb(238, 238, 238);
          border-width: 0 3px 3px 0;
          transform: rotate(40deg);
        }
      }
    }
  }
}
section {
  width: 400px;
  margin-right: 20px;
  margin-bottom: 40px;
  display: inline-block;
  box-sizing: border-box;
  padding: 0 20px;
  position: relative;
  &::before{
    content: '';
    background: rgba(0, 0, 0, 0.3);
    position: absolute;
    top: 40px;
    left: 0px;
    height: calc(100% - 30px);
    width: 100%;
    border-radius: 4px;
  }
  p {
    display: table;
    font-size: 12px;
    user-select: none;
    color: rgb(153, 153, 153);
    text-align: center;
    margin: 0;
  }
}
</style>
