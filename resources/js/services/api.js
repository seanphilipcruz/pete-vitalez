import axios from "axios";

const apiService = {
    init() {
        axios.defaults.baseURL = `${process.env.MIX_APP_URL}/api`;
    },

    setHeader(token) {
        axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
    },

    async get(route, body) {
        const response = await axios.get(route, body);
        return response.data;
    },

    async post(route, body) {
        return await axios.post(route, body);
    },

    async put(route, body) {
        return await axios.put(route, body);
    },

    async patch(route, body) {
        return await axios.patch(route, body);
    },

    async delete(route, body) {
        return await axios.delete(route, body);
    },

    baseURL() {
        return `${process.env.MIX_APP_URL}/api`;
    },
}


export default apiService;
