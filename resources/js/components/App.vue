<template>
    <main>
        <navigation v-if="routeName !== 'home'"></navigation>
        <transition name="fade">
            <router-view></router-view>
        </transition>
        <website-footer></website-footer>
    </main>
</template>

<script>
import Navigation from "./Navigation";
import WebsiteFooter from "./Footer";

export default {
    metaInfo: {
        title: 'The Art of Pete Vitalez',
        titleTemplate: '%s | The Art of Pete Vitalez',
        meta: [
            {
                hid: 'description',
                name: 'description',
                content: 'Welcome to The Art of Pete Vitalez',
            },
        ]
    },

    components: {
        Navigation,
        WebsiteFooter
    },

    data() {
        return {}
    },

    computed: {
        routeName() {
            return this.$route.name;
        }
    },

    watch: {
        '$route' (to, from) {
            const toDepth = to.path.split('/').length
            const fromDepth = from.path.split('/').length
            this.transitionName = 'fade'
        }
    }
}
</script>

<style scoped>

</style>
