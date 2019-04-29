import Vue from 'vue'
import Meta from 'vue-meta'
import Router from 'vue-router'
import Home from './views/Home.vue'

Vue.use(Meta)
Vue.use(Router)

export default new Router({
  mode: 'history',
  base: process.env.BASE_URL,
  routes: [
    {
      path: '/',
      name: 'home',
      component: Home
    },
    {
      path: '/calendar',
      name: 'calendar',
      // route level code-splitting
      // this generates a separate chunk (about.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import(/* webpackChunkName: "calendar" */ './views/Calendar.vue')
    },
    {
      path: '/queue',
      name: 'queue',
      component: () => import(/* webpackChunkName: "queue" */ './views/Queue.vue')
    },
    {
      path: '/stats',
      name: 'stats',
      component: () => import(/* webpackChunkName: "stats" */ './views/Stats.vue')
    },
    {
      path: '/settings',
      name: 'settings',
      component: () => import(/* webpackChunkName: "settings" */ './views/Settings.vue')
    },
    {
      path: '/*',
      name: 'error',
      component: () => import(/* webpackChunkName: "error" */ './views/Error.vue')
    }
  ]
})
