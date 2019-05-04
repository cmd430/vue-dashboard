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
      showDownloaded: true,
      showNextUnairedOnly: true
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
    showDownloaded (state, payload) {
      state.settings.showDownloaded = payload
    },
    showNextUnairedOnly (state, payload) {
      state.settings.showNextUnairedOnly = payload
    }
  },
  actions: {}
})
