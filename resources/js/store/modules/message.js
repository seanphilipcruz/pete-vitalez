import messageService from "../../services/message";

import {
    GET_MESSAGES,
    SET_MESSAGES,
    GET_MESSAGE,
    SET_MESSAGE
} from "../types/message";

const messageModule = {
    state: {
        message: {
            name: null,
            email: null,
            content: null,
            is_read: null,
        },
        messages: false,
    },

    mutations: {
        [SET_MESSAGES](state, payload) {
            state.messages = payload;
        },
        [SET_MESSAGE](state, payload) {
            state.message = payload;
        }
    },

    actions: {
        async [GET_MESSAGE]({ commit }, _id) {
            try {
                const response = await messageService.get(_id);

                const message = response.data;

                commit(SET_MESSAGE, message);

                return response;
            } catch (error) {
                throw error;
            }
        },

        async [GET_MESSAGES]({ commit }, _query) {
            try {
                const response = await messageService.getAll(_query);

                const messages = response.data.data;

                commit(SET_MESSAGES, messages);

                return response;
            } catch (error) {
                throw error;
            }
        }
    }
}

export default messageModule;
