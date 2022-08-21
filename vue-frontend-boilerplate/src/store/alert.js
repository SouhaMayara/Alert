import AlertService from "@/services/alert.service";

const state = {
  alerts: null,
};
const getters = {
  getAlerts(state) {
    return state.alerts;
  },
};
const actions = {
  async getAlerts({ commit }) {
    let response = await AlertService.getAll();
    await commit("setAlerts", response.alerts);
  },
  async storeAlert({ dispatch }, message) {
    await AlertService.store(message);
    await dispatch("getAlerts");
  },
  async aknowledgeAlert({ dispatch }, alert) {
    await AlertService.aknowledgeItem(alert);
    await dispatch("getAlerts");
  },
  async aknowledgeAll({ dispatch }) {
    await AlertService.aknowledgeAll();
    await dispatch("getAlerts");
  },
  async snooze() {
    await AlertService.snooze();
  },
};
const mutations = {
  setAlerts(state, alerts) {
    state.alerts = alerts;
  },
};

export default {
  state,
  getters,
  actions,
  mutations,
};
