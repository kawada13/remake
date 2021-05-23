import router from '../router/index';

const state = {
}

const getters = {}

const mutations = {
}

const actions = {
  // オーディオクリエイト
  async createAudio({ commit }, data) {
    await axios.post('/api/audio/create', data)
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