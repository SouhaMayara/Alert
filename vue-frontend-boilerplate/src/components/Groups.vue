<template>
  <v-container>
    <h1>Groups</h1>
    <div class="pt-5">
      <div>
        <v-row>
          <v-col>
            <v-dialog v-model="dialog" persistent max-width="600px">
              <template v-slot:activator="{ on, attrs }">
                <v-btn
                  color="primary"
                  dark
                  class="ml-2"
                  small
                  v-bind="attrs"
                  v-on="on"
                >
                  Add
                </v-btn>
              </template>
              <v-card>
                <v-card-title>
                  <span class="text-h5">Group</span>
                </v-card-title>
                <v-card-text>
                  <v-container>
                    <v-row align="center">
                      <v-col cols="12" sm="6" md="4">
                        <v-text-field
                          v-model="newGroup.name"
                          label="name"
                          required
                        ></v-text-field>
                      </v-col>
                      <v-col>
                        <v-switch v-model="newGroup.standby"></v-switch>
                      </v-col>
                    </v-row>
                    <v-row>
                      <v-col>
                        <v-select
                          :items="contacts"
                          label="contacts"
                          outlined
                          multiple
                          item-text="name"
                          item-value="id"
                          v-model="newGroup.contacts"
                        ></v-select>
                      </v-col>
                    </v-row>
                    <v-row justify="center">
                      <v-col>
                        <v-btn small v-on:click="addGroup"> Add </v-btn>
                      </v-col>
                    </v-row>
                  </v-container>
                </v-card-text>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="blue darken-1" text @click="dialog = false">
                    Close
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
          item-key="name"
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
              <td>{{ item.name }}</td>
              <td>
                {{ item.standby }}
              </td>
              <td>
                <v-dialog
                  v-model="editDialog"
                  persistent
                  max-width="600px"
                  :retain-focus="false"
                >
                  <template v-slot:activator="{ on, attrs }">
                    <v-btn
                      color="primary"
                      elevation="2"
                      dark
                      class="ml-2"
                      small
                      v-bind="attrs"
                      v-on="on"
                      v-on:click="prepareEdit(item)"
                    >
                      edit
                    </v-btn>
                  </template>
                  <v-card>
                    <v-card-title>
                      <span class="text-h5">Group</span>
                    </v-card-title>
                    <v-card-text>
                      <v-container>
                        <v-row align="center">
                          <v-col cols="12" sm="6" md="4">
                            <v-text-field
                              v-model="editGroup.name"
                              label="name"
                              required
                            ></v-text-field>
                          </v-col>
                          <v-col>
                            <v-switch v-model="editGroup.standby"></v-switch>
                          </v-col>
                        </v-row>
                        <v-row>
                          <v-col>
                            <v-select
                              :items="contacts"
                              label="contacts"
                              outlined
                              multiple
                              item-text="name"
                              item-value="id"
                              v-model="editGroup.contacts"
                            ></v-select>
                          </v-col>
                        </v-row>
                        <v-row>
                          <v-col>
                            <v-btn small v-on:click="updateGroup"> Save </v-btn>
                          </v-col>
                        </v-row>
                      </v-container>
                    </v-card-text>
                    <v-card-actions>
                      <v-spacer></v-spacer>
                      <v-btn
                        color="blue darken-1"
                        text
                        @click="editDialog = false"
                      >
                        Close
                      </v-btn>
                    </v-card-actions>
                  </v-card>
                </v-dialog>
                <v-btn
                  elevation="2"
                  small
                  color="error"
                  class="ml-2"
                  v-on:click="deleteGroup(item)"
                >
                  Delete
                </v-btn>
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
  name: "Groups",
  props: ["contacts", "groups"],
  data() {
    return {
      items: this.groups,
      dialog: false,
      editDialog: false,
      newGroup: {
        name: "",
        standby: false,
        contacts: [],
      },
      editGroup: {
        id: "",
        name: "",
        standby: false,
      },
      headers: [
        {
          text: "Name",
          align: "start",
          value: "name",
          width: "30%",
        },
        {
          text: "StandBy",
          align: "start",
          value: "standby",
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
    async addGroup() {
      await this.$store.dispatch("storeGroup", this.newGroup);
      this.items = this.$store.getters.getGroups;
      this.newGroup = {
        name: "",
        standby: false,
      };
      this.dialog = false;
      this.$notify({
        title: "Group",
        text: "Added!",
      });
    },
    prepareEdit(group) {
      this.editGroup.id = group.id;
      this.editGroup.name = group.name;
      this.editGroup.standby = group.standby === "1";
      this.editGroup.contacts = group.contacts;
    },
    async updateGroup() {
      await this.$store.dispatch("updateGroup", this.editGroup);
      this.items = this.$store.getters.getGroups;
      this.editGroup = {
        id: "",
        name: "",
        standby: false,
      };
      this.editDialog = false;
      this.$notify({
        title: "Group",
        text: "Updated!",
      });
    },
    async deleteGroup(group) {
      await this.$store.dispatch("deleteGroup", group);
      this.items = this.$store.getters.getGroups;
      this.$notify({
        title: "Group",
        text: "Deleted!",
      });
    },
  },
};
</script>

<style scoped></style>
