<template>
    <div id="view_request_modal" class="modal fade" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title fs-3">Request for {{ product.title }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="form-floating">
                                <input type="text" id="customer_name" :value="customer_name" readonly class="form-control" placeholder="Customer Name">
                                <label for="customer_name">Customer Name</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 col-md-6">
                            <div class="form-floating">
                                <input type="text" id="email" :value="customer.email" readonly class="form-control" placeholder="Email">
                                <label for="email">Email Address</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-floating">
                                <input type="text" id="phone_number" :value="customer.phone_number" readonly class="form-control" placeholder="Phone Number">
                                <label for="phone_number">Contact Number</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="form-floating">
                                <input type="text" id="address" :value="address" readonly class="form-control" placeholder="Address">
                                <label for="address">Address</label>
                            </div>
                        </div>
                    </div>
                    <hr class="my-2" />
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="fs-4 fw-light">Request Details</div>
                            <div v-html="request.description"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-group">
                        <button type="button" v-if="request.is_done === 0" class="btn btn-outline-dark" @click="updateRequest(request)">
                            <font-awesome-icon :icon="['fas', 'check-circle']"></font-awesome-icon> Done
                        </button>
                        <button type="button" v-else class="btn btn-outline-dark" @click="updateRequest(request)">
                            <font-awesome-icon :icon="['fas', 'undo-alt']"></font-awesome-icon> Revert
                        </button>
                        <button type="button" ref="close-btn" class="btn btn-outline-dark" data-bs-dismiss="modal">
                            <font-awesome-icon :icon="['fas', 'times-circle']"></font-awesome-icon> Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { UPDATE_REQUEST } from "../../store/types/artworks";

export default {
    props: {
        fetchRequests: {
            type: Function,
            required: true,
        }
    },

    methods: {
        async updateRequest(request) {
            try {
                if (request.is_done === 1) {
                    request.is_done = 0;
                } else {
                    request.is_done = 1;
                }

                const response = await this.$store.dispatch(UPDATE_REQUEST, request);

                this.$refs["close-btn"].click();

                await this.$props.fetchRequests();

                await Toast.fire({
                    'icon': 'success',
                    'title': 'Request has been marked '+ (this.request.is_done === 1 ? 'Completed': 'Pending'),
                });
            } catch (error) {
                throw error;
            }
        },
    },

    computed: {
        request() {
            return this.$store.state.requests.request;
        },

        customer_name() {
            return this.customer.first_name +' '+this.customer.last_name;
        },

        product() {
            return this.$store.state.requests.request.product;
        },

        customer() {
            return this.$store.state.requests.request.customer;
        },

        address() {
            return this.customer.address + ' ' + this.city + ', ' + this.customer_state + ' ' + this.country + ' ' + this.zip_code;
        },

        city() {
            return this.customer.city;
        },

        customer_state() {
            return this.customer.state;
        },

        country() {
            return this.customer.country;
        },

        zip_code() {
            return this.customer.zip_code;
        }
    }
}
</script>

<style scoped>

</style>
