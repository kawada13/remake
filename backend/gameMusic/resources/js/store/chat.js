const state = {
}

const getters = {}

const mutations = {
  setDupError(state, judge) {
    state.duplication = judge
  },

}

const actions = {
  // メッセージ送信
  async sendMessage({ commit }, {id, data}) {
    await axios.post(`/api/message/${id}`, data)
    .then(res => {
      console.log(res.data);
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