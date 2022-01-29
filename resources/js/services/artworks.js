import axios from "axios";

const artworkService = {
    async getAll({ perPage, page, keyword, colName, dir }) {

        const response = await axios.get(`/api/artworks/`, {
            params: {
                page: page,
                per_page: perPage,
                search: keyword,
                column: colName,
                direction: dir
            }
        });

        return response;
    },

    async get(id) {
        const response = await axios.get(`/api/artworks/view/${id}`);

        return response;
    },

    async create(product) {
        const response = await axios.post(`/api/artworks/store`, product);

        return response;
    },

    async update(id, product) {
        const response = await axios.patch(`/api/artworks/update/${id}`, product);

        return response;
    },

    async destroy(id) {
        const response = await axios.delete(`/api/artworks/delete/${id}`);

        return response;
    }
}

export default artworkService;
