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

  // ログイン
  async login({commit}, formInfo) {
    await axios.get('/sanctum/csrf-cookie')
    axios.post('/api/login', {
      email: formInfo.email,
      password: formInfo.password,
    })
    .then(response => {
      console.log(response)
      localStorage.setItem("auth", "ture");
      commit('setUser', response.data.user);
      commit('SET_IS_AUTH', true);
      router.push("/");
   })
   .catch(error => {
    alert('ログインに失敗しました。');
    });
  },

  // 登録
  async register({commit}, formInfo) {
    await axios.get('/sanctum/csrf-cookie')
    axios.post('/api/register', {
      name: formInfo.name,
      email: formInfo.email,
      password: formInfo.password,
    })
    .then(response => {
      console.log(response)
      localStorage.setItem("auth", "ture");
      router.push("/");
   })
   .catch(error => {
    alert('ログインに失敗しました。');
    });
  },

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
      console.log(res);
      commit('setUser', res.data);
      commit('SET_IS_AUTH', true);
    })
    .catch(e => {
      console.log(e.response);
      commit('setUser', null);
      commit('SET_IS_AUTH', false);
    })
  },
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