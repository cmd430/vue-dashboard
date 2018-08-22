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
      showDownloaded: true
    },
    strings: {
      downloaded: 'In Plex',
      downloading: 'Downloading',
      pending: 'Pending',
      onAir: 'On Air',
      want: 'In ??',
      calculating: 'Calculating',
      queued: 'Queued',
      eta: 'In About ??',
      importing: 'Importing'
    }
  },
  mutations: {
    showDownloaded (state, payload) {
      state.settings.showDownloaded = payload
    }
  }
})
