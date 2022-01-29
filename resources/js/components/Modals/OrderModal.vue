<template>
    <div id="order_form" class="modal fade" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">Customer Order Form</div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form ref="form">
                    <div class="modal-body">
                        <div class="text-center h2 mb-4">Checkout Form</div>
                        <div class="row">
                            <div class="col-6">
                                <div class="row justify-content-center">
                                    <input type="hidden" class="form-control" v-model="form.product_id">
                                    <div class="col-9">
                                        <div class="form-floating mb-3">
                                            <input id="first_name" type="text" class="form-control" :class="form_errors.first_name ? 'is-invalid' : ''" placeholder="First Name" v-model="form.first_name">
                                            <label for="first_name">First Name</label>
                                            <div v-if="form_errors.first_name" class="invalid-feedback">
                                                <ul class="m-0" v-for="value in form_errors.first_name">
                                                    {{ value }}
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input id="middle_name" type="text" class="form-control" placeholder="Middle Name" v-model="form.middle_name">
                                            <label for="middle_name">Middle Name</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input id="last_name" type="text" class="form-control" :class="form_errors.last_name ? 'is-invalid' : ''" placeholder="Last Name" v-model="form.last_name">
                                            <label for="last_name">Last Name</label>
                                            <div v-if="form_errors.last_name" class="invalid-feedback">
                                                <ul class="m-0" v-for="value in form_errors.last_name">
                                                    {{ value }}
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input id="email" type="email" class="form-control" :class="form_errors.email ? 'is-invalid' : ''" placeholder="Email Address" v-model="form.email">
                                            <label for="email">Email Address</label>
                                            <div v-if="form_errors.email" class="invalid-feedback">
                                                <ul class="m-0" v-for="value in form_errors.email">
                                                    {{ value }}
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
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
                                            <div class="col-8">
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
                                        <div class="form-floating mb-3">
                                            <input id="address" type="text" class="form-control" :class="form_errors.address ? 'is-invalid' : ''" placeholder="Address" v-model="form.address">
                                            <label for="address">Address</label>
                                            <div v-if="form_errors.address" class="invalid-feedback">
                                                <ul class="m-0" v-for="value in form_errors.address">
                                                    {{ value }}
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="form-floating mb-3">
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
                                        <div class="form-floating mb-3">
                                            <input id="state" type="text" class="form-control" placeholder="State/Province" :class="form_errors.state ? 'is-invalid' : ''" v-model="form.state">
                                            <label for="state">State/Province</label>
                                            <div v-if="form_errors.state" class="invalid-feedback">
                                                <ul class="m-0" v-for="value in form_errors.state">
                                                    {{ value }}
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input id="city" type="text" class="form-control" :class="form_errors.city ? 'is-invalid' : ''" placeholder="City" v-model="form.city">
                                            <label for="city">City</label>
                                            <div v-if="form_errors.city" class="invalid-feedback">
                                                <ul class="m-0" v-for="value in form_errors.city">
                                                    {{ value }}
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="form-floating mb-3">
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
                            </div>
                            <div class="col-6">
                                <div class="row justify-content-evenly mb-3">
                                    <div class="col-4">
                                        <img :src="folder + '/' + artwork.image" :alt="artwork.image" class="img-fluid" />
                                    </div>
                                    <div class="col-8">
                                        <div class="h3"><strong>Artwork Order Information:</strong></div>
                                        <div class="h4"><strong>Title</strong>: {{ artwork.title }}</div>
                                        <div class="h4"><strong>Sub Title</strong>: {{ artwork.sub_title }}</div>
                                        <div v-html="artwork.description"></div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between text-center mb-3">
                                    <div class="h4">Total</div>
                                    <div class="h5">₱ {{ artwork.price }}</div>
                                    <hr class="text-dark" />
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="text-center">
                                            <button type="button" v-if="error > 0" class="btn btn-outline-dark" @click="validateForm">Checkout</button>
                                        </div>
                                        <paypal-button v-if="artwork.price && form && error === 0" :amount="artwork.price" :form="form"></paypal-button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="close_button" @click="resetForm" type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import PaypalButton from "../PaypalButton";
import { countries, numbers } from "../../services/country";

const defaultForm = {
    product_id: null,
    profile_id: null,
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
}

export default {
    props: {
        folder: {
            required: true,
        },
        artwork: {
            type: Object,
            required: true,
        },
    },

    components: {
        PaypalButton
    },

    data() {
        return {
            form_errors: Object.assign({}, errors),
            form: Object.assign({}, defaultForm),
            countries: countries,
            numbers: numbers,
            error: 1,
        }
    },

    methods: {
        async validateForm() {
            await this.$axios.post(route('validate.form'), this.form).then((res) => {
                this.form_errors = res.data.message;
                this.form.product_id = this.$props.artwork.id;

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
    },
}
</script>

<style scoped>

</style>
