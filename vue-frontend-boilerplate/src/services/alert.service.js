import axios from "axios";

const headers = {
  "Content-Type": "application/json",
  Authorization: "Bearer " + localStorage.getItem("token"),
};

class AlertService {
  async getAll() {
    let response = await axios.get(process.env.VUE_APP_API_URL + "alert", {
      headers: headers,
    });
    return response.data;
  }
  async store(message) {
    return await axios.post(
      process.env.VUE_APP_API_URL + "alert",
      {
        message: message,
      },
      { headers: headers }
    );
  }
  async aknowledgeItem(alert) {
    return await axios.post(
      process.env.VUE_APP_API_URL + "alert/" + alert.id + "/aknowledge",
      {},
      { headers: headers }
    );
  }
  async aknowledgeAll() {
    return await axios.post(
      process.env.VUE_APP_API_URL + "alert/aknowledge",
      {},
      { headers: headers }
    );
  }
  async snooze() {
    return await axios.post(
      process.env.VUE_APP_API_URL + "alert/snooze",
      {},
      { headers: headers }
    );
  }
}

export default new AlertService();
