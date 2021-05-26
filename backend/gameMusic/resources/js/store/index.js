import Vue from 'vue'
import Vuex from 'vuex'

import error from './error'
import auth from './auth'
import user from './user'
import soundType from './soundType'
import audio from './audio'
import transferAccount from './transferAccount'


Vue.use(Vuex)

const store = new Vuex.Store({
  modules: {
    error,
    auth,
    user,
    soundType,
    audio,
    transferAccount
  }
})

export default store