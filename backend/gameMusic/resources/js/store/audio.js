import router from '../router/index';

const state = {
  userAudios: [], //ログインユーザーのオーディオ一覧
  userAudio: {},// ログインユーザーのオーディオ
  audios:[],//検索結果オーディオ一覧
  audio:{},// ある特定のオーディオ
  oldAudios: [],
  newAudios: [],
  user_audios: [], //ある特定ユーザーのオーディオ一覧
}

const getters = {}

const mutations = {
  setUserAudios(state, audios) {
    state.userAudios = audios
  },
  setUserAudio(state, audio) {
    state.userAudio = audio
  },
  setAudios(state, audios) {
    state.audios = audios
  },
  setAudio(state, data) {
    state.audio = data.audio
    state.audio.userInformation = data.userInformation
  },
  setOldAudios(state, audios) {
    state.oldAudios = audios
  },
  setNewAudios(state, audios) {
    state.newAudios = audios
  },
  setUser_audios(state, audios) {
    state.user_audios = audios
  },
}

const actions = {

  // オーディオ作成
  async createAudio({ commit }, data) {
    await axios.post('/api/audio/create', data)
    .then(res => {
      // console.log(res.data);
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
      } else {
        router.push('/')
      }
    })
    .catch(e => {
      console.log(e);
    })
  },
  // (検索)オーディオ取得
  async getSearchAudios({ commit }, data) {
    // console.log(data);
    await axios.post(`/api/audios`, data)
    .then(res => {
      // console.log(res.data);
      commit('setAudios', res.data.audios);
    })
    .catch(e => {
      console.log(e);
    })
  },
  // 特定のオーディオ取得
  async getAudioShow({ commit }, id) {
    await axios.get(`/api/audio/${id}/show`)
    .then(res => {
      commit('setAudio', res.data);
    })
    .catch(e => {
      console.log(e);
    })
  },
  // topのオーディオ一覧に表示させるオーディオを取得(古いやつ６件取得)
  async getAudioOld({ commit }) {
    // console.log(data);
    await axios.get(`/api/audio/old`)
    .then(res => {
      // console.log(res.data);
      commit('setOldAudios', res.data.audios);
    })
    .catch(e => {
      console.log(e);
    })
  },
  // topの新着オーディオに載せるやつ取得(新しいやつ3件取得)
  async getAudioNew({ commit }) {
    // console.log(data);
    await axios.get(`/api/audio/new`)
    .then(res => {
      // console.log(res.data);
      commit('setNewAudios', res.data.audios);
    })
    .catch(e => {
      console.log(e);
    })
  },
  // // 特定のユーザーのオーディオ一覧(ユーザー詳細から「もっとみる」を押して進んだページで使うデータ)
  async getAudios({ commit }, id) {
    await axios.get(`/api/user/${id}/audios`)
    .then(res => {
      commit('setUser_audios', res.data.audios);
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