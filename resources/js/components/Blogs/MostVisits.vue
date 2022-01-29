<template>
    <div id="hover-items-no-image" class="col-12 col-md-4" v-if="!loading">
        <div class="card mb-1">
            <div class="card-body">
                <div class="card-text text-center text-open-sans fw-bold">Most Visited Blogs</div>
            </div>
        </div>
        <div class="card mb-1" v-for="(blog, index) in articles" :key="blog.id" v-if="index < 3" @click="fetch(blog.id, blog.title)">
            <div class="card-body bg-light-gray" v-if="index % 2 === 0">
                <div class="card-title">
                    <strong class="text-open-sans">{{ blog.title }}</strong>
                </div>
                <div class="card-subtitle">
                    <div class="h5">
                        <div class="fw-light">{{ trimString(blog.sub_title, 85) }}</div>
                    </div>
                </div>
            </div>
            <div class="card-body" v-else>
                <div class="card-title">
                    <strong class="text-open-sans">{{ blog.title }}</strong>
                </div>
                <div class="card-subtitle">
                    <div class="h5">
                        <div class="fw-light">{{ trimString(blog.sub_title, 85) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        fetch: {
            type: Function,
            required: true,
        }
    },

    data() {
        return {
            loading: false,
            articles: {
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

    async created() {
        await this.fetchMostVisits();
    }
}
</script>

<style scoped>

</style>
