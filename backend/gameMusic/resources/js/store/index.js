import Vue from 'vue'
import Vuex from 'vuex'

import error from './error'
import auth from './auth'
import user from './user'
import soundType from './soundType'
import audio from './audio'
import transferAccount from './transferAccount'
import favorite from './favorite'
import follow from './follow'
import purchase from './purchase'


Vue.use(Vuex)

const store = new Vuex.Store({
  modules: {
    error,
    auth,
    user,
    soundType,
    audio,
    transferAccount,
    favorite,
    follow,
    purchase
  }
})

export default store