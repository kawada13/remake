import './bootstrap'
import Vue from 'vue';
import Vuetify from './plugins/vuetify'
import FilterPlugin from './plugins/Filter.js'
import '@mdi/font/css/materialdesignicons.css'
import routes from './router/index'
import store from './store' 

Vue.use(FilterPlugin)

// グローバルコンポーネント
Vue.component('app-header', require('./components/Header.vue').default);
Vue.component('app-footer', require('./components/Footer.vue').default);
Vue.component('Loader', require('./components/Loader.vue').default);



const app = new Vue({
    el: '#app',
    vuetify: Vuetify,
    router:routes,
    store,
    components: {
    }
});