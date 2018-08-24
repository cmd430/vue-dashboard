import Vue from 'vue'
import Router from 'vue-router'
import Home from '@/components/Home'
import Calendar from '@/components/Calendar'
import Queue from '@/components/Queue'
import Stats from '@/components/Stats'
import Settings from '@/components/Settings'

Vue.use(Router)

export default new Router({
  mode: 'hash',
  routes: [
    {
      path: '/',
      name: 'home',
      component: Home
    },
    {
      path: '/calendar',
      name: 'calendar',
      component: Calendar
    },
    {
      path: '/queue',
      name: 'queue',
      component: Queue
    },
    {
      path: '/stats',
      name: 'stats',
      component: Stats
    },
    {
      path: '/settings',
      name: 'settings',
      component: Settings
    }
  ]
})
