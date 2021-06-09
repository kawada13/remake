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
import AudioPayment from '../pages/audio/payment.vue'

// 認証
import Login from '../pages/auth/login.vue'
import Register from '../pages/auth/register.vue'


// クリエイターページ
import User from '../pages/user/main.vue'
import UserShow from '../pages/user/show.vue'
import UserAudios from '../pages/user/audioIndex.vue'






// 以下マイページ関連
import MyPage from '../pages/mypage.vue'
import profile from '../pages/mypage/profile.vue'
import profileEdit from '../pages/mypage/profileEdit.vue'

// クリエイターページ(中)
import CreaterPage from '../pages/mypage/CreaterPage.vue'
// クリエイターページ(小)
import ExhibitedAudios from '../pages/mypage/Creater/ExhibitedAudios.vue'
import TransferAccountSetting from '../pages/mypage/Creater/TransferAccountSetting.vue'
import AudioCreate from '../pages/mypage/Creater/audio/create.vue'
import AudioEdit from '../pages/mypage/Creater/audio/edit.vue'
import Sales from '../pages/mypage/Creater/sales.vue'
import Payout from '../pages/mypage/Creater/payout.vue'

// ユーザーぺーじ(中)
import UserPage from '../pages/mypage/UserPage.vue'
// ユーザーぺーじ(小)
import PurchaseHistory from '../pages/mypage/User/PurchaseHistory.vue'
import FavoriteAudios from '../pages/mypage/User/FavoriteAudios.vue'
import Follows from '../pages/mypage/User/Follows.vue'
import ProfileSetting from '../pages/mypage/User/ProfileSetting.vue'
import BuyerSetteing from '../pages/mypage/User/BuyerSetteing.vue'












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
      path: '/profile/edit',
      component: profileEdit,
      name:'profile-edit',
      meta: { authOnly: true }
    },
    {
      path: '/mypage',
      component: MyPage,
      name:'my-page',
      meta: { authOnly: true },
      children:[
        {
          path: 'user',
          component: UserPage,
          name:'user-page',
          children:[
            {
              path: 'profile',
              component: profile,
              name:'profile',
            },
            {
              path: 'purchase_history',
              component: PurchaseHistory,
              name:'purchase-history'
            },
            {
              path: 'favorite_audios',
              component: FavoriteAudios,
              name:'favorite-audios'
            },
            {
              path: 'follows',
              component: Follows,
              name:'follows'
            },
            {
              path: 'buyer_setteing',
              component: BuyerSetteing,
              name:'buyer_setteing'
            },
          ]
        },
        {
          path: 'creater',
          component: CreaterPage,
          name:'creater-page',
          children:[
            {
              path: 'exhibited_audios',
              component: ExhibitedAudios,
              name:'exhibited-audios'
            },
            {
              path: 'transfer_account_setting',
              component: TransferAccountSetting,
              name:'transfer-account-setting'
            },
            {
              path: 'audio/create',
              component: AudioCreate,
              name:'audio-create',
              meta: { authOnly: true }
            },
            {
              path: 'audio/:id/edit',
              component: AudioEdit,
              name:'audio-edit'
            },
            {
              path: 'sales',
              component: Sales,
              name:'sales'
            },
            {
              path: 'sales/:id/payout',
              component: Payout,
              name:'payout'
            },
          ]
        }
      ]
    },
    {
      path: '/user',
      component: User,
      name:'user',
      children:[
        {
          path: ':id',
          component: UserShow,
          name:'user-show'
        },
        {
          path: ':id/audios',
          component: UserAudios,
          name:'user-audios'
        },
      ]
    },
    {
      path: '/audios',
      component: AudioIndex,
      name:'audio-index',
    },
    {
      path: '/audios/:id',
      component: AudioShow,
      name:'audio-show',
    },
    {
      path: '/audios/:id/payment',
      component: AudioPayment,
      name:'audio-payment',
    },
    {
      path: '/login',
      component: Login,
      name:'login',
      meta: { guestOnly: true }
    },
    {
      path: '/register',
      component: Register,
      name:'register',
      meta: { guestOnly: true }
    },
    {
      path: '*',
      component: notFound,
      name:'404',
    },
  ]
})

function isLoggedIn() {
  return localStorage.getItem("auth");
}

routes.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.authOnly)) {
      if (!isLoggedIn()) {
          next("/login");
      } else {
          next();
      }
  } else if (to.matched.some(record => record.meta.guestOnly)) {
      if (isLoggedIn()) {
          next("/");
      } else {
          next();
      }
  } else {
      next();
  }
});


export default routes;
