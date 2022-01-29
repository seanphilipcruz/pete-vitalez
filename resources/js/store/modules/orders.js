import ordersService from "../../services/orders";
import {
    GET_ORDERS,
    SET_ORDERS,
    GET_ORDER,
    SET_ORDER,
    UPDATE_ORDER, DELETE_ORDER
} from "../types/artworks";

const ordersModule = {
    state: {
        order: {
            product_id: null,
            customer_id: null,
            code: null,
            total: null,
            is_done: null,
            product: false,
            customer: false,
        },
        orders: false,
    },

    mutations: {
        [SET_ORDER](state, payload) {
            state.order = payload;
        },
        [SET_ORDERS](state, payload) {
            state.orders = payload;
        }
    },

    actions: {
        async[GET_ORDER]({ commit }, _id) {
            try {
                const response = await ordersService.get(_id);

                const order = response.data;

                commit(SET_ORDER, order);

                return order;
            } catch (error) {
                throw error;
            }
        },

        async[GET_ORDERS]({ commit }, _query) {
            try {
                const response = await ordersService.getAll(_query);

                const orders = response.data.data;

                commit(SET_ORDERS, orders);

                return response;
            } catch (error) {
                throw error;
            }
        },

        async[UPDATE_ORDER]({ commit }, _order) {
            try {
                const response = await ordersService.update(_order);

                commit(SET_ORDER, _order);

                return response;
            } catch (error) {
                throw error;
            }
        },

        async[DELETE_ORDER]({ commit }, _order) {
            try {
                const response = await ordersService.destroy(_order);

                commit(SET_ORDER, _order);

                return response
            } catch (error) {
                throw error;
            }
        }
    }
}

export default ordersModule;
