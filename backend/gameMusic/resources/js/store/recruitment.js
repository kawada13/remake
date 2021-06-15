const state = {
  recruitments: [],
  loginUserRecruitments: [],
  recruitment: {}
}

const getters = {}

const mutations = {
  setRecruitments(state, data) {
    state.recruitments = data.recruitments
  },
  setRecruitment(state, data) {
    state.recruitment = data.recruitment
  },
  setLoginUserRecruitments(state, data) {
    state.loginUserRecruitments = data.recruitments
  },

}

const actions = {
  // 募集編集
  async update({ commit }, {id, data}) {
    await axios.post(`/api/recruitment/${id}/update`, data)
    .then(res => {
      // console.log(res.data);
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
    await axios.delete(`/recruitment/${id}`)
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
    await axios.get(`/recruitment/${id}`)
    .then(res => {
      // console.log(res.data);
      commit('setRecruitment', res.data)
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