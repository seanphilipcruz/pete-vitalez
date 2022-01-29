import axios from "axios";

const requestService = {
    async getAll({ page, perPage, keyword, colName, dir }) {
        const response = await axios.get(route('requests'), {
            params: {
                page: page,
                per_page: perPage,
                search: keyword,
                column: colName,
                direction: dir,
            }
        });

        return response;
    },

    async get(_id) {
        const response = await axios.get(route('request.show', _id));

        return response;
    },

    async update(request) {
        const response = await axios.patch(route('requests.update', request.id), request);

        return response;
    },

    async destroy(request) {
        const response = await axios.delete(route('requests.destroy', request.id));

        return response;
    }
}

export default requestService;
