import Vue from "vue";
import Vuex from "vuex";
import artworksModule from "./modules/artworks";
import blogsModule from "./modules/blogs";
import authenticationModule from "./modules/authentication";
import websiteModule from "./modules/website";
import ordersModule from "./modules/orders";
import requestModule from "./modules/requests";
import contentsModule from "./modules/content";
import messageModule from "./modules/message";
import dashboardModule from "./modules/dashboard";
import photosModule from "./modules/photos";

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        authentication: authenticationModule,
        artworks: artworksModule,
        blogs: blogsModule,
        website: websiteModule,
        orders: ordersModule,
        requests: requestModule,
        content: contentsModule,
        message: messageModule,
        data: dashboardModule,
        photos: photosModule
    }
});
