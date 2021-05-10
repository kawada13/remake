import './bootstrap'
import Vue from 'vue';
import Vuetify from './plugins/vuetify' // vuetify.jsを読み込み
import '@mdi/font/css/materialdesignicons.css'
import routes from './router/index'
import store from './store' 

Vue.component('app-header', require('./components/Header.vue').default);


const app = new Vue({
    el: '#app',
    vuetify: Vuetify,
    router:routes,
    store,
    components: {
    }
});