import router from '../router/index';

const state = {
  userAudios: [],
  audio: {},
}

const getters = {}

const mutations = {
  setUserAudios(state, audios) {
    state.userAudios = audios
  },
  setAudio(state, audio) {
    state.audio = audio
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
      console.log(res.data.audios);
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
      // console.log(res.data);
      commit('setAudio', res.data);
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