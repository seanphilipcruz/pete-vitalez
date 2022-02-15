<template>
    <div class="container text-open-sans">
        <div class="my-5" v-if="!loading">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="fs-3">
                        Dashboard
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col fs-3 fw-bold text-center">
                    <font-awesome-icon :icon="['fas', 'paint-brush']" /> &nbsp;Artworks Stats
                </div>
            </div>
            <hr class="my-3">
            <div class="row mb-3" v-if="!sold && !available && !requests && !artworks_sold">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="fs-4 fw-light">
                                No available stats for Artworks
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-3" v-else>
                <div class="col">
                    <div class="card">
                        <div class="card-body fs-4">
                            <div class="row">
                                <div class="col-md-6">
                                    Orders
                                </div>
                                <div class="col-md-6 text-end">
                                    <div class="btn-group">
                                        <button class="btn btn-outline-dark">Sold: {{ sold }}</button>
                                        <button class="btn btn-outline-dark">Available: {{ available }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-body fs-4">
                            <div class="row">
                                <div class="col-md-6">Requests</div>
                                <div class="col-md-6 text-end">
                                    <div class="btn-group">
                                        <div class="btn btn-outline-dark">
                                            Count: {{ requests }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-body fs-4">
                            <div class="row">
                                <div class="col-md-6">
                                    Artworks Sold
                                </div>
                                <div class="col-md-6 text-end">
                                    <div class="btn-group">
                                        <div class="btn btn-outline-dark">
                                            Count: {{ artworks_sold }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col fs-3 fw-bold text-center">
                    <font-awesome-icon :icon="['fas', 'newspaper']" /> &nbsp;Blogs/Articles Stats
                </div>
            </div>
            <hr class="my-3">
            <div class="row mb-3" v-if="!most_visited && !most_liked">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="fs-4 fw-light">
                                No available stats for Blogs
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-3" v-else>
                <div class="col" v-if="!most_visited">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="fs-4 fw-light">
                                No available stats for Most Visited Blogs
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col" v-else>
                    <div class="card">
                        <div class="card-body fs-4">
                            <div class="row">
                                <div class="col-md-6">
                                    Most Visited
                                </div>
                                <div class="col-md-6 text-end">
                                    <div class="btn-group">
                                        <router-link :to="{ name: 'blog-view', params: { id: most_visited.id, title: most_visited.title } }" class="btn btn-outline-dark">
                                            {{ most_visited.title }}
                                        </router-link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col" v-if="!most_liked">
                    <div class="col" v-if="!most_liked">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="fs-4 fw-light">
                                    No available stats for Most Liked Blogs
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col" v-else>
                    <div class="card">
                        <div class="card-body fs-4">
                            <div class="row">
                                <div class="col-md-6">
                                    Most Liked
                                </div>
                                <div class="col-md-6 text-end">
                                    <div class="btn-group">
                                        <router-link :to="{ name: 'blog-view', params: { id: most_liked.id, title: most_liked.title } }" class="btn btn-outline-dark">
                                            {{ most_liked.title }}
                                        </router-link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col fs-3 fw-bold text-center">
                    <font-awesome-icon :icon="['fas', 'inbox']" /> &nbsp;Message
                </div>
            </div>
            <hr class="my-3">
            <div class="row mb-3" v-if="!unread && !read">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="fs-4 fw-light">
                                No available stats for Messages
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-3" v-else>
                <div class="col">
                    <div class="card">
                        <div class="card-body fs-4">
                            <div class="row">
                                <div class="col-md-6">
                                    Unread
                                </div>
                                <div class="col-md-6 text-end">
                                    <div class="btn-group">
                                        <div class="btn btn-outline-dark">
                                            {{ unread }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-body fs-4">
                            <div class="row">
                                <div class="col-md-6">
                                    Read
                                </div>
                                <div class="col-md-6 text-end">
                                    <div class="btn-group">
                                        <div class="btn btn-outline-dark">
                                            {{ read }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="my-5" v-else>
            <div class="row">
                <div class="col text-center">
                    <div class="spinner-border text-secondary"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { GET_DASHBOARD } from "../../../store/types/dashboard";

export default {
    metaInfo() {
        return {
            title: 'Dashboard'
        }
    },

    data() {
        return {
            loading: false,
        }
    },

    methods: {
        async getData() {
            this.loading = true;

            try {
                const response = await this.$store.dispatch(GET_DASHBOARD);
            } catch (error) {
                throw error;
            }

            this.loading = false;
        }
    },

    computed: {
        data() {
            return this.$store.state.data;
        },

        sold() {
            return this.data.sold;
        },

        available() {
            return this.data.available;
        },

        requests() {
            return this.data.requests;
        },

        artworks_sold() {
            return this.data.artworks_sold;
        },

        pending() {
            return this.data.pending;
        },

        most_visited() {
            return this.data.most_visited;
        },

        most_liked() {
            return this.data.most_liked;
        },

        unread() {
            return this.data.unread;
        },

        read() {
            return this.data.read;
        }
    },

    async created() {
        await this.getData();
    }
}
</script>

<style scoped>

</style>
