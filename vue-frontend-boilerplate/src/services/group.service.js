import axios from "axios";

const headers = {
  "Content-Type": "application/json",
  Authorization: "Bearer " + localStorage.getItem("token"),
};

class GroupService {
  async getAll() {
    let response = await axios.get(process.env.VUE_APP_API_URL + "group", {
      headers: headers,
    });
    return response.data;
  }
  async store(group) {
    let contacts = [];
    for (let i in group.contacts) {
      contacts.push(group.contacts[i]);
    }
    return await axios.post(
      process.env.VUE_APP_API_URL + "group",
      {
        name: group.name,
        standby: group.standby,
        contacts: contacts,
      },
      { headers: headers }
    );
  }
  async update(group) {
    let contacts = [];
    for (let i in group.contacts) {
      if (typeof group.contacts[i] == "object") {
        contacts.push(group.contacts[i]["id"]);
      } else {
        contacts.push(group.contacts[i]);
      }
    }
    return await axios.put(
      process.env.VUE_APP_API_URL + "group/" + group.id,
      {
        name: group.name,
        standby: group.standby,
        contacts: contacts,
      },
      { headers: headers }
    );
  }
  async delete(group) {
    return await axios.delete(
      process.env.VUE_APP_API_URL + "group/" + group.id,
      { headers: headers }
    );
  }
}

export default new GroupService();
