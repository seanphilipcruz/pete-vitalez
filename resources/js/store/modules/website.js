import websiteService from "../../services/website";
import {
    GET_ARTWORKS_PAGE,
    GET_ARTWORK_PAGE,
    SET_ARTWORKS_PAGE,
    SET_ARTWORK_PAGE,
    GET_LATEST_BLOG,
    GET_BLOGS_PAGE,
    GET_BLOG_PAGE,
    SET_BLOGS_PAGE,
    SET_BLOG_PAGE,
    SET_LATEST_BLOG,
    SET_REQUEST,
    CREATE_REQUEST,
    GET_ABOUT,
    SET_ABOUT,
    SET_MESSAGE,
    CREATE_MESSAGE, SET_MISC_PHOTO, GET_MISC_PHOTO
} from "../types/website";

const websiteModule = {
    state: {
        product: {
            title: null,
            sub_title: null,
            description: null,
            price: null,
            frame_price: null,
            image: null,
            is_sold: null,
            is_framed: null,
            order: null,
            photo: null,
        },
        products: false,
        blog: {
            title: null,
            sub_title: null,
            description: null,
            date: null,
            image: null,
            visits: null,
            likes: null,
            is_published: null,
        },
        blogs: false,
        latestBlog: {
            title: null,
            sub_title: null,
            description: null,
            date: null,
            image: null,
            visits: null,
            likes: null,
            is_published: null,
        },
        photo: {
            title: null,
            description: null,
            image: null,
            product: false,
            blog: false,
        },
        request: {
            product_id: null,
            customer_id: null,
            first_name: null,
            middle_name: null,
            last_name: null,
            email: null,
            phone_number: null,
            address: null,
            zip_code: null,
            city: null,
            state: null,
            code: null,
            description: null,
            type: 'request'
        },
        content: {
            contact: {
                name: null,
                address: null,
                contact_number: null,
                email: null,
                description: null,
            },
            events: false,
            socials: false
        },
        message: {
            name: null,
            email: null,
            content: null,
        }
    },

    mutations: {
        [SET_ARTWORK_PAGE](state, payload) {
            state.product = payload
        },
        [SET_ARTWORKS_PAGE](state, payload) {
            state.products = payload
        },
        [SET_BLOG_PAGE](state, payload) {
            state.blog = payload;
        },
        [SET_BLOGS_PAGE](state, payload) {
            state.blogs = payload;
        },
        [SET_LATEST_BLOG](state, payload) {
            state.latestBlog = payload;
        },
        [SET_MISC_PHOTO](state, payload) {
            state.photo = payload;
        },
        [SET_REQUEST](state, payload) {
            state.request = payload;
        },
        [SET_ABOUT](state, payload) {
            state.content = payload;
        },
        [SET_MESSAGE](state, payload) {
            state.message = payload;
        }
    },

    actions: {
        async [GET_ARTWORK_PAGE]({ commit }, _id) {
            try {
                const response = await websiteService.getArtwork(_id);

                const product = response.data;

                commit(SET_ARTWORK_PAGE, product);

                return response;
            } catch (error) {
                throw error;
            }
        },

        async [GET_ARTWORKS_PAGE]({ commit }, _query) {
            try {
                const response = await websiteService.getArtworks(_query);

                const products = response.data;

                commit(SET_ARTWORKS_PAGE, products);

                return response;
            } catch (error) {
                throw error;
            }
        },

        async [GET_BLOG_PAGE]({ commit }, _id) {
            try {
                const response = await websiteService.getBlog(_id);

                const blog = response.data;

                commit(SET_BLOG_PAGE, blog);

                return blog;
            } catch (error) {
                throw error;
            }
        },

        async [GET_BLOGS_PAGE]({ commit }, _query) {
            try {
                const response = await websiteService.getBlogs(_query);

                const blogs = response.data;

                commit(SET_BLOGS_PAGE, blogs);

                return blogs;
            } catch (error) {
                throw error;
            }
        },

        async [GET_LATEST_BLOG]({ commit }, _query) {
            try {
                const response = await websiteService.getBlogs(_query);

                const latest = response.data.data[0];

                commit(SET_LATEST_BLOG, latest);

                return latest;
            } catch (error) {
                throw error;
            }
        },

        async [GET_MISC_PHOTO]({ commit }, _id) {
            try {
                const response = await websiteService.getPhoto(_id);

                const photo = response.data;

                commit(SET_MISC_PHOTO, photo);

                return response;
            } catch (error) {
                throw error;
            }
        },

        async [CREATE_REQUEST]({ commit }, _request) {
            try {
                const response = await websiteService.createRequest(_request);

                commit(SET_REQUEST, _request);

                return response;
            } catch (error) {
                throw error;
            }
        },

        async [GET_ABOUT]({ commit }) {
            try {
                const response = await websiteService.getAboutContent();

                const content = response.data;

                commit(SET_ABOUT, content);

                return response;
            } catch (error) {
                throw error;
            }
        },

        async [CREATE_MESSAGE]({ commit }, _message) {
            try {
                const response = await websiteService.createMessage(_message);

                commit(SET_MESSAGE, _message);

                return response;
            } catch (error) {
                throw error;
            }
        }
    }
}

export default websiteModule;
