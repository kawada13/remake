import router from '../router/index';

const state = {
  user: {},
  isAuth: false,
  isAdmin: false
}

const getters = {}

const mutations = {
  setUser(state, user) {
    state.user = user
  },
  SET_IS_AUTH(state, value) {
    state.isAuth = value;
  },
  SET_IS_ADMIN(state, value) {
    state.isAdmin = value;
  },
}

const actions = {

  // ログアウト
  async logout({commit}) {
    await axios.post('/api/logout')
    .then(res => {
      localStorage.removeItem("auth");
      localStorage.removeItem("admin");
      commit('setUser', null);
      commit('SET_IS_AUTH', false);
      commit('SET_IS_ADMIN', false);
      router.push("/login");
    })
  },

  // ログインユーザー情報のみ取得
  async getUser({ dispatch, commit }) {

    await axios.get('/api/user')
    .then(res => {
      commit('setUser', res.data);
      commit('SET_IS_AUTH', true);
    })
    .catch(e => {
      commit('setUser', null);
      commit('SET_IS_AUTH', false);


      // 強引に長時間操作なし対策をしたが正直微妙...

      dispatch('auth/logout', null, { root: true })

      let reload = function(){
        location.reload();
      }
      let alert = function(){
        alert('長時間操作がなかったため、安全のためログアウトいたしました。お手数ですが、再度ログインしてご利用ください。うまくいかなければリロードしてください。')
      }

      setTimeout(reload, 3000);
      setTimeout(alert, 5000);

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
  // 管理者としてログインしているかどうかを保存
  SET_IS_ADMIN({ commit }, status) {
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