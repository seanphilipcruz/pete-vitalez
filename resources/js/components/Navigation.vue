<template>
    <div id="navigation" class="navbar navbar-light bg-light navbar-expand-sm">
        <div class="container">
            <router-link :to="{ name: 'home' }" class="navbar-brand">
                <img :src="navbar_image" alt="logo.png">
            </router-link>
            <button class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent"
                    aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto" v-if="!isAuthenticated || view === 'website'">
                    <li class="nav-item">
                        <router-link :to="{ name: 'home' }" class="nav-link">Home</router-link>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#"
                           class="nav-link dropdown-toggle"
                           id="navbarScrollingDropdown"
                           role="button"
                           data-bs-toggle="dropdown"
                           aria-expanded="false">
                            Artworks
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
                            <li><router-link :to="{ name: 'available' }" class="dropdown-item">Available</router-link></li>
                            <li><router-link :to="{ name: 'sold' }" class="dropdown-item">Sold</router-link></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{ name: 'blogs' }" class="nav-link">Blogs</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{ name: 'about' }" class="nav-link">About Me</router-link>
                    </li>
                    <li class="nav-item dropdown" :class="!isAuthenticated ? 'visually-hidden' : ''" v-if="!isAuthenticated">
                        <a href="#"
                           class="nav-link dropdown-toggle"
                           id="navbarSignup"
                           role="button"
                           data-bs-toggle="dropdown"
                           aria-expanded="false">
                            Account
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarSignup">
                            <li><router-link :to="{ name: 'login' }" class="dropdown-item">Sign In</router-link></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown" v-else>
                        <a href="#"
                           class="nav-link dropdown-toggle"
                           id="navbarAuth"
                           role="button"
                           data-bs-toggle="dropdown"
                           aria-expanded="false">
                            {{ name }}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarAuth">
                            <li><button type="button" class="dropdown-item" @click="switchNavigationView">Switch navigation</button></li>
                            <li><button type="button" @click="logout" class="dropdown-item">Sign Out</button></li>
                        </ul>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto" v-else-if="isAuthenticated && view === 'control_panel'">
                    <li class="nav-item">
                        <router-link :to="{ name: 'dashboard' }" class="nav-link">Dashboard</router-link>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#"
                            class="nav-link dropdown-toggle"
                            id="navbarArtworks"
                            role="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Artworks
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarArtworks">
                            <li><router-link :to="{ name: 'products-index' }" class="dropdown-item">Management</router-link></li>
                            <li><router-link :to="{ name: 'orders-index' }" class="dropdown-item">Orders</router-link></li>
                            <li><router-link :to="{ name: 'requests-index' }" class="dropdown-item">Requests</router-link></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{ name: 'articles-index' }" class="nav-link">Articles</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{ name: 'messages-index' }" class="nav-link">Messages</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{ name: 'contents-index' }" class="nav-link">About</router-link>
                    </li>
                    <li class="nav-item dropdown" v-if="isAuthenticated">
                        <a href="#"
                           class="nav-link dropdown-toggle"
                           id="navbarAccount"
                           role="button"
                           data-bs-toggle="dropdown"
                           aria-expanded="false">
                            {{ name }}</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarAccount">
                            <li><button type="button" class="dropdown-item" @click="switchNavigationView">Switch navigation</button></li>
                            <li><button type="button" @click="logout" class="dropdown-item">Sign Out</button></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
import { PURGE_AUTHENTICATION } from "../store/types/authentication";
import {GET_ARTWORKS_PAGE, GET_BLOGS_PAGE} from "../store/types/website";

export default {
    data() {
        return {
            navbar_image: '/assets/logo.png',
            view: 'control_panel',
        }
    },

    methods: {
        async logout() {
            this.$store.commit(PURGE_AUTHENTICATION);

            await this.$router.push({ name: 'login' });
        },

        async fetchBlogs() {
            this.loading = true;

            try {
                const response = await this.$store.dispatch(GET_BLOGS_PAGE);

                this.api_response = response;
            } catch (error) {
                await Popup.fire({
                    'icon': 'error',
                    'title': '<div class="h3 m-0">'+error.exception+'</div>',
                    'text': (error.message ? error.message : 'Error Occurred')
                })

                throw error;
            }

            this.loading = false;
        },

        async fetchItems() {
            this.loading = true;

            try {
                const response = await this.$store.dispatch(GET_ARTWORKS_PAGE);

                this.api_response = response.data;
            } catch (error) {
                await Popup.fire({
                    'icon': 'error',
                    'title': '<div class="h3 m-0">'+error.exception+'</div>',
                    'text': (error.message ? error.message : 'Error Occurred')
                })

                throw error;
            }

            this.loading = false;
        },

        switchNavigationView() {
            if (this.view === 'control_panel') {
                this.view = 'website';
            } else {
                this.view = 'control_panel';
            }
        }
    },

    computed: {
        isAuthenticated() {
            return this.$store.state.authentication.isAuthenticated;
        },

        user() {
            return this.$store.state.authentication.user;
        },

        name() {
            return this.user.profile.first_name + ' ' + this.user.profile.last_name;
        },
    },
}
</script>

<style scoped>

</style>
