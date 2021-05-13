import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

// ホーム
import Home from '../pages/home.vue'

// 404ページ
import notFound from '../pages/404.vue'

// オーディオ
import AudioIndex from '../pages/audio/index.vue'
import AudioShow from '../pages/audio/show.vue'

// 認証
import Login from '../pages/auth/login.vue'
import Register from '../pages/auth/register.vue'

// マイページ
import MyPage from '../pages/mypage.vue'




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
      path: '/mypage',
      component: MyPage,
      name:'my-page',
    },
    {
      path: '/audios',
      component: AudioIndex,
      name:'audio-index',
    },
    {
      path: '/audios/1',
      component: AudioShow,
      name:'audio-show',
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
