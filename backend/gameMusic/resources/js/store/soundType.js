import router from '../router/index';

const state = {
  sound: []
}

const getters = {}

const mutations = {
  setSound(state, data) {
    state.sound = data.sounds
  }
}

const actions = {
  // サウンドマスターテーブルからデータを取得
  async getSound({ commit }) {
    await axios.get('/api/sound_type')
    .then(res => {
      // console.log(res.data);
      commit('setSound', res.data);
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