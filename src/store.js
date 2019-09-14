import Vue from 'vue'
import Vuex from 'vuex'
import createPersistedState from 'vuex-persistedstate'

Vue.use(Vuex)

export default new Vuex.Store({
  plugins: [
    createPersistedState({
      paths: [
        'settings'
      ]
    })
  ],
  state: {
    settings: {
      showActivity: true,
      showHistory: true,
      showRecent: true,
      showMissing: true,
      hideDownloaded: true,
      showNextUnairedOnly: true,
      alwaysShowToday: true,
      showCinemaRelease: false
    }
  },
  mutations: {
    showActivity (state, payload) {
      state.settings.showActivity = payload
    },
    showHistory (state, payload) {
      state.settings.showHistory = payload
    },
    showRecent (state, payload) {
      state.settings.showRecent = payload
    },
    showMissing (state, payload) {
      state.settings.showMissing = payload
    },
    hideDownloaded (state, payload) {
      state.settings.hideDownloaded = payload
    },
    showNextUnairedOnly (state, payload) {
      state.settings.showNextUnairedOnly = payload
    },
    alwaysShowToday (state, payload) {
      state.settings.alwaysShowToday = payload
    },
    showCinemaRelease (state, payload) {
      state.settings.showCinemaRelease = payload
    }
  },
  actions: {}
})
