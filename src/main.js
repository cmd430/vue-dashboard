import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import filters from './filters'
import directives from './directives'
import moment from 'vue-moment'
import meta from 'vue-meta'

Vue.config.devtools = true
Vue.config.productionTip = false

Vue.use(meta, {
  keyName: 'meta'
})
Vue.use(moment)
Vue.use(filters)
Vue.use(directives)

new Vue({
  router,
  store,
  meta: {
    titleTemplate: chunk => (chunk ? `${App.name} | ${chunk}` : `${App.name}`)
  },
  render: h => h(App)
}).$mount('#app')
