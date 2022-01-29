<template>
    <div id="hover-items" class="row width-100">
        <div class="col-12">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="card-text text-center fs-4 fw-bold">Most Visited</div>
                </div>
            </div>
            <div class="card mb-2" v-if="!articles">
                <div class="card-body">
                    <div class="card-text text-center fs-5 fw-bold">Coming soon!</div>
                </div>
            </div>
            <template v-else>
                <div class="card mb-2" v-for="(blog, index) in articles" :key="blog.id" v-if="blog.id !== 1 && index < 4" @click="fetch(blog.id, blog.title)">
                    <img :src="folder + '/' + blog.image" :alt="blog.title" class="card-img-top">
                    <div class="card-body text-center bg-light-gray" v-if="index % 2 === 0">
                        <div class="card-title">
                            <strong>{{ blog.title }}</strong>
                        </div>
                        <div class="card-subtitle">
                            <div class="h5">
                                <strong>{{ trimString(blog.sub_title, 22) }}</strong>
                            </div>
                        </div>
                    </div>
                    <div class="card-body text-center" v-else>
                        <div class="card-title">
                            <strong>{{ blog.title }}</strong>
                        </div>
                        <div class="card-subtitle">
                            <div class="h5">
                                <strong>{{ trimString(blog.sub_title, 22) }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        fetch: {
            type: Function,
            required: true
        }
    },

    data() {
        return {
            folder: '/images/blogs',
            loading: false,
            articles: [],
            blog: {
                title: null,
                sub_title: null,
                description: null,
                date: null,
                image: null,
                visits: null,
                is_published: null,
            }
        }
    },

    methods: {
        async fetchMostVisits() {
            this.loading = true;

            await this.$axios.get(route('website.blogs'), {
                params: {
                    visits: true,
                    blog_id: this.blog_id ? this.blog_id : '',
                }
            }).then((res) => {
                this.articles = res.data.data;
            }).catch(async (error) => {
                await Popup.fire({
                    'icon': 'error',
                    'title': error.exception,
                    'text': error.message,
                })
            });

            this.loading = false;
        },

        trimString(string = "", limit = 0, end = '...') {
            if(string.length > limit) {
                return string.slice(0, limit) + end;
            }

            return string;
        },
    },

    computed: {
        blog_id() {
            return this.$store.state.website.blog.id;
        }
    },

    async created() {
        await this.fetchMostVisits();
    }
}
</script>

<style scoped>

</style>
