
const state = {
  isPurchase: false,
  purchases: [], //ログインユーザーの購入オーディオ一覧
  sales: []
}

const getters = {}

const mutations = {
  // セット購入すみかどうか
  setIsPurchase(state, data) {
    state.isPurchase = data.is_purchase
  },
  // セット購入オーディオ一覧
  setPurchases(state, data) {
    state.purchases = data.purchases
  },
  // セット購入オーディオ一覧
  setSales(state, data) {
    state.sales = data.sales_records
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
  // ログインユーザーの購入オーディオ一覧取得
  async getPurchases({ commit }) {
    await axios.get(`/api/purchases`)
    .then(res => {
      // console.log(res.data);
      commit('setPurchases', res.data);
    })
    .catch(e => {
      console.log(e);
    })
  },
  // ログインユーザーが出品した商品のうち、購入されたデータ一覧を取得
  async getSales({ commit }) {
    await axios.get(`/api/sales`)
    .then(res => {
      console.log(res.data);
      commit('setSales', res.data);
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