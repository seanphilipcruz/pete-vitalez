import axios from "axios";

const dashboardService = {
    async get() {
        const response = await axios.get(route('dashboard'));

        return response;
    }
}

export default dashboardService;
