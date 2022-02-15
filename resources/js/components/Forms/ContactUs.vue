<template>
    <form ref="contact" class="text-open-sans fw-bold">
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="form-floating mb-3">
                    <input type="email" id="name" class="form-control" v-model="form.name" :class="errors.name ? 'is-invalid' : ''" placeholder="Full Name">
                    <label for="name">Full Name</label>
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="form-floating mb-3">
                    <input type="email" id="email_address" class="form-control" v-model="form.email" :class="errors.email ? 'is-invalid' : ''" placeholder="Email Address">
                    <label for="email_address">Email</label>
                </div>
            </div>
        </div>
        <div class="form-floating mb-3">
            <input type="text" id="subject" class="form-control" v-model="form.subject" :class="errors.subject ? 'is-invalid' : ''" placeholder="Subject">
            <label for="subject">Subject</label>
        </div>
        <div class="form-floating mb-3">
            <textarea type="email" id="message" class="form-control" v-model="form.content" :class="errors.content ? 'is-invalid' : ''" placeholder="Message"></textarea>
            <label for="message">Message</label>
        </div>
        <div class="row justify-content-center">
            <div class="col col-md-6 d-grid">
                <button type="button" class="btn btn-outline-dark" @click="sendMessage">
                    <font-awesome-icon :icon="['fas', 'paper-plane']" /> Send
                </button>
            </div>
        </div>
    </form>
</template>

<script>
import { CREATE_MESSAGE } from "../../store/types/website";

const defaultForm = {
    name: null,
    email: null,
    subject: null,
    content: null,
}

const formErrors = {
    name: null,
    email: null,
    subject: null,
    content: null
}

export default {
    data() {
        return {
            errors: Object.assign({}, formErrors),
            form: Object.assign({}, defaultForm),
        }
    },

    methods: {
        async sendMessage() {
            await this.$recaptchaLoaded();

            const token = this.$recaptcha('login');

            token.then(async res => {
                try {
                    const response = await this.$store.dispatch(CREATE_MESSAGE, this.form);

                    this.form = Object.assign({}, {})
                    this.errors = Object.assign({}, {})

                    await Popup.fire({
                        'icon': response.data.status,
                        'title': response.data.message,
                        showCancelButton: false,
                    });
                } catch (error) {
                    this.errors = error.response.data.message;

                    await Popup.fire({
                        'icon': 'error',
                        'title': 'Please complete the necessary fields on your request.',
                        showCancelButton: false,
                    });

                    throw error;
                }
            }).catch(async error => {
                await Popup.fire({
                    'icon': 'error',
                    'title': 'Errors were encountered getting the recaptcha, refresh the page.',
                    'text': error,
                    showCancelButton: false,
                });

                throw error;
            });
        }
    }
}
</script>

<style scoped>

</style>
