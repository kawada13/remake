import router from '../router/index';

const state = {
}

const getters = {}

const mutations = {
}

const actions = {

   // 口座作成
   async create({ commit }, data) {
     console.log(data);
    // await axios.post('/api/transferAccount/store', {
    //   bank_name: data.bank_name,
    //   bank_code: data.bank_code,
    //   branch_name: data.branch_name,
    //   branch_number: data.branch_number,
    //   deposit_type: data.deposit_type,
    //   account_number: data.account_number,
    //   account_holder: data.account_holder
    // })
    await axios.post('/api/transferAccount/store', data)
    .then(res => {
      console.log(res.data);
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