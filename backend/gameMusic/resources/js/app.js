import './bootstrap'
import Vue from 'vue';
import Vuetify from './plugins/vuetify'
import FilterPlugin from './plugins/Filter.js'
import '@mdi/font/css/materialdesignicons.css'
import routes from './router/index'
import store from './store' 
import Toasted from 'vue-toasted';
import Paginate from 'vuejs-paginate'

Vue.use(FilterPlugin)
Vue.use(Toasted)

// グローバルコンポーネント
Vue.component('app-header', require('./components/Header.vue').default);
Vue.component('app-footer', require('./components/Footer.vue').default);
Vue.component('Loader', require('./components/Loader.vue').default);
Vue.component('paginate', Paginate)



const app = new Vue({
    el: '#app',
    vuetify: Vuetify,
    router:routes,
    store,
    components: {
    }
});