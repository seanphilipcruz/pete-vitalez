<template>
    <div class="container">
        <div class="my-5">
            <button type="button" class="btn btn-outline-dark mb-3" @click="returnToPage"><font-awesome-icon :icon="['fas', 'arrow-left']"/> Back</button>
            <transition name="fade">
                <div class="row" v-if="!loading">
                    <div class="col-12 col-sm-9 col-md-9 mb-3">
                        <div class="card bg-light-gray">
                            <img :src="folder + '/' + blog.image" :alt="blog.title" class="card-img-top">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-3">
                                    <div class="col-6">
                                        <a type="button" class="btn btn-outline-dark">
                                            Like this Article &nbsp;<font-awesome-icon :icon="['fas', 'thumbs-up']" />
                                        </a>
                                    </div>
                                    <div class="col-6 text-end">Likes: {{ blog.likes }}</div>
                                </div>
                                <div class="card-title fs-3">{{ blog.title }}</div>
                                <div class="card-subtitle text-muted fs-5 lh-1 mb-3">{{ blog.sub_title }}</div>
                                <div class="card-text" v-html="blog.description"></div>
                                <div id="sharing-links" class="my-3 text-center">
                                    <div class="fs-4 mb-1">Share</div>
                                    <ShareNetwork
                                        network="facebook"
                                        :url="app_url + $route.fullPath"
                                        :title="blog.title"
                                        :description="blog.description"
                                        hashtags="theartofpetevitalez">
                                        <font-awesome-icon :icon="['fab', 'facebook']" size="2x" class="mx-2" />
                                    </ShareNetwork>
                                    <ShareNetwork
                                        network="twitter"
                                        :url="app_url + $route.fullPath"
                                        :title="blog.title"
                                        :description="blog.description"
                                        hashtags="theartofpetevitalez">
                                        <font-awesome-icon :icon="['fab', 'twitter']" size="2x" class="mx-2" />
                                    </ShareNetwork>
                                    <ShareNetwork
                                        network="pinterest"
                                        :url="app_url + $route.fullPath"
                                        :title="blog.title"
                                        :description="blog.description"
                                        hashtags="theartofpetevitalez">
                                        <font-awesome-icon :icon="['fab', 'pinterest']" size="2x" class="mx-2" />
                                    </ShareNetwork>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <most-visited :fetch="fetchBlog"></most-visited>
                    </div>
                </div>
            </transition>
        </div>
    </div>
</template>

<script>
import { GET_BLOG_PAGE } from "../../../store/types/website";
import MostVisits from "../../../components/Blogs/MostVisits";
import MostVisited from "../../../components/Sidebar/MostVisited";

export default {
    metaInfo() {
        return {
            title: this.blog.title ? this.blog.title : 'Loading ...',
            meta: [
                {
                    hid: 'description',
                    name: 'description',
                    content: this.blog.description ? this.parseHTML(this.blog.description) : 'Loading ...',
                },
                {
                    hid: 'og-title',
                    name: 'og-title',
                    content: this.blog.title ? this.blog.title : 'Loading ...'
                },
                {
                    hid: 'og-description',
                    name: 'og-description',
                    content: this.blog.description ? this.parseHTML(this.blog.description) : 'Loading ...',
                },
            ]
        }
    },

    components: {
        MostVisited,
        MostVisits
    },

    data() {
        return {
            loading: false,
            folder: '/images/blogs',
            app_url: process.env.MIX_APP_URL,
        }
    },

    methods: {
        async getBlog() {
            this.loading = true;

            try {
                const id = this.$route.params.id;

                const response = await this.$store.dispatch(GET_BLOG_PAGE, id);
            } catch (error) {
                throw error;
            }

            this.loading = false;
        },

        returnToPage() {
            this.$router.push({ name: 'blogs' });
        },

        async fetchBlog(id, title) {
            this.loading = true;

            await this.$router.push({ name: 'blog-view', params: { id: `${id}`, title: `${title}` } });

            try {
                const response = await this.$store.dispatch(GET_BLOG_PAGE, id);
            } catch (error) {
                throw error;
            }

            this.loading = false;
        },

        parseHTML(html) {
            let doc = new DOMParser().parseFromString(html, 'text/html');

            return doc.body.textContent || "";
        },
    },

    computed: {
        blog() {
            return this.$store.state.website.blog;
        }
    },

    async created() {
        await this.getBlog();
    }
}
</script>

<style scoped>

</style>
