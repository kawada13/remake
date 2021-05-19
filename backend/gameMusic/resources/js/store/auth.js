import router from '../router/index';

const state = {
  user: {},
  isAuth: false
}

const getters = {}

const mutations = {
  setUser(state, user) {
    state.user = user
  },
  SET_IS_AUTH(state, value) {
    state.isAuth = value;
  },
}

const actions = {

  // ログアウト
  logout({commit}) {
    axios.post('/api/logout')
    .then(res => {
      localStorage.removeItem("auth");
      commit('setUser', null);
      commit('SET_IS_AUTH', false);
      router.push("/login");
    })
  },

  // ログインユーザー情報のみ取得
  async getUser({ commit }) {
    await axios.get('/api/user')
    .then(res => {
      // console.log(res);
      commit('setUser', res.data);
      commit('SET_IS_AUTH', true);
    })
    .catch(e => {
      // console.log(e.response);
      commit('setUser', null);
      commit('SET_IS_AUTH', false);
    })
  },

  // ログインユーザーとその詳細情報取得
  async getUserInformation({ commit }) {
    await axios.get('/api/user_information')
    .then(res => {
      // console.log(res.data);
      commit('setUser', res.data);
      commit('SET_IS_AUTH', true);
    })
    .catch(e => {
      // console.log(e);
      commit('setUser', null);
      commit('SET_IS_AUTH', false);
    })
  },

  // ログインしているかどうかを保存
  SET_IS_AUTH({ commit }, status) {
    commit('SET_IS_AUTH', status);
  },
  // ログインしたユーザーをセット
  setUser({ commit }, user) {
    commit('setUser', user);
  }
}

function isLoggedIn() {
  return localStorage.getItem("auth");
}



export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}