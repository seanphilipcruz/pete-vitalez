<template>
    <div class="container">
        <div class="row justify-content-center my-5">
            <div class="col-8">
                <div class="card">
                    <form ref="login_form">
                        <div class="card-header text-uppercase">
                            <div class="my-2 h5">Login to your account</div>
                        </div>
                        <div class="card-body text-center">
                            <website-alert :alert="alert" @dismiss="hideAlert"></website-alert>
                            <img :src="website_logo" alt="logo.png" class="img-fluid mb-4" width="150px">
                            <div class="row justify-content-center">
                                <div class="col-8">
                                    <div class="mb-3">
                                        <input type="text" id="username" class="form-control" placeholder="Login" v-model="form.username" @keydown.13="login" autocomplete="on">
                                    </div>
                                    <div class="mb-3">
                                        <input type="password" id="password" class="form-control" placeholder="Password" v-model="form.password" @keydown.13="login" autocomplete="on">
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center mb-3">
                                <div class="col-4">
                                    <input type="checkbox" class="form-check-input" id="remember_token">
                                    <label for="remember_token" class="form-check-label">Remember me?</label>
                                </div>
                            </div>
                            <div class="row justify-content-center my-4">
                                <div class="col-4 d-grid mx-auto">
                                    <button type="button" class="btn btn-outline-dark" @click="login">Sign In</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import WebsiteAlert from "../../components/WebsiteAlert";
import { LOGIN } from "../../store/types/authentication";
import { GET_ABOUT } from "../../store/types/website";

const defaultForm = {
    username: null, // petevitalez
    password: null, // password
}

export default {
    metaInfo() {
        return {
            title: 'Login',
            meta: [
                {
                    hid: 'description',
                    name: 'description',
                    content: 'Authentication for Website Admin',
                },
                {
                    hid: 'og-title',
                    name: 'og-title',
                    content: 'Login'
                },
                {
                    hid: 'og-description',
                    name: 'og-description',
                    content: 'Authentication for Website Admin',
                },
            ]
        }
    },

    components: {
        WebsiteAlert
    },

    data() {
        return {
            loading: false,
            alert: {
                shown: false,
                type: "warning",
                message: "A random pop up message is shown",
            },
            form: Object.assign({}, defaultForm),
            website_logo: '/assets/logo.png'
        }
    },

    methods: {
        async login() {
            try {
                const credentials = {
                    username: this.form.username || null,
                    password: this.form.password || null
                }

                const result = await this.$store.dispatch(LOGIN, credentials);

                await this.$router.push({ name: 'dashboard' });
            } catch (error) {
                const { status, message } = error.response.data;

                this.alert.shown = true;
                this.alert.type = status;
                this.alert.message = message;
            }

            this.loading = false;
        },

        async getAbout() {
            try {
                const response = await this.$store.dispatch(GET_ABOUT);
            } catch (error) {
                throw error;
            }
        },

        parseHTML(html) {
            let doc = new DOMParser().parseFromString(html, 'text/html');

            return doc.body.textContent || "";
        },

        hideAlert() {
            this.alert.shown = false;
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

<style scoped>

</style>
