import authenticationService from "../../services/authentication";
import {
    SET_AUTHENTICATION,
    PURGE_AUTHENTICATION,
    LOGIN,
    AUTHENTICATE_SELF
} from "../types/authentication";
import tokenService from "./token";
import apiService from "../../services/api";

const authenticationModule = {
    state: {
        isAuthenticated: !!tokenService.get('access_token'),
        user: JSON.parse(window.localStorage.getItem('user')) || null,
    },

    mutations: {
        [SET_AUTHENTICATION](state, payload) {
            state.isAuthenticated = true;
            state.user = Object.assign({}, payload.user);
            window.localStorage.setItem('user', JSON.stringify(payload.user));
            tokenService.save('access_token', payload.token);
            apiService.setHeader(payload.token);
        },

        [PURGE_AUTHENTICATION](state, payload) {
            state.isAuthenticated = false;
            state.user = Object.assign({}, {});
            window.localStorage.removeItem('user');
            tokenService.remove('access_token');
        }
    },

    actions: {
        async [LOGIN]({ commit }, _credentials) {
            try {
                const response = await authenticationService.login(_credentials);
                const { access_token, user } = response.data;

                const authenticationPayload = {
                    token: access_token,
                    user
                }

                commit(SET_AUTHENTICATION, authenticationPayload);

                return response;
            } catch (error) {
                throw error;
            }
        },

        async [AUTHENTICATE_SELF]({ commit }) {
            try {
                const token = tokenService.get('access_token');
                const user = JSON.parse(window.localStorage.getItem("user")) || null;

                if (!token && !user) {
                    throw 'Unauthenticated!'
                }

                const authenticationPayload = {
                    token,
                    user
                };

                commit(SET_AUTHENTICATION, authenticationPayload);

                return true;
            } catch (error) {
                throw error;
            }
        }
    }
}

export default authenticationModule;
