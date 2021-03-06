<template>
    <div class="row mb-3">
        <div class="col-12" v-if="!loading">
            <div class="row mb-3">
                <div class="col-12">
                    <button class="btn btn-outline-dark float-end" data-bs-target="#add-social" data-bs-toggle="modal">
                        <font-awesome-icon :icon="['fas', 'plus']" /> Add
                    </button>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header fs-4 fw-bold">Social Media Links</div>
                        <div class="card-body">
                            <div class="card" v-if="!socials">
                                <div class="card-body text-center fw-bold">
                                    Added social media links will be displayed here
                                </div>
                            </div>
                            <div id="hover-items" class="col" v-else v-for="social in socials" :key="social.id" data-bs-target="#update-social" data-bs-toggle="modal" @click="getSocial(social)">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <a :href="social.url" target="_blank" class="text-decoration-none text-dark fs-4" v-if="social.site === 'linkedin'">
                                            <font-awesome-icon :icon="['fab', 'linkedin-in']" /> <span class="text-capitalize">{{ social.site }}</span>
                                        </a>
                                        <a :href="social.url" target="_blank" class="text-decoration-none text-dark fs-4" v-else>
                                            <font-awesome-icon :icon="['fab', `${social.site}`]" /> <span class="text-capitalize">{{ social.site }}</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <add-social-modal :refresh="getSocials"></add-social-modal>
            <update-social :refresh="getSocials" :social="social" :order_count="order_count"></update-social>
        </div>
        <div class="col-12 text-center" v-else>
            <div class="spinner-border text-dark" role="status">
                <span class="visually-hidden">Loading ...</span>
            </div>
        </div>
    </div>
</template>

<script>
import { GET_SOCIALS, GET_SOCIAL } from "../../../store/types/content";
import AddSocialModal from "../../../components/Modals/AddSocial";
import UpdateSocial from "../../../components/Modals/UpdateSocial";

export default {
    components: {
        UpdateSocial,
        AddSocialModal
    },

    data() {
        return {
            loading: false,
        }
    },

    methods: {
        async getSocials() {
            this.loading = true;

            try {
                const response = await this.$store.dispatch(GET_SOCIALS);
            } catch (error) {
                throw error;
            }

            this.loading = false;
        },

        async getSocial(social) {
            try {
                const response = await this.$store.dispatch(GET_SOCIAL, social.id);
            } catch (err) {
                throw err;
            }
        }
    },

    computed: {
        socials() {
            return this.$store.state.content.socials;
        },

        social() {
            return this.$store.state.content.social;
        },

        order_count() {
            return this.socials.length;
        }
    },

    async created() {
        await this.getSocials();
    },
}
</script>

<style scoped>

</style>
