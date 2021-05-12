import Vue from 'vue'
import Vuex from 'vuex'

import error from './error'


Vue.use(Vuex)

const store = new Vuex.Store({
  modules: {
    error
  }
})

export default store