import router from '../router/index';

const state = {
  user: {}
}

const getters = {}

const mutations = {
  setUser(state, data) {
    state.user = data
  },
}

const actions = {

   // プロフィールエディット
   async profileEdit({ commit }, data) {
    await axios.post('/api/user_information', data)
    .then(res => {
      // console.log(res.data);
    })
    .catch(e => {
      // console.log(e);
    })
  },
  async getUserShow({ commit }, id) {
    await axios.get(`/api/user/${id}/show`)
    .then(res => {
      console.log(res.data);
      commit('setUser', res.data);
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