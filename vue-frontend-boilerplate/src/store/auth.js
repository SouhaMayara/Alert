import AuthService from "../services/auth.service";

const state = {
  user: null,
  loggedIn: false,
};
const getters = {
  getUser(state) {
    return state.user;
  },
  getLoggedIn(state) {
    return state.loggedIn;
  },
};
const actions = {
  async register({ commit }, user) {
    let response = await AuthService.register(user);
    if (response.token) {
      commit("setUser", response.user);
      commit("setLoggedIn", true);
    }
  },
  async login({ commit }, user) {
    let response = await AuthService.login(user);
    if (response.token) {
      commit("setUser", response.user);
      commit("setLoggedIn", true);
    }
  },
  async logout({ commit }) {
    await AuthService.logout();
    commit("setUser", null);
    commit("setLoggedIn", false);
  },
};
const mutations = {
  setUser(state, username) {
    state.user = username;
  },
  setLoggedIn(state, value) {
    state.loggedIn = value;
  },
};
export default {
  state,
  getters,
  actions,
  mutations,
};
