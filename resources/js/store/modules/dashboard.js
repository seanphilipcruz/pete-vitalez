import dashboardService from "../../services/dashboard";

import {
    GET_DASHBOARD,
    SET_DASHBOARD
} from "../types/dashboard";

const dashboardModule = {
    state: {
        sold: null,
        available: null,
        requests: null,
        pending: null,
        artworks_sold: null,
        most_visited: {
            id: null,
            title: null,
            sub_title: null,
            description: null,
            visits: null,
            likes: null,
            image: null,
            date: null,
            is_published: null,
            photo: false,
        },
        most_liked: {
            id: null,
            title: null,
            sub_title: null,
            description: null,
            visits: null,
            likes: null,
            image: null,
            date: null,
            is_published: null,
            photo: false,
        },
        unread: null,
        read: null,
    },

    mutations: {
        [SET_DASHBOARD](state, payload) {
            state.sold = payload.sold;
            state.available = payload.available;
            state.requests = payload.requests;
            state.pending = payload.pending;
            state.artworks_sold = payload.artworks_sold;
            state.most_visited = payload.most_visited;
            state.most_liked = payload.most_liked;
            state.unread = payload.unread;
            state.read = payload.read;
        },
    },

    actions: {
        async [GET_DASHBOARD]({ commit }) {
            try {
                const response = await dashboardService.get();

                const data = response.data;

                commit(SET_DASHBOARD, data);

                return response;
            } catch (error) {
                throw error
            }
        }
    }
}

export default dashboardModule;
