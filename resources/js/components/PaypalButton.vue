<template>
    <div id="paypal-buttons"></div>
</template>

<script>
import { loadScript } from "@paypal/paypal-js";

export default {
    props: {
        form: {
            type: Object,
            required: true,
        },
        amount: {
            required: true,
        }
    },

    data() {
        return {
            formData: this.$props.form,
            price: this.$props.amount
        }
    },

    methods: {
        //
    },

    async created() {
        let paypal;
        let form_data = this.formData;
        let price = this.price;
        let axios = this.$axios;
        let router = this.$router;

        const config = {
            "client-id": process.env.MIX_APP_PAYPAL_CLIENT_LIVE, // process.env.MIX_APP_PAYPAL_SANDBOX -- sandbox account
            "currency": "PHP",
        }

        try {
            paypal = await loadScript(config);
        } catch (error) {
            console.error("failed to load the PayPal JS SDK script", error);
        }

        if (paypal && price) {
            try {
                await paypal.Buttons({
                    createOrder: function (data, actions) {
                        return actions.order.create({
                            payer: {
                                email_address: form_data.email,
                                name: {
                                    given_name: form_data.first_name,
                                    surname: form_data.last_name
                                },
                                address: {
                                    address_line_1: form_data.address,
                                    address_line_2: form_data.city,
                                    postal_code: form_data.zip_code,
                                    country_code: form_data.code,
                                }
                            },
                            purchase_units: [{
                                amount: {
                                    value: price,
                                }
                            }],
                        });
                    },
                    onApprove: async function (data, actions) {
                        return actions.order.capture().then((res) => {
                            form_data.order_code = res.id;
                            form_data.order_total = res.purchase_units[0].amount.value;

                            console.debug(form_data);
                            console.debug('Payment approval result: '+res.status);

                            axios.post(route('website.create.order', form_data.product_id), form_data).then(async (res) => {
                                let button = document.getElementById('close_button');
                                button.click();

                                const { status, message } = res.data;

                                await Toast.fire({
                                    'icon': status,
                                    'title': message,
                                });

                                await router.push({ name: 'available' });
                            }).catch(async (error) => {
                                await Popup.fire({
                                    'icon': 'error',
                                    'title': error.exception,
                                    'text': error.message,
                                });
                            });
                        }).catch((error) => {
                            console.error(error);
                        });
                    },
                    onCancel: function (data, actions) {
                        return actions.redirect();
                    },
                    onError: function (error) {
                        console.error(error);
                    },
                    style: {
                        shape:  'pill',
                        color:  'gold',
                        label:  'pay',
                    }
                }).render("#paypal-buttons");
            } catch (error) {
                console.error("failed to render the PayPal Buttons", error);
            }
        }
    },
}
</script>

<style scoped>

</style>
