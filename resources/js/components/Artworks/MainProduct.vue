<template>
    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-5 text-center">
                            <img :src="folder + '/' + artwork.image" :alt="artwork.image" class="img-fluid">
                        </div>
                        <div class="col-12 col-md-7">
                            <div class="card">
                                <div class="card-body text-center">
                                    <div class="card-title h2"><strong>{{ artwork.title }}</strong></div>
                                    <div v-if="artwork.is_sold === 0">
                                        <div class="card-text">
                                            <div class="h3">{{ artwork.sub_title }}</div>
                                            <div v-html="artwork.description"></div>
                                            <strong>₱ {{ artwork.price }}</strong>
                                        </div>
                                        <div class="row justify-content-center my-3">
                                            <div class="col-6">
                                                <div class="text-center btn-group">
                                                    <button type="button" data-bs-target="#order_form" data-bs-toggle="modal" class="btn btn-outline-dark">Buy this Artwork</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-else>
                                        <div class="card-text">
                                            <div class="h3">{{ artwork.sub_title }}</div>
                                            <div v-html="artwork.description"></div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center mb-3 text-dark">
                                        <div id="sharing-links" class="col-6">
                                            <div class="h4">Share</div>
                                            <div class="text-center">
                                                <ShareNetwork
                                                    network="facebook"
                                                    :url="app_url + $route.fullPath"
                                                    :title="artwork.title"
                                                    :description="artwork.description"
                                                    hashtags="theartofpetevitalez">
                                                    <font-awesome-icon :icon="['fab', 'facebook']" size="2x" class="mx-2" />
                                                </ShareNetwork>
                                                <ShareNetwork
                                                    network="twitter"
                                                    :url="app_url + $route.fullPath"
                                                    :title="artwork.title"
                                                    :description="artwork.description"
                                                    hashtags="theartofpetevitalez">
                                                    <font-awesome-icon :icon="['fab', 'twitter']" size="2x" class="mx-2" />
                                                </ShareNetwork>
                                                <ShareNetwork
                                                    network="pinterest"
                                                    :url="app_url + $route.fullPath"
                                                    :title="artwork.title"
                                                    :description="artwork.description"
                                                    hashtags="theartofpetevitalez">
                                                    <font-awesome-icon :icon="['fab', 'pinterest']" size="2x" class="mx-2" />
                                                </ShareNetwork>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center mb-3">
                                        <div class="col-8">
                                            <div class="h6">Do you want to customize this artwork?</div>
                                            <div class="text-center">
                                                <button type="button" data-bs-toggle="modal" data-bs-target="#request_form" class="btn btn-outline-dark">Chat with the Artist</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <order-modal v-if="artwork" :folder="folder" :artwork="artwork"></order-modal>
        <request-modal :product_id="artwork.id"></request-modal>
    </div>
</template>

<script>
import OrderModal from "../Modals/CustomerOrder";
import RequestModal from "../Modals/CommissionRequest";

export default {
    props: {
        folder: {
            required: true
        },

        artwork: {
            type: Object,
            required: true
        }
    },

    components: {
        RequestModal,
        OrderModal,
    },

    data() {
        return {
            app_url: process.env.MIX_APP_URL,
        }
    },
}
</script>

<style scoped>

</style>
