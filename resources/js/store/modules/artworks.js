import artworkService from "../../services/artworks";
import {
    GET_ARTWORK,
    GET_ARTWORKS,
    SET_ARTWORK,
    SET_ARTWORKS,
    CREATE_ARTWORK,
    UPDATE_ARTWORK,
    DELETE_ARTWORK
} from "../types/artworks";

const artworksModule = {
    state: {
        artwork: {
            title: null,
            sub_title: null,
            description: null,
            price: null,
            frame_price: null,
            image: null,
            is_sold: null,
            is_draft: null,
            is_framed: null,
            photo: null,
        },
        artworks: false,
    },

    mutations: {
        [SET_ARTWORKS](state, payload) {
            state.artworks = payload;
        },
        [SET_ARTWORK](state, payload) {
            state.artwork = payload;
        }
    },

    actions: {
        async [GET_ARTWORK]({ commit }, _id) {
            try {
                const response = await artworkService.get(_id);

                const artwork = response.data;

                commit(SET_ARTWORK, artwork);

                return response;
            } catch (error) {
                throw error;
            }
        },

        async [GET_ARTWORKS]({ commit }, _query) {
            try {
                const response = await artworkService.getAll(_query);

                const artworks = response.data.data;

                commit(SET_ARTWORKS, artworks);

                return response;
            } catch (error) {
                throw error;
            }
        },

        async [CREATE_ARTWORK]({ commit }, _artwork) {
            try {
                const response = await artworkService.create(_artwork);

                commit(SET_ARTWORK, _artwork);

                return response;
            } catch (error) {
                throw error;
            }
        },

        async [UPDATE_ARTWORK]({ commit }, _artwork) {
            try {
                const response = await artworkService.update(_artwork.id, _artwork);

                commit(SET_ARTWORK, _artwork);

                return response;
            } catch (error) {
                throw error;
            }
        },

        async [DELETE_ARTWORK]({ commit }, _artwork) {
            try {
                const response = await artworkService.destroy(_artwork.id, _artwork);

                commit(SET_ARTWORK, _artwork);

                return response;
            } catch (error) {
                throw error;
            }
        }
    }
}

export default artworksModule;
