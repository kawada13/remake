import router from '../router/index';

const state = {
  isPurchase: false,
}

const getters = {}

const mutations = {
  // セット購入すみかどうか
  setIsPurchase(state, data) {
    state.isPurchase = data.is_purchase
  },
}

const actions = {
  // あるオーディオを購入済かどうかを取得
  async getIspurchase({ commit }, id) {
    await axios.get(`/api/${id}/isPurchase`)
    .then(res => {
      commit('setIsPurchase', res.data);
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