const state = {
  isFollow: false,
  followUsers: []
}

const getters = {}

const mutations = {
  setIsFollow(state, data) {
    state.isFollow = data.is_follow
  },
  setFollowUsers(state, data) {
    state.followUsers = data.follow_users
  },
}

const actions = {
   // フォロー
   async store({ commit }, id) {
    await axios.post(`/api/user/${id}/follow`)
    .then(res => {
      // console.log(res.data);
    })
    .catch(e => {
      console.log(e);
    })
  },
   // アンフォロー
   async delete({ commit }, id) {
    await axios.post(`/api/user/${id}/unfollow`)
      .then(res => {
        // console.log(res.data);
      })
      .catch(e => {
        console.log(e);
      })
  },
   // フォロー済かどうか確認
   async isFollow({ commit }, id) {
    await axios.post(`/api/user/${id}/isfollow`)
      .then(res => {
        // console.log(res.data);
        commit('setIsFollow', res.data)
      })
      .catch(e => {
        console.log(e);
      })
  },
  // ログインユーザーがフォローしているユーザー一覧
  async lists({ commit }) {
    await axios.get(`/api/followLists`)
      .then(res => {
        console.log(res.data);
        commit('setFollowUsers', res.data)
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