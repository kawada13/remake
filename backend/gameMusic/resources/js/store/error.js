const state = {
  name: {
    required: false,
  },
  email: {
    required: false,
  },
  password: {
    required: false,
    size: false,
  },
}

const getters = {}

const mutations = {
  setDupError(state, judge) {
    state.duplication = judge
  },

  resetErrors(state) {
    state.name.required = false
    state.email.required = false
    state.password.required = false
    state.password.size = false
  }
}

const actions = {
  setDupError({commit}, judge) {
    commit("setDupError", judge);
  },

  resetErrors({commit}) {
    commit("resetErrors")
  }
}



export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}