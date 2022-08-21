<template>
  <v-container>
    <h1>Contacts</h1>
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
                  <span class="text-h5">Contact</span>
                </v-card-title>
                <v-card-text>
                  <v-container>
                    <v-row align="center">
                      <v-col cols="12" sm="6" md="4">
                        <v-text-field
                          v-model="newContact.name"
                          label="name"
                          required
                        ></v-text-field>
                      </v-col>
                      <v-col>
                        <v-text-field
                          v-model="newContact.phone"
                          label="phone"
                          required
                        ></v-text-field>
                      </v-col>
                      <v-col>
                        <v-select
                          :items="selectItems"
                          label="type"
                          outlined
                          v-model="newContact.type"
                        ></v-select>
                      </v-col>
                    </v-row>
                    <v-row>
                      <v-col>
                        <v-select
                          :items="groups"
                          label="groups"
                          outlined
                          multiple
                          item-text="name"
                          item-value="id"
                          v-model="newContact.groups"
                        ></v-select>
                      </v-col>
                    </v-row>
                    <v-row justify="center">
                      <v-btn v-on:click="addContact"> Add</v-btn>
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
              <td>{{ item.phone }}</td>
              <td>{{ item.type }}</td>
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
                      <span class="text-h5">Contact</span>
                    </v-card-title>
                    <v-card-text>
                      <v-container>
                        <v-row align="center">
                          <v-col cols="12" sm="6" md="4">
                            <v-text-field
                              v-model="editContact.name"
                              label="name"
                              required
                            ></v-text-field>
                          </v-col>
                          <v-col>
                            <v-text-field
                              v-model="editContact.phone"
                              label="phone"
                              required
                            ></v-text-field>
                          </v-col>
                          <v-col>
                            <v-select
                              :items="selectItems"
                              label="type"
                              outlined
                              v-model="editContact.type"
                            ></v-select>
                          </v-col>
                        </v-row>
                        <v-row>
                          <v-col>
                            <v-select
                              :items="groups"
                              label="groups"
                              outlined
                              multiple
                              item-text="name"
                              item-value="id"
                              v-model="editContact.groups"
                            ></v-select>
                          </v-col>
                        </v-row>
                        <v-row justify="center">
                          <v-btn v-on:click="updateContact"> Save</v-btn>
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
                  v-on:click="deleteContact(item)"
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
  name: "Contacts",
  props: ["contacts", "groups"],
  data() {
    return {
      items: this.contacts,
      selectItems: ["sms", "pager", "email"],
      dialog: false,
      editDialog: false,
      newContact: {
        name: "",
        phone: "",
        type: "",
        groups: [],
      },
      editContact: {
        id: "",
        name: "",
        phone: "",
        type: "",
      },
      headers: [
        {
          text: "Name",
          align: "start",
          value: "name",
          width: "30%",
        },
        {
          text: "Phone",
          align: "start",
          value: "phone",
          width: "20%",
        },
        {
          text: "Type",
          align: "start",
          value: "type",
          width: "20%",
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
    async addContact() {
      await this.$store.dispatch("storeContact", this.newContact);
      this.items = this.$store.getters.getContacts;
      this.newContact = {
        name: "",
        phone: "",
        type: "",
        groups: [],
      };
      this.dialog = false;
      this.$notify({
        title: "Contact",
        text: "Added!",
      });
    },
    prepareEdit(contact) {
      this.editContact.id = contact.id;
      this.editContact.name = contact.name;
      this.editContact.phone = contact.phone;
      this.editContact.type = contact.type;
      this.editContact.groups = contact.groups;
    },
    async updateContact() {
      await this.$store.dispatch("updateContact", this.editContact);
      this.items = this.$store.getters.getContacts;
      this.editContact = {
        id: "",
        name: "",
        phone: "",
        type: "",
      };
      this.editDialog = false;
      this.$notify({
        title: "Contact",
        text: "Updated!",
      });
    },
    async deleteContact(contact) {
      await this.$store.dispatch("deleteContact", contact);
      this.items = this.$store.getters.getContacts;
      this.$notify({
        title: "Contact",
        text: "Deleted!",
      });
    },
  },
};
</script>

<style scoped></style>
