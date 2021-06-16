const state = {
  recruitments: [],
  topRecruitments: [],
  loginUserRecruitments: [],
  recruitment: {},
  loginUserRecruitment: {}
}

const getters = {}

const mutations = {
  setRecruitments(state, data) {
    state.recruitments = data.recruitments
  },
  setTopRecruitments(state, data) {
    state.topRecruitments = data.recruitments
  },
  setRecruitment(state, data) {
    state.recruitment = data.recruitment
    state.recruitment.authId = data.authId
  },
  setLoginUserRecruitments(state, data) {
    state.loginUserRecruitments = data.recruitments
  },
  setLoginUserRecruitment(state, data) {
    state.loginUserRecruitment = data.recruitment
  },

}

const actions = {
  // 募集更新編集
  async update({ commit }, {id, data}) {
    console.log(id,data);
    await axios.post(`/api/recruitment/${id}/update`, data)
    .then(res => {
      console.log(res.data);
    })
    .catch(e => {
      console.log(e.response);
    })
  },
  // 募集作成
  async store({ commit }, data) {
    await axios.post(`/api/recruitment/store`, data)
    .then(res => {
      // console.log(res.data);
    })
    .catch(e => {
      console.log(e.response);
    })
  },
  // 募集を削除
  async delete({ commit }, id) {
    await axios.delete(`/api/recruitment/${id}`)
    .then(res => {
      // console.log(res.data);
    })
    .catch(e => {
      console.log(e.response);
    })
  },
  // 募集全件取得
  async index({ commit }) {
    await axios.get(`/api/recruitments`)
    .then(res => {
      // console.log(res.data);
      commit('setRecruitments', res.data)
    })
    .catch(e => {
      console.log(e.response);
    })
  },
  // 最新データ6件取得(トップページで使うやつ)
  async topindex({ commit }) {
    await axios.get(`/api/top/recruitments`)
    .then(res => {
      // console.log(res.data);
      commit('setTopRecruitments', res.data)
    })
    .catch(e => {
      console.log(e.response);
    })
  },
  // ログインユーザーの募集全件取得
  async loginuUserIndex({ commit }) {
    await axios.get(`/api/loginuser/recruitments`)
    .then(res => {
      // console.log(res.data);
      commit('setLoginUserRecruitments', res.data)
    })
    .catch(e => {
      console.log(e.response);
    })
  },
  // 募集詳細取得
  async show({ commit }, id) {
    await axios.get(`/api/recruitment/${id}`)
    .then(res => {
      // console.log(res.data);
      commit('setRecruitment', res.data)
    })
    .catch(e => {
      console.log(e.response);
    })
  },
  // ログインユーザーの特定の募集を取得(更新のため)
  async edit({ commit }, id) {
    await axios.get(`/api/recruitment/edit/${id}`)
    .then(res => {
      // console.log(res.data);
      commit('setLoginUserRecruitment', res.data)
    })
    .catch(e => {
      console.log(e.response);
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