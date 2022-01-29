import blogsService from "../../services/blogs";
import {
    GET_BLOG,
    GET_BLOGS,
    SET_BLOG,
    SET_BLOGS,
    CREATE_BLOG,
    UPDATE_BLOG,
    DELETE_BLOG
} from "../types/blogs";

const blogsModule = {
    state: {
        blog: {
            title: null,
            sub_title: null,
            description: null,
            date: null,
            image: null,
            visits: null,
            likes: null,
            is_published: null
        },
        blogs: false,
    },

    mutations: {
        [SET_BLOGS](state, payload) {
            state.blogs = payload;
        },
        [SET_BLOG](state, payload) {
            state.blog = payload
        }
    },

    actions: {
        async [GET_BLOG]({ commit }, _id) {
            try {
                const response = await blogsService.get(_id);

                const blog = response.data;

                commit(SET_BLOG, blog);

                return response;
            } catch (error) {
                throw error.response.data;
            }
        },

        async [GET_BLOGS]({ commit }, _query) {
            try {
                const response = await blogsService.getAll(_query);

                const blogs = response.data.data;

                commit(SET_BLOGS, blogs);

                return response;
            } catch (error) {
                throw error.response.data;
            }
        },

        async [CREATE_BLOG]({ commit }, _blog) {
            try {
                const response = await blogsService.create(_blog);

                commit(SET_BLOG, _blog);

                return response;
            } catch (error) {
                throw error.response.data;
            }
        },

        async [UPDATE_BLOG]({ commit }, _blog) {
            try {
                const response = await blogsService.update(_blog.id, _blog);

                commit(SET_BLOG, _blog);

                return response;
            } catch (error) {
                throw error.response.data;
            }
        },

        async [DELETE_BLOG]({ commit }, _blog) {
            try {
                const response = await blogsService.destroy(_blog.id, _blog);

                commit(SET_BLOG, _blog);

                return response;
            } catch (error) {
                throw error.response.data;
            }
        }
    }
}

export default blogsModule;
