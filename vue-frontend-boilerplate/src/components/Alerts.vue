<template>
  <v-container>
    <h1>Alerts</h1>
    <div class="pt-5">
      <div>
        <v-row>
          <v-col>
            <v-btn color="success" v-on:click="snooze"> Snooze </v-btn>
            <v-btn color="primary" class="ml-2" v-on:click="aknowledgeAll">
              Aknowledge
            </v-btn>
            <v-dialog v-model="dialog" persistent max-width="600px">
              <template v-slot:activator="{ on, attrs }">
                <v-btn
                  color="error"
                  dark
                  class="ml-2"
                  small
                  v-bind="attrs"
                  v-on="on"
                >
                  Alert(test)
                </v-btn>
              </template>
              <v-card>
                <v-card-title>
                  <span class="text-h5">Alert</span>
                </v-card-title>
                <v-card-text>
                  <v-container>
                    <v-row align="center">
                      <v-col cols="12" sm="6" md="4">
                        <v-text-field
                          v-model="newAlert"
                          label="message"
                          required
                        ></v-text-field>
                      </v-col>
                      <v-col>
                        <v-btn small v-on:click="addAlert"> Add </v-btn>
                      </v-col>
                    </v-row>
                  </v-container>
                </v-card-text>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="blue darken-1" text @click="dialog = false">
                    Close
                  </v-btn>
                  <v-btn color="blue darken-1" text @click="dialog = false">
                    Save
                  </v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>
          </v-col>
        </v-row>
      </div>
      <div class="pt-5">
        <v-data-table
          :headers="headers"
          :items="items"
          :items-per-page="10"
          item-key="message"
          item-class="itemRowBackGround"
          class="elevation-1"
          :footer-props="{
            showFirstLastPage: true,
            firstIcon: 'mdi-arrow-collapse-left',
            lastIcon: 'mdi-arrow-collapse-right',
            prevIcon: 'mdi-minus',
            nextIcon: 'mdi-plus',
          }"
        >
          <template v-slot:item="{ item }">
            <tr>
              <td>{{ item.message }}</td>
              <td>
                {{
                  item.create_timestamp
                    | moment("dddd, MMMM Do YYYY, h:mm:ss a")
                }}
              </td>
              <td>
                <v-btn
                  v-if="!(item.confirmed == '1')"
                  elevation="2"
                  small
                  color="primary"
                  v-on:click="aknowledgeAlert(item)"
                  >Aknowledge</v-btn
                >
              </td>
            </tr>
          </template>
        </v-data-table>
      </div>
    </div>
  </v-container>
</template>

<script>
export default {
  name: "Alerts",
  props: ["alerts"],
  data() {
    return {
      items: this.alerts,
      dialog: false,
      newAlert: "",
      headers: [
        {
          text: "Message",
          align: "start",
          value: "message",
          width: "30%",
        },
        {
          text: "Creation Date",
          align: "start",
          value: "create_timestamp",
          width: "40%",
        },
        {
          text: "Action",
          align: "start",
          value: "action",
        },
      ],
    };
  },
  methods: {
    async addAlert() {
      await this.$store.dispatch("storeAlert", this.newAlert);
      this.items = this.$store.getters.getAlerts;
      this.newAlert = "";
      this.dialog = false;
      this.$notify({
        title: "Alert",
        text: "Added!",
      });
    },
    async aknowledgeAlert(alert) {
      await this.$store.dispatch("aknowledgeAlert", alert);
      this.items = this.$store.getters.getAlerts;
      this.$notify({
        title: "Alert",
        text: "Aknowledged!",
      });
    },
    async aknowledgeAll() {
      await this.$store.dispatch("aknowledgeAll");
      this.items = this.$store.getters.getAlerts;
      this.$notify({
        title: "Alert",
        text: "Aknowledged all!",
      });
    },
    async snooze() {
      await this.$store.dispatch("snooze");
      this.items = this.$store.getters.getAlerts;
      this.$notify({
        title: "Alert",
        text: "Snoozed!",
      });
    },
    async getGroups() {},
    async getContacts() {},
  },
};
</script>

<style scoped></style>
