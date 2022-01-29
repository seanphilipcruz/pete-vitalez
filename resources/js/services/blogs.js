import axios from "axios";

const blogsService = {
    async getAll({ page, perPage, keyword, colName, dir }) {
        const response = await axios.get(`/api/blogs`, {
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
        const response = await axios.get(`/api/blogs/view/${id}`);

        return response;
    },

    async create(blog) {
        const response = await axios.post(`/api/blogs/store`, blog);

        return response;
    },

    async update(id, blog) {
        const response = await axios.patch(`/api/blogs/update/${id}`, blog);

        return response;
    },

    async destroy(id) {
        const response = await axios.delete(`/api/blogs/delete/${id}`);

        return response
    }
}

export default blogsService;
