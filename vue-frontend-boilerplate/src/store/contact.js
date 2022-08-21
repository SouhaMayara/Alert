import ContactService from "@/services/contact.service";

const state = {
  contacts: null,
};

const getters = {
  getContacts(state) {
    return state.contacts;
  },
};

const actions = {
  async getContacts({ commit }) {
    let response = await ContactService.getAll();
    await commit("setContacts", response.contacts);
  },
  async storeContact({ dispatch }, contact) {
    await ContactService.store(contact);
    await dispatch("getContacts");
  },
  async updateContact({ dispatch }, contact) {
    await ContactService.update(contact);
    await dispatch("getContacts");
  },
  async deleteContact({ dispatch }, contact) {
    await ContactService.delete(contact);
    await dispatch("getContacts");
  },
};

const mutations = {
  setContacts(state, contacts) {
    state.contacts = contacts;
  },
};

export default {
  state,
  getters,
  actions,
  mutations,
};
