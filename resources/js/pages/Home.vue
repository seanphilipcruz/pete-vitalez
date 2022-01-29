<template>
    <div id="home-container" class="container">
        <parallax :fixed="true" style="height: 0">
            <img :src="bg_image" alt="background_image">
        </parallax>
        <div id="home-content" class="row justify-content-center align-content-center">
            <div class="col-6 text-center">
                <router-link :to="{ name: 'about' }">
                    <img :src="logo" class="logo" alt="logo.png">
                </router-link>
                <div class="row">
                    <div class="col-12 g-3 text-uppercase">
                        <div class="d-flex justify-content-evenly h3">
                            <router-link :to="{ name: 'home' }" class="nav-item">Home</router-link>
                            <router-link :to="{ name: 'available' }" class="nav-item">Artworks</router-link>
                            <router-link :to="{ name: 'blogs' }" class="nav-item">Blogs</router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { GET_ABOUT } from "../store/types/website";
import Parallax from 'vue-parallaxy';

export default {
    metaInfo() {
        return {
            title: 'Home',
            meta: [
                {
                    hid: 'description',
                    name: 'description',
                    content: this.content.contact ? this.parseHTML(this.content.contact.description) : 'Loading ...',
                },
                {
                    hid: 'og-title',
                    name: 'og-title',
                    content: 'Home'
                },
                {
                    hid: 'og-description',
                    name: 'og-description',
                    content: this.content.contact ? this.parseHTML(this.content.contact.description) : 'Loading ...',
                },
            ]
        }
    },

    components: {
        Parallax,
    },

    methods: {
        async getAbout() {
            try {
                const response = await this.$store.dispatch(GET_ABOUT);
            } catch (error) {
                throw error
            }
        },

        parseHTML(html) {
            let doc = new DOMParser().parseFromString(html, 'text/html');

            return doc.body.textContent || "";
        },
    },

    data() {
        return {
            logo: '/assets/logo.png',
            bg_image: '/assets/background_image.png'
        }
    },

    computed: {
        content() {
            return this.$store.state.website.content;
        }
    },

    async created() {
        await this.getAbout();
    }
}
</script>

<style>

</style>
