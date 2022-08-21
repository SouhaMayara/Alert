import GroupService from "@/services/group.service";

const state = {
  groups: null,
};

const getters = {
  getGroups(state) {
    return state.groups;
  },
};

const actions = {
  async getGroups({ commit }) {
    let response = await GroupService.getAll();
    await commit("setGroups", response.groups);
  },
  async storeGroup({ dispatch }, group) {
    await GroupService.store(group);
    await dispatch("getGroups");
  },
  async updateGroup({ dispatch }, group) {
    await GroupService.update(group);
    await dispatch("getGroups");
  },
  async deleteGroup({ dispatch }, group) {
    await GroupService.delete(group);
    await dispatch("getGroups");
  },
};

const mutations = {
  setGroups(state, groups) {
    state.groups = groups;
  },
};

export default {
  state,
  getters,
  actions,
  mutations,
};
