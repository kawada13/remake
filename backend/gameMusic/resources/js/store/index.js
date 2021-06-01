import Vue from 'vue'
import Vuex from 'vuex'

import error from './error'
import auth from './auth'
import user from './user'
import soundType from './soundType'
import audio from './audio'
import transferAccount from './transferAccount'
import favorite from './favorite'


Vue.use(Vuex)

const store = new Vuex.Store({
  modules: {
    error,
    auth,
    user,
    soundType,
    audio,
    transferAccount,
    favorite
  }
})

export default store