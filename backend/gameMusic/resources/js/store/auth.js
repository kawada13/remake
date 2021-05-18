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

  // ログインユーザー取得
  getUser({ commit }) {
    axios.get('/api/user')
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