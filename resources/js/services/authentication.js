import axios from "axios";

const authenticationService = {
    async login(credentials) {
        const response = await axios.post('/api/login', credentials);

        console.log('Authentication Service Response: '+response.data);

        return response;
    }
}

export default authenticationService;
