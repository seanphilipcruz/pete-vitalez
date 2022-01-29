<template>
    <div id="request_form" class="modal fade" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">Customer Request Form</div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div v-if="error === 1">
                        <div class="text-center h2 mb-4">Let us know you first</div>
                        <form ref="customer_form">
                            <div class="row justify-content-center my-4">
                                <input type="hidden" class="form-control" v-model="form.product_id">
                                <div class="col-4">
                                    <div class="form-floating mb-3">
                                        <input id="first_name" type="text" class="form-control" :class="form_errors.first_name ? 'is-invalid' : ''" placeholder="First Name" v-model="form.first_name">
                                        <label for="first_name">First Name</label>
                                        <div v-if="form_errors.first_name" class="invalid-feedback">
                                            <ul class="m-0" v-for="value in form_errors.first_name">
                                                {{ value }}
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-floating mb-3">
                                        <input id="middle_name" type="text" class="form-control" placeholder="Middle Name" v-model="form.middle_name">
                                        <label for="middle_name">Middle Name</label>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="form-floating">
                                        <input id="last_name" type="text" class="form-control" :class="form_errors.last_name ? 'is-invalid' : ''" placeholder="Last Name" v-model="form.last_name">
                                        <label for="last_name">Last Name</label>
                                        <div v-if="form_errors.last_name" class="invalid-feedback">
                                            <ul class="m-0" v-for="value in form_errors.last_name">
                                                {{ value }}
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center my-4">
                                <div class="col-8">
                                    <div class="form-floating">
                                        <input id="email" type="email" class="form-control" :class="form_errors.email ? 'is-invalid' : ''" placeholder="Email Address" v-model="form.email">
                                        <label for="email">Email Address</label>
                                        <div v-if="form_errors.email" class="invalid-feedback">
                                            <ul class="m-0" v-for="value in form_errors.email">
                                                {{ value }}
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center my-4">
                                <div class="col-8">
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-floating">
                                                <input id="country_code" list="country_code_list" class="form-control" :class="form_errors.country_code ? 'is-invalid' : ''" placeholder="Select phone number country code" v-model="form.country_code">
                                                <datalist id="country_code_list">
                                                    <option value selected>Select Country Code</option>
                                                    <option :value="'+'+number.value" v-for="number in numbers">{{ number.country }} (+{{ number.value }})</option>
                                                </datalist>
                                                <label for="country_code">Code</label>
                                                <div v-if="form_errors.country_code" class="invalid-feedback">
                                                    <ul class="m-0" v-for="value in form_errors.country_code">
                                                        {{ value }}
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-9">
                                            <div class="form-floating">
                                                <input type="text" id="phone_number" class="form-control" :class="form_errors.phone_number ? 'is-invalid' : ''" placeholder="Phone Number" v-model="form.phone_number">
                                                <label for="phone_number">Phone Number</label>
                                                <div v-if="form_errors.phone_number" class="invalid-feedback">
                                                    <ul class="m-0" v-for="value in form_errors.phone_number">
                                                        {{ value }}
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center my-4">
                                <div class="col-8">
                                    <div class="form-floating">
                                        <input id="address" type="text" class="form-control" :class="form_errors.address ? 'is-invalid' : ''" placeholder="Address" v-model="form.address">
                                        <label for="address">Address</label>
                                        <div v-if="form_errors.address" class="invalid-feedback">
                                            <ul class="m-0" v-for="value in form_errors.address">
                                                {{ value }}
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center my-4">
                                <div class="col-4">
                                    <div class="form-floating">
                                        <input id="country" list="countryList" class="form-control" :class="form_errors.code ? 'is-invalid' : ''" placeholder="Type here to browse countries" v-model="form.code">
                                        <datalist id="countryList">
                                            <option value selected>Select Country</option>
                                            <option :value="country.code" v-for="country in countries" :key="country.code">{{ country.name }}</option>
                                        </datalist>
                                        <label for="country">Country</label>
                                        <div v-if="form_errors.code" class="invalid-feedback">
                                            <ul class="m-0" v-for="value in form_errors.code">
                                                {{ value }}
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-floating">
                                        <input id="state" type="text" class="form-control" :class="form_errors.state ? 'is-invalid' : ''" placeholder="State/Province" v-model="form.state">
                                        <label for="state">State/Province</label>
                                        <div v-if="form_errors.state" class="invalid-feedback">
                                            <ul class="m-0" v-for="value in form_errors.state">
                                                {{ value }}
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center my-4">
                                <div class="col-4">
                                    <div class="form-floating">
                                        <input id="city" type="text" class="form-control" :class="form_errors.city ? 'is-invalid' : ''" placeholder="City" v-model="form.city">
                                        <label for="city">City</label>
                                        <div v-if="form_errors.city" class="invalid-feedback">
                                            <ul class="m-0" v-for="value in form_errors.city">
                                                {{ value }}
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-floating">
                                        <input id="zip_code" type="text" class="form-control" :class="form_errors.zip_code ? 'is-invalid' : ''" placeholder="Zip Code" v-model="form.zip_code">
                                        <label for="zip_code">Zip Code</label>
                                        <div v-if="form_errors.zip_code" class="invalid-feedback">
                                            <ul class="m-0" v-for="value in form_errors.zip_code">
                                                {{ value }}
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="text-center">
                                        <button type="button" v-if="error > 0" class="btn btn-outline-dark" @click="validateForm">Next</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div v-else>
                        <div class="text-center h2 mb-4">Describe your request</div>
                        <form ref="req_form">
                            <div class="row g-0 justify-content-center mb-2">
                                <div class="col-8">
                                    <div class="text-dark mb-1">Description</div>
                                    <editor :api-key="tiny.key" :init="tiny.config" v-model="form.description" :class="form_errors.description ? 'is-invalid' : ''"></editor>
                                    <div v-if="form_errors.description" class="invalid-feedback">
                                        <ul class="m-0" v-for="value in form_errors.description">
                                            {{ value }}
                                        </ul>
                                    </div>
                                    <div class="form-text text-center mt-3 mb-2">Be <strong>descriptive</strong>, and <strong>highlight</strong> the most important details about your request.</div>
                                </div>
                            </div>
                            <div class="row g-0 justify-content-center mb-3">
                                <div class="col-8 text-center">
                                    <button type="button" class="btn btn-outline-dark" @click="sendRequest"><font-awesome-icon :icon="['fas', 'paper-plane']"></font-awesome-icon>  Request</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button ref="close-btn" @click="resetForm" type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Editor from "@tinymce/tinymce-vue";
import { countries, numbers } from "../../services/country";
import { CREATE_REQUEST } from "../../store/types/website";

const defaultForm = {
    product_id: null,
    customer_id: null,
    first_name: null,
    middle_name: null,
    last_name: null,
    email: null,
    country_code: null,
    phone_number: null,
    address: null,
    zip_code: null,
    city: null,
    state: null,
    code: null,
    description: null,
    type: 'request',
    is_done: 0
}

const errors = {
    first_name: null,
    last_name: null,
    email: null,
    country_code: null,
    phone_number: null,
    address: null,
    zip_code: null,
    city: null,
    state: null,
    code: null,
    description: null,
}

export default {
    components: {
        Editor
    },

    props: {
        product_id: {
            required: true,
        },
    },

    data() {
        return {
            loading: false,
            form_errors: Object.assign({}, errors),
            form: Object.assign({}, defaultForm),
            countries: countries,
            numbers: numbers,
            error: 1,
            tiny: {
                key: process.env.MIX_APP_TINY_API_KEY,
                config: {
                    height: 300,
                    width: '100%',
                    plugins: [
                        'lists link image paste help wordcount'
                    ],
                    toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | help',
                    image_caption: true,
                    image_advtab: true,
                }
            },
        }
    },

    methods: {
        async sendRequest() {
            try {
                const response = await this.$store.dispatch(CREATE_REQUEST, this.form);

                this.$refs["close-btn"].click();

                await this.$router.push({ name: 'available' });
                await Toast.fire({
                    'icon': response.data.status,
                    'title': response.data.message,
                });

            } catch (error) {
                console.debug(error.response);

                this.form_errors = error.response.data.message;

                throw error
            }
        },

        async validateForm() {
            await this.$axios.post(route('validate.form'), this.form).then(async (res) => {
                this.form_errors = res.data.message;
                this.form.product_id = this.$props.product_id;

                if (res.data.status === 'error') {
                    this.error = 1;
                } else {
                    this.error = 0;
                }
            }).catch((errors) => {
                Popup.fire({
                    'icon': 'error',
                    'title': errors.message
                });
            });
        },

        resetForm() {
            this.form_errors = Object.assign({}, {});
        }
    }
}
</script>

<style scoped>

</style>
