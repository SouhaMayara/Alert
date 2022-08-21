import axios from "axios";

const headers = {
  "Content-Type": "application/json",
  Authorization: "Bearer " + localStorage.getItem("token"),
};

class ContactService {
  async getAll() {
    let response = await axios.get(process.env.VUE_APP_API_URL + "contact", {
      headers: headers,
    });
    return response.data;
  }
  async store(contact) {
    let groups = [];
    for (let i in contact.groups) {
      groups.push(contact.groups[i]);
    }
    return await axios.post(
      process.env.VUE_APP_API_URL + "contact",
      {
        name: contact.name,
        phone: contact.phone,
        type: contact.type,
        groups: groups,
      },
      { headers: headers }
    );
  }
  async update(contact) {
    let groups = [];
    for (let i in contact.groups) {
      if (typeof contact.groups[i] == "object") {
        groups.push(contact.groups[i]["id"]);
      } else {
        groups.push(contact.groups[i]);
      }
    }
    return await axios.put(
      process.env.VUE_APP_API_URL + "contact/" + contact.id,
      {
        name: contact.name,
        phone: contact.phone,
        type: contact.type,
        groups: groups,
      },
      { headers: headers }
    );
  }
  async delete(contact) {
    return await axios.delete(
      process.env.VUE_APP_API_URL + "contact/" + contact.id,
      { headers: headers }
    );
  }
}

export default new ContactService();
