import photoService from "../../services/photos";
import {
    GET_PHOTOS,
    SET_PHOTOS,
    GET_PHOTO,
    SET_PHOTO,
    CREATE_PHOTO,
    UPDATE_PHOTO,
    DELETE_PHOTO
} from "../types/photos";

const photosModule = {
    state: {
        photo: {
            type: null,
            title: null,
            description: null,
            image: null,
            product: false,
            blog: false,
        },
        photos: [],
    },

    mutations: {
        [SET_PHOTO](state, payload) {
            state.photo = payload;
        },
    },

    actions: {
        async [GET_PHOTO]({ commit }, _id) {
            try {
                const response = await photoService.get(_id);

                const photo = response.data;

                commit(SET_PHOTO, photo);

                return response;
            } catch (error) {
                throw error;
            }
        },

        async [CREATE_PHOTO]({ commit }, _photo) {
            try {
                const response = await photoService.store(_photo);

                commit(SET_PHOTO, _photo)

                return response;
            } catch (error) {
                throw error;
            }
        },

        async [UPDATE_PHOTO]({ commit }, _photo) {
            try {
                const response = await photoService.update(_photo.id, _photo);

                commit(SET_PHOTO, _photo);

                return response;
            } catch (error) {
                throw error;
            }
        },

        async [DELETE_PHOTO]({ commit }, _photo) {
            try {
                const response = await photoService.delete(_photo.id);

                commit(SET_PHOTO, _photo);

                return response;
            } catch (error) {
                throw error;
            }
        }
    }
}

export default photosModule;
