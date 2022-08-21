<template>
  <v-app>
    <v-app-bar clipped-left color="primary" dark fixed app>
      <v-app-bar-title>Souha-Monitoring@Netplanet</v-app-bar-title>
    </v-app-bar>
    <v-navigation-drawer clipped permanent app>
      <v-list>
        <v-list-item class="px-2">
          <v-list-item-avatar>
            <v-img
              src="https://randomuser.me/api/portraits/women/85.jpg"
            ></v-img>
          </v-list-item-avatar>
        </v-list-item>

        <v-list-item link>
          <v-list-item-content>
            <v-list-item-title class="text-h6">
              {{ user.name || "name" }}
            </v-list-item-title>
            <v-list-item-subtitle v-on:click="logout"
              >log out</v-list-item-subtitle
            >
          </v-list-item-content>
        </v-list-item>
      </v-list>

      <v-divider></v-divider>

      <v-list dense nav>
        <v-list-item
          v-on:click="getWindow(item.value)"
          v-for="item in items"
          :key="item.value"
          link
        >
          <v-list-item-icon>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-content>
            <v-list-item-title>{{ item.title }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>
    <v-main>
      <Alerts v-if="currentWindow === 'alerts'" v-bind:alerts="alerts"></Alerts>
      <Groups
        v-if="currentWindow === 'groups'"
        v-bind:contacts="contacts"
        v-bind:groups="groups"
      ></Groups>
      <Contacts
        v-if="currentWindow === 'contacts'"
        v-bind:contacts="contacts"
        v-bind:groups="groups"
      ></Contacts>
    </v-main>
  </v-app>
</template>

<script>
import Alerts from "@/components/Alerts";
import Groups from "@/components/Groups";
import Contacts from "@/components/Contacts";
import store from "@/store";
export default {
  components: { Alerts, Groups, Contacts },
  data() {
    return {
      currentWindow: "alerts",
      items: [
        { title: "Alerts", value: "alerts", icon: "mdi-view-dashboard" },
        {
          title: "Contact Groups",
          value: "groups",
          icon: "mdi-view-dashboard",
        },
        { title: "Contacts", value: "contacts", icon: "mdi-view-dashboard" },
      ],
      user: this.$store.getters.getUser,
      alerts: this.$store.getters.getAlerts,
      groups: null,
      contacts: null,
    };
  },
  methods: {
    async getWindow(value) {
      switch (value) {
        case "alerts":
          await store.dispatch("getAlerts");
          this.alerts = this.$store.getters.getAlerts;
          break;
        case "groups":
          await store.dispatch("getContacts");
          await store.dispatch("getGroups");
          this.contacts = this.$store.getters.getContacts;
          this.groups = this.$store.getters.getGroups;
          break;
        case "contacts":
          await store.dispatch("getContacts");
          await store.dispatch("getGroups");
          this.contacts = this.$store.getters.getContacts;
          this.groups = this.$store.getters.getGroups;
          break;
      }
      this.currentWindow = value;
    },
    logout() {
      this.$store.dispatch("logout").then(() => {
        this.$notify({
          title: "Logout",
          text: "Success!",
        });
        this.$router.replace({ name: "login" });
      });
    },
  },
};
</script>
