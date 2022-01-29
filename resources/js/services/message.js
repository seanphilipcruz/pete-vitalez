import axios from "axios";

const messageService = {
    async getAll({ page, perPage, keyword, colName, dir }) {
        const response = await axios.get(route('messages.index'), {
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

    async get(id) {
        const response = await axios.get(route('messages.show', id));

        return response;
    }
}

export default messageService
