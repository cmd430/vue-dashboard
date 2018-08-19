import Vue from 'vue'
import Router from 'vue-router'
import Home from '@/components/Home'
import Calendar from '@/components/Calendar'
import Queue from '@/components/Queue'
import Settings from '@/components/Settings'
import About from '@/components/About'

Vue.use(Router)

export default new Router({
  mode: 'hash',
  routes: [
    {
      path: '/',
      name: 'Home',
      component: Home
    },
    {
      path: '/calendar',
      name: 'Calendar',
      component: Calendar
    },
    {
      path: '/queue',
      name: 'Queue',
      component: Queue
    },
    {
      path: '/settings',
      name: 'Settings',
      component: Settings
    },
    {
      path: '/about',
      name: 'about',
      component: About
    }
  ]
})
