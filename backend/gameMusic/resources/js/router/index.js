import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import Home from '../pages/home.vue'
import notFound from '../pages/404.vue'
import AudioIndex from '../pages/audio/index.vue'
import Login from '../pages/auth/login.vue'
import Register from '../pages/auth/register.vue'



const routes = new VueRouter({
  mode:'history',
  scrollBehavior (to, from, savedPosition) {
    return { x: 0, y: 0 }
  },
  routes: [
    {
      path: '/',
      component: Home,
      name:'home',
    },
    {
      path: '/audios',
      component: AudioIndex,
      name:'audio-index',
    },
    {
      path: '/login',
      component: Login,
      name:'login',
    },
    {
      path: '/register',
      component: Register,
      name:'register',
    },
    {
      path: '*',
      component: notFound,
      name:'404',
    },
  ]
})


export default routes;
