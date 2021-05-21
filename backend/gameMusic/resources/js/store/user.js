import router from '../router/index';

const state = {
}

const getters = {}

const mutations = {
}

const actions = {

   // プロフィールエディット
   async profileEdit({ commit }, data) {
    await axios.post('/api/user_information', data)
    .then(res => {
      // console.log(res.data);
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