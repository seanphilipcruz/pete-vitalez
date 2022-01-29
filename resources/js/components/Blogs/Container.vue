<template>
    <div id="hover-items" class="col-12 width-100">
        <div class="row g-3">
            <div class="col-12 mb-3" v-if="!articleLists">
                <div class="card">
                    <div class="card-body">
                        <div class="card-text fs-5 text-center">
                            No result found
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 mb-3" v-for="blog in articleLists" :key="blog.id" v-else>
                <div class="card" @click="fetch(blog.id, blog.title)">
                    <img :src="assets + '/' + blog.image" :alt="blog.title" class="card-img-top">
                    <div class="card-body">
                        <div class="card-title">
                            <strong class="text-open-sans">{{ blog.title }}</strong>
                        </div>
                        <div class="card-subtitle">
                            <div class="h5">
                                <div class="fw-light text-open-sans">{{ trimString(blog.sub_title, 65) }}</div>
                            </div>
                        </div>
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
            assets: '/images/blogs',
            logo: '/assets/logo.png',
            loading: true,
        }
    },

    methods: {
        trimString(string = "", limit = 0, end = '...') {
            if(string.length > limit) {
                return string.slice(0, limit) + end;
            }

            return string;
        },
    },

    computed: {
        articleLists() {
            return this.$store.state.website.blogs.data;
        }
    },
}
</script>

<style scoped>

</style>
