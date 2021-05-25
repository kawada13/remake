import router from '../router/index';

const state = {
  userAudios: [],
  userAudio: {},
}

const getters = {}

const mutations = {
  setUserAudios(state, audios) {
    state.userAudios = audios
  },
  setUserAudio(state, audio) {
    state.userAudio = audio
  }
}

const actions = {

  // オーディオ作成
  async createAudio({ commit }, data) {
    await axios.post('/api/audio/create', data)
    .then(res => {
      console.log(res.data);
    })
    .catch(e => {
      console.log(e);
    })
  },
  // // ログインユーザーの出品オーディオ一覧取得
  async getExhibitedAudios({ commit }) {
    await axios.get('/api/exhibited_audios')
    .then(res => {
      commit('setUserAudios', res.data.audios);
    })
    .catch(e => {
      console.log(e);
    })
  },
  // // ログインユーザーの特定のオーディオ取得
  async getExhibitedAudioShow({ commit }, id) {
    await axios.get(`/api/exhibited_audio/${id}/show`)
    .then(res => {
      // 自身のオーディオならばセット、そうじゃなければホームへリダイレクト
      if(res.data.isloginUserAudio) {
        commit('setUserAudio', res.data);
      } else {
        router.push('/')
      }
    })
    .catch(e => {
      console.log(e);
    })
  },
  // // ログインユーザーの特定のオーディオアップデート
  async getExhibitedAudioUpdate({ commit }, {id, data}) {
    await axios.post(`/api/exhibited_audio/${id}/update`, data)
    .then(res => {
      // 自身のオーディオならばセット、そうじゃなければホームへリダイレクト
      if(res.data.isloginUserAudio) {
        console.log(res.data);
      } else {
        router.push('/')
      }
    })
    .catch(e => {
      console.log(e);
    })
  },
  // // ログインユーザーの特定のオーディオ削除
  async getExhibitedAudioDelete({ commit }, id) {
    await axios.post(`/api/exhibited_audio/${id}/delete`,)
    .then(res => {
      // 自身のオーディオならばセット、そうじゃなければホームへリダイレクト
      if(res.data.isloginUserAudio) {
        console.log(res.data);
      } else {
        router.push('/')
      }
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