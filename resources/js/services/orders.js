import axios from "axios";

const ordersService = {
    async getAll({ perPage, page, keyword, colName, dir }) {
        const response = await axios.get(route('orders'), {
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
        const response = await axios.get(route('orders.show', id));

        return response;
    },

    async update(product) {
        const response = await axios.patch(route('orders.update', product.id), product);

        return response;
    },

    async destroy(product) {
        const response = await axios.delete(route('orders.destroy', product.id));

        return response;
    }
};

export default ordersService
