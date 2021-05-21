import Vue from 'vue'
import Vuex from 'vuex'

import error from './error'
import auth from './auth'
import user from './user'


Vue.use(Vuex)

const store = new Vuex.Store({
  modules: {
    error,
    auth,
    user
  }
})

export default store