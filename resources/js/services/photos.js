import axios from "axios";

const photoService = {
    async get(request) {
        const response = await axios.get(`/api/photos/view/${request.id}`, {
            params: {
                type: request.type,
            }
        });

        return response;
    },

    async store(photo) {
        const response = await axios.post('/api/photos/store', photo);

        return response;
    },

    async update(id, photo) {
        const response = await axios.patch(`/api/photos/update/${id}`, photo);

        return response;
    },

    async delete(id) {
        const response = await axios.delete(`/api/photos/delete/${id}`);

        return response;
    }
}

export default photoService;
