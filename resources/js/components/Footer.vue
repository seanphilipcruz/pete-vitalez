<template>
    <div id="footer" class="container-fluid bg-light text-dark" :class="route === 'login' ? 'fixed-bottom' : ''">
        <div class="row justify-content-center">
            <div class="col-12 col-md-4 col-lg-4 col-xl-2 text-center my-5">
                <router-link :to="{ name: 'home' }" class="h2 text-uppercase">
                    <div class="name">Pete Vitalez</div>
                </router-link>
                <div class="row g-2">
                    <div id="sharing-links" class="col-12 mt-3 mb-2">
                        <a :href="social.url" type="button" target="_blank" v-for="social in content.socials" :key="social.id">
                            <font-awesome-icon :icon="['fab', 'facebook']" size="2x" class="mx-2" v-if="social.site === 'facebook'" />
                            <font-awesome-icon :icon="['fab', 'twitter']" size="2x" class="mx-2" v-else-if="social.site === 'twitter'" />
                            <font-awesome-icon :icon="['fab', 'instagram']" size="2x" class="mx-2" v-else-if="social.site === 'instagram'" />
                            <font-awesome-icon :icon="['fab', 'linkedin-in']" size="2x" class="mx-2" v-else-if="social.site === 'linkedin'" />
                        </a>
                    </div>
                </div>
                <div>2021. &copy; All rights reserved.</div>
            </div>
        </div>
    </div>
</template>

<script>
import { GET_ABOUT } from "../store/types/website";

export default {
    methods: {
        async getAbout() {
            try {
                const response = await this.$store.dispatch(GET_ABOUT);
            } catch (error) {
                throw error
            }
        },
    },

    computed: {
        route() {
            return this.$route.name;
        },

        content() {
            return this.$store.state.website.content;
        }
    }
}
</script>

<style scoped>

</style>
