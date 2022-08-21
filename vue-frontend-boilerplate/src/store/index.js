import Vue from "vue";
import Vuex from "vuex";
import auth from "@/store/auth";
import alert from "@/store/alert";
import group from "@/store/group";
import contact from "@/store/contact";

Vue.use(Vuex);

const store = new Vuex.Store({
  modules: {
    auth: auth,
    alert: alert,
    group: group,
    contact: contact,
  },
});

export default store;
