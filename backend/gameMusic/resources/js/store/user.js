import router from '../router/index';

const state = {
  user: {},
  users: []
}

const getters = {}

const mutations = {
  setUser(state, data) {
    state.user = data
  },
  setUsers(state, data) {
    state.users = data.users
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
  // ユーザー情報取得（ユーザーの詳細ページのためのデータを取得する）
  async getUserShow({ commit }, id) {
    await axios.get(`/api/user/${id}/show`)
    .then(res => {
      // console.log(res.data);
      commit('setUser', res.data);
    })
    .catch(e => {
      console.log(e);
    })
  },
  // 全ユーザー情報取得(管理者ユーザーを除く)
  async getUsers({ commit }) {
    await axios.get(`/api/users`)
    .then(res => {
      // console.log(res.data);
      commit('setUsers', res.data);
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