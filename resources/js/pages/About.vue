<template>
    <div v-if="!loading">
        <website-header></website-header>
        <div class="container">
            <div class="row my-5">
                <div class="col-12">
                    <div class="text-center text-uppercase fs-3">Meet The Artist</div>
                    <div class="lh-base text-open-sans" v-html="content.contact.description"></div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-8">
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-8">
                            <div class="mt-4 mb-2">
                                <div class="fs-2 fw-bold text-uppercase mb-2">Exhibitions</div>
                                <div class="row justify-content-between fw-bold" v-for="event in content.events" :key="event.id" v-if="event.type === 'exhibition'">
                                    <div class="col-6 fw-bold text-open-sans">{{ event.title }} <p class="fw-light">{{ event.description }}</p></div>
                                    <div class="col-6 text-open-sans text-end" v-if="!event.start && !event.end"></div>
                                    <div class="col-6 text-open-sans text-end" v-else-if="!event.end">{{ event.start }}</div>
                                    <div class="col-6 text-open-sans text-end" v-else>{{ event.start }} - {{ event.end }}</div>
                                </div>
                            </div>
                            <div class="mt-2">
                                <div class="fs-2 fw-bold text-uppercase mb-2">Guestings and Features</div>
                                <div class="row justify-content-between fw-bold" v-for="event in content.events" :key="event.id" v-if="event.type === 'guesting'">
                                    <div class="col-6 fw-bold text-open-sans">{{ event.title }} <p class="fw-light">{{ event.description }}</p></div>
                                    <div class="col-6 text-open-sans text-end" v-if="!event.start && !event.end"></div>
                                    <div class="col-6 text-open-sans text-end" v-else-if="!event.end">{{ event.start }}</div>
                                    <div class="col-6 text-open-sans text-end" v-else>{{ event.start }} - {{ event.end }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-none d-md-block d-lg-block d-xl-block d-xxl-block col-md-4">
                    <img :src="info_image" alt="pete_vitalez.png" class="img-fluid">
                </div>
            </div>
        </div>
        <contact-form :contact="content.contact" :socials="content.socials"></contact-form>
    </div>
</template>

<script>
import { GET_ABOUT } from "../store/types/website";
import WebsiteHeader from '../components/Header';
import ContactForm from "../components/Contact";

export default {
    metaInfo() {
        return {
            title: 'About Me',
            meta: [
                {
                    hid: 'description',
                    name: 'description',
                    content: this.content.contact ? this.parseHTML(this.content.contact.description) : 'Loading ...',
                },
                {
                    hid: 'og-title',
                    name: 'og-title',
                    content: 'About Me'
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
        ContactForm,
        WebsiteHeader
    },

    data() {
        return {
            loading: false,
            info_image: '/assets/about/info-image.png'
        }
    },

    methods: {
        async getAbout() {
            this.loading = true;

            try {
                const response = await this.$store.dispatch(GET_ABOUT);
            } catch (error) {
                throw  error;
            }

            this.loading = false;
        },

        parseHTML(html) {
            let doc = new DOMParser().parseFromString(html, 'text/html');

            return doc.body.textContent || "";
        },
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

<style scoped>

</style>
