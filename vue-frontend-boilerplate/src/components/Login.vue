<template>
  <v-app>
    <v-main>
      <v-container fluid fill-height>
        <v-layout align-center justify-center>
          <v-flex xs12 sm8 md4>
            <v-card class="elevation-12">
              <v-toolbar dark color="primary">
                <v-toolbar-title
                  >{{
                    isRegister ? stateObj.register.name : stateObj.login.name
                  }}
                  form
                </v-toolbar-title>
              </v-toolbar>
              <v-card-text>
                <form
                  ref="form"
                  @submit.prevent="isRegister ? register() : login()"
                >
                  <v-text-field
                    v-if="isRegister"
                    v-model="name"
                    name="name"
                    label="name"
                    type="text"
                    placeholder="name"
                    required
                  ></v-text-field>

                  <v-text-field
                    v-model="email"
                    name="email"
                    label="email"
                    type="text"
                    placeholder="email"
                    required
                  ></v-text-field>

                  <v-text-field
                    v-model="password"
                    name="password"
                    label="Password"
                    type="password"
                    placeholder="password"
                    required
                  ></v-text-field>

                  <v-text-field
                    v-if="isRegister"
                    v-model="confirmPassword"
                    name="confirmPassword"
                    label="Confirm Password"
                    type="password"
                    placeholder="cocnfirm password"
                    required
                  ></v-text-field>
                  <div class="red--text">{{ errorMessage }}</div>
                  <v-btn
                    type="submit"
                    class="mt-4"
                    color="primary"
                    value="log in"
                    >{{
                      isRegister ? stateObj.register.name : stateObj.login.name
                    }}
                  </v-btn>
                  <div
                    class="grey--text mt-4"
                    v-on:click="isRegister = !isRegister"
                  >
                    {{ toggleMessage }}
                  </div>
                </form>
              </v-card-text>
            </v-card>
          </v-flex>
        </v-layout>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
export default {
  name: "App",
  data() {
    return {
      name: "",
      email: "",
      password: "",
      confirmPassword: "",
      isRegister: false,
      errorMessage: "",
      stateObj: {
        register: {
          name: "Register",
          message: "Aleady have an Acoount? login.",
        },
        login: {
          name: "Login",
          message: "Register",
        },
      },
    };
  },
  computed: {
    loggedIn() {
      return this.$store.state.loggedIn;
    },
    toggleMessage: function () {
      return this.isRegister
        ? this.stateObj.register.message
        : this.stateObj.login.message;
    },
  },
  created() {
    if (this.loggedIn) {
      this.$router.push("dashboard");
    }
  },
  methods: {
    async login() {
      await this.$store.dispatch("login", {
        email: this.email,
        password: this.password,
      });
      if (this.$store.getters.getLoggedIn) {
        this.$notify({
          title: "Login",
          text: "Success!",
        });
        await this.$router.replace({
          name: "dashboard",
        });
      } else {
        this.$notify({
          title: "Login",
          text: "Failure!",
        });
      }
    },
    async register() {
      if (this.password === this.confirmPassword) {
        await this.$store.dispatch("register", {
          name: this.name,
          email: this.email,
          password: this.password,
        });
        if (this.$store.getters.getLoggedIn) {
          this.$notify({
            title: "Register",
            text: "Success!",
          });
          await this.$router.replace({
            name: "dashboard",
          });
        } else {
          this.$notify({
            title: "Register",
            text: "Failure!",
          });
        }
      } else {
        this.errorMessage = "password did not match";
      }
    },
  },
};
</script>
