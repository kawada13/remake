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


// クリエイターページ
import Creater from '../pages/creater/main.vue'
import CreaterShow from '../pages/creater/show.vue'
import CreaterAudios from '../pages/creater/audioIndex.vue'






// 以下マイページ関連
import MyPage from '../pages/mypage.vue'

// クリエイターページ(中)
import CreaterPage from '../pages/mypage/CreaterPage.vue'
// クリエイターページ(小)
import ExhibitedProducts from '../pages/mypage/Creater/ExhibitedProducts.vue'
import CreaterInfoEdit from '../pages/mypage/Creater/info.vue'
import TransferAccountSetting from '../pages/mypage/Creater/TransferAccountSetting.vue'
import AudioCreate from '../pages/mypage/Creater/audio/create.vue'
import AudioEdit from '../pages/mypage/Creater/audio/edit.vue'
import Sales from '../pages/mypage/Creater/sales.vue'

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
      path: '/mypage',
      component: MyPage,
      name:'my-page',
      children:[
        {
          path: 'user',
          component: UserPage,
          name:'user-page',
          children:[
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
              path: 'profile_setting',
              component: ProfileSetting,
              name:'profile-setting'
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
              path: 'exhibited_products',
              component: ExhibitedProducts,
              name:'exhibited-products'
            },
            {
              path: 'profile/edit',
              component: CreaterInfoEdit,
              name:'creater-info-edit'
            },
            {
              path: 'transfer_account_setting',
              component: TransferAccountSetting,
              name:'transfer-account-setting'
            },
            {
              path: 'audio/create',
              component: AudioCreate,
              name:'audio-create'
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
          ]
        }
      ]
    },
    {
      path: '/creater',
      component: Creater,
      name:'creater',
      children:[
        {
          path: ':id',
          component: CreaterShow,
          name:'creater-show'
        },
        {
          path: ':id/audios',
          component: CreaterAudios,
          name:'creater-audios'
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
