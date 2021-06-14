const state = {
  chatRooms: [],
  chatMessages: [],
}

const getters = {}

const mutations = {
  setChatRooms(state, data) {
    state.chatRooms = data.chat_rooms
  },
  setChatMessages(state, data) {
    state.chatMessages = data.chat_messages
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
  // ログインユーザーのチャットルーム一覧
  async getChatRooms({ commit }) {
    await axios.get(`/api/chatRooms`)
    .then(res => {
      console.log(res.data);
      commit('setChatRooms', res.data)
    })
    .catch(e => {
      console.log(e.response);
    })
  },
  // ある相手とのチャット履歴取得
  async getChatMessages({ commit }, id) {
    await axios.get(`/api/message/${id}`)
    .then(res => {
      console.log(res.data);
      commit('setChatMessages', res.data)
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