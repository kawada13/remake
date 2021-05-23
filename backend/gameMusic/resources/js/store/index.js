import Vue from 'vue'
import Vuex from 'vuex'

import error from './error'
import auth from './auth'
import user from './user'
import sound from './sound'


Vue.use(Vuex)

const store = new Vuex.Store({
  modules: {
    error,
    auth,
    user,
    sound
  }
})

export default store