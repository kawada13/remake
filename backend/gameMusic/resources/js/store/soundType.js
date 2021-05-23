import router from '../router/index';

const state = {
  sound: []
}

const getters = {}

const mutations = {
}

const actions = {
  // サウンドマスターテーブルからデータを取得
  async getSound({ commit }) {
    await axios.get('/api/sound_type')
    .then(res => {
      console.log(res.data);
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