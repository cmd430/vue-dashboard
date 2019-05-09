import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import filters from './filters'
import directives from './directives'
import moment from 'vue-moment'

Vue.config.devtools = true
Vue.config.productionTip = false

Vue.use(moment)
Vue.use(filters)
Vue.use(directives)

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
