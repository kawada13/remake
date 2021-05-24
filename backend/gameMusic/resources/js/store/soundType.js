import router from '../router/index';

const state = {
  sound: [],
  understanding: []
}

const getters = {}

const mutations = {
  // セットサウンド
  setSound(state, data) {
    state.sound = data.sounds
  },
  // セットunderstanding
  setUnderstanding(state, data) {
    state.understanding = data.understandings
  }
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

  }
}




export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}