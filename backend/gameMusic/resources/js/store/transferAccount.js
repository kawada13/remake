import router from '../router/index';

const state = {
  transferAccountInformation: {
    id: '',
    bank_name: '',
    bank_code: '',
    branch_name: '',
    branch_number: '',
    deposit_type: '',
    account_number: '',
    account_holder: ''
  }
}

const getters = {}

const mutations = {
  setAccountId(state, id) {
    state.transferAccountInformation.id = id
  },
  setAccount(state, transferAccount) {
    state.transferAccountInformation = {
      id: transferAccount.id,
      bank_name: transferAccount.bank_name,
      bank_code: transferAccount.bank_code,
      branch_name: transferAccount.branch_name,
      branch_number: transferAccount.branch_number,
      deposit_type: transferAccount.deposit_type,
      account_number: transferAccount.account_number,
      account_holder: transferAccount.account_holder,
    }
  },
}

const actions = {

   // 口座作成
   async create({ commit }, data) {
    await axios.post('/api/transferAccount/store', data)
    .then(res => {
      console.log(res.data);
      commit('setAccountId', res.data.transferAccount.id)
    })
    .catch(e => {
      // console.log(e);
    })
  },
   // 口座アップテート
   async update({ commit }, {id, data}) {
    await axios.post(`/api/transferAccount/${id}/update`, data)
    .then(res => {
      console.log(res.data);
    })
    .catch(e => {
      // console.log(e);
    })
  },
   // 口座データ取得
   async show({ commit }) {
    await axios.get(`/api/transferAccount/show`)
    .then(res => {
      console.log(res.data.transferAccount);
      if(res.data.transferAccount){
        commit('setAccount', res.data.transferAccount)
      } else {
        commit('setAccount', null)
      }
      
    })
    .catch(e => {
      // console.log(e);
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