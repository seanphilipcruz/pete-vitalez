import requestService from "../../services/requests";

import {
    GET_REQUESTS,
    SET_REQUESTS,
    GET_REQUEST,
    SET_REQUEST,
    UPDATE_REQUEST,
    DELETE_REQUEST
} from "../types/artworks";

const requestModule = {
    state: {
        request: {
            customer_id: null,
            product_id: null,
            description: null,
            is_done: null,
            customer: false,
            product: false,
        },
        requests: false,
    },

    mutations: {
        [SET_REQUESTS](state, payload) {
            state.requests = payload;
        },
        [SET_REQUEST](state, payload) {
            state.request = payload;
        }
    },

    actions: {
        async[GET_REQUEST]({ commit }, _id) {
            try {
                const response = await requestService.get(_id);

                const request = response.data;

                commit(SET_REQUEST, request);

                return response;
            } catch (error) {
                throw error;
            }
        },

        async[GET_REQUESTS]({ commit }, _query) {
            try {
                const response = await requestService.getAll(_query);

                const requests = response.data.data;

                commit(SET_REQUESTS, requests);

                return response;
            } catch (error) {
                throw error;
            }
        },

        async[UPDATE_REQUEST]({ commit }, _request) {
            try {
                const response = await requestService.update(_request);

                commit(SET_REQUEST, _request);

                return response;
            } catch (error) {
                throw error;
            }
        },

        async[DELETE_REQUEST]({ commit }, _request) {
            try {
                const response = await requestService.destroy(_request);

                commit(SET_REQUEST, _request);

                return response;
            } catch (error) {
                throw error;
            }
        }
    },
}

export default requestModule;
