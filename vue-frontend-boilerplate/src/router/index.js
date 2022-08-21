import Vue from "vue";
import Router from "vue-router";
import Login from "../components/Login.vue";
import Dashboard from "../components/Dashboard.vue";
import store from "@/store";

Vue.use(Router);

const router = new Router({
  routes: [
    {
      path: "/",
      name: "login",
      component: Login,
    },
    {
      path: "/dashboard",
      name: "dashboard",
      component: Dashboard,
      beforeEnter: async (to, from, next) => {
        if (store.getters.getLoggedIn) {
          await store.dispatch("getAlerts");
          next();
        }
      },
    },
  ],
});

router.beforeEach((to, from, next) => {
  if (to.name !== "login" && !store.getters.getLoggedIn) {
    next({
      name: "login",
      replace: true,
    });
  } else {
    next();
  }
});

export default router;
