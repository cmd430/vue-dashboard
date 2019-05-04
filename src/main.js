import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import mixins from './mixins'
import moment from 'vue-moment'

Vue.config.devtools = true
Vue.config.productionTip = false

Vue.use(moment)
Vue.use(mixins)

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
