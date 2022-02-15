import contentService from "../../services/content";
import {
    GET_CONTACT,
    SET_CONTACT,
    CREATE_CONTACT,
    UPDATE_CONTACT,
    GET_SOCIAL,
    GET_SOCIALS,
    SET_SOCIAL,
    SET_SOCIALS,
    CREATE_SOCIAL,
    UPDATE_SOCIAL,
    DELETE_SOCIAL,
    GET_EVENT,
    GET_EVENTS,
    SET_EVENT,
    SET_EVENTS,
    CREATE_EVENT,
    UPDATE_EVENT,
    DELETE_EVENT,
} from "../types/content";

const contentsModule = {
    state: {
        contact: {
            name: null,
            address: null,
            contact_number: null,
            email: null,
            description: null,
            image: null,
        },
        event: {
            title: null,
            description: null,
            start: null,
            end: null,
            type: null,
        },
        events: false,
        social: {
            site: null,
            url: null,
            order: null,
        },
        socials: false,
    },

    mutations: {
        [SET_CONTACT](state, payload) {
            state.contact = payload;
        },
        [SET_EVENT](state, payload) {
            state.event = payload;
        },
        [SET_SOCIAL](state, payload) {
            state.social = payload;
        },
        [SET_EVENTS](state, payload) {
            state.events = payload;
        },
        [SET_SOCIALS](state, payload) {
            state.socials = payload;
        }
    },

    actions: {
        async [GET_CONTACT]({ commit }) {
            try {
                const response = await contentService.getContact();

                const content = response.data;

                commit(SET_CONTACT, content);

                return response;
            } catch (error) {
                throw error;
            }
        },

        async [CREATE_CONTACT]({ commit }, _contact) {
            try {
                const response = await contentService.storeContact(_contact);

                commit(SET_CONTACT, _contact);

                return response;
            } catch (error) {
                throw error;
            }
        },

        async [UPDATE_CONTACT]({ commit }, _contact) {
            try {
                const response = await contentService.updateContact(_contact);

                commit(SET_CONTACT, _contact);

                return response;
            } catch (error) {
                throw error;
            }
        },

        async [GET_EVENT]({ commit }, _id) {
            try {
                const response = await contentService.getEvent(_id);

                const event = response.data;

                commit(SET_EVENT, event);

                return response;
            } catch (error) {
                throw error;
            }
        },

        async [GET_EVENTS]({ commit }) {
            try {
                const response = await contentService.getEvents();

                const events = response.data;

                commit(SET_EVENTS, events);

                return response;
            } catch (error) {
                throw error;
            }
        },

        async [CREATE_EVENT]({ commit }, _event) {
            try {
                const response = await contentService.storeEvent(_event);

                commit(SET_EVENT, _event);

                return response;
            } catch (error) {
                throw error;
            }
        },

        async [UPDATE_EVENT]({ commit }, _event) {
            try {
                const response = await contentService.updateEvent(_event);

                commit(SET_EVENT, _event);

                return response;
            } catch (error) {
                throw error;
            }
        },

        async [DELETE_EVENT]({ commit }, _event) {
            try {
                const response = await contentService.deleteEvent(_event);

                commit(SET_EVENT, _event);

                return response;
            } catch (error) {
                throw error;
            }
        },

        async [GET_SOCIAL]({ commit }, _id) {
            try {
                const response = await contentService.getSocial(_id);

                const social = response.data;

                commit(SET_SOCIAL, social);

                return response;
            } catch (error) {
                throw error;
            }
        },

        async [GET_SOCIALS]({ commit }) {
            try {
                const response = await contentService.getSocials();

                const socials = response.data;

                commit(SET_SOCIALS, socials);

                return response;
            } catch (error) {
                throw error;
            }
        },

        async [CREATE_SOCIAL]({ commit }, _social) {
            try {
                const response = await contentService.storeSocial(_social);

                commit(SET_SOCIAL, _social);

                return response;
            } catch (error) {
                throw error;
            }
        },

        async [UPDATE_SOCIAL]({ commit }, _social) {
            try {
                const response = await contentService.updateSocial(_social);

                commit(SET_SOCIAL, _social);

                return response;
            } catch (error) {
                throw error;
            }
        },

        async [DELETE_SOCIAL]({ commit }, _social) {
            try {
                const response = await contentService.deleteSocial(_social);

                commit(SET_SOCIAL, _social);

                return response;
            } catch (error) {
                throw error;
            }
        }
    }
};

export default contentsModule;
