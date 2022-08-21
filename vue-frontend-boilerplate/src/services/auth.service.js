import axios from "axios";

const headers = {
  "Content-Type": "application/json",
  Authorization: "Bearer " + localStorage.getItem("token"),
};

class AuthService {
  async register(user) {
    return await axios
      .post(process.env.VUE_APP_API_URL + "register", {
        name: user.name,
        email: user.email,
        password: user.password,
      })
      .then((response) => {
        if (response.data.token) {
          localStorage.setItem("token", response.data.token);
        }
        return response.data;
      })
      .catch(() => {
        return false;
      });
  }
  async login(user) {
    return await axios
      .post(process.env.VUE_APP_API_URL + "login", {
        email: user.email,
        password: user.password,
      })
      .then((response) => {
        if (response.data.token) {
          localStorage.setItem("token", response.data.token);
        }
        return response.data;
      })
      .catch(() => {
        return false;
      });
  }
  async logout() {
    return await axios
      .post(process.env.VUE_APP_API_URL + "logout", {}, { headers: headers })
      .then(() => {
        localStorage.removeItem("token");
      });
  }
}
export default new AuthService();
