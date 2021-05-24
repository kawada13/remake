import router from '../router/index';

const state = {
  sound: [],
  understanding: [],
  use: [],
  instrument: [],
}

const getters = {}

const mutations = {
  // セットサウンド
  setSound(state, data) {
    state.sound = data.sounds
  },
  // セットuse
  setUnderstanding(state, data) {
    state.understanding = data.understandings
  },
  // セットunderstanding
  setUse(state, data) {
    state.use = data.uses
  },
  // セットinstrument
  setInstrument(state, data) {
    state.instrument = data.instruments
  },
}

const actions = {
  // サウンドマスターテーブルからデータを取得
  async getSound({ commit }) {
    await axios.get('/api/sound_type/sound')
    .then(res => {
      // console.log(res.data);
      commit('setSound', res.data);
    })
    .catch(e => {
      console.log(e);
    })
  },
  // understandingマスターテーブルからデータを取得
  async getUnderstanding({ commit }) {
    await axios.get('/api/sound_type/understanding')
    .then(res => {
      // console.log(res.data);
      commit('setUnderstanding', res.data);
    })
    .catch(e => {
      console.log(e);
    })
  },
  // useマスターテーブルからデータを取得
  async getUse({ commit }) {
    await axios.get('/api/sound_type/use')
    .then(res => {
      // console.log(res.data);
      commit('setUse', res.data);
    })
    .catch(e => {
      console.log(e);
    })
  },
  // instrumentマスターテーブルからデータを取得
  async getInstrument({ commit }) {
    await axios.get('/api/sound_type/instrument')
    .then(res => {
      // console.log(res.data);
      commit('setInstrument', res.data);
    })
    .catch(e => {
      console.log(e);
    })
  },
}




export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}