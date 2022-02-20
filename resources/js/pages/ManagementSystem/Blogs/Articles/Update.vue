<template>
    <div class="container my-5 text-open-sans">
        <div v-if="loading" class="text-center">
            <div class="spinner-border" role="status">
                <div class="visually-hidden">Loading ...</div>
            </div>
        </div>
        <div class="row" v-else>
            <div class="col-6">
                <router-link :to="{ name: 'articles-index' }" class="btn btn-outline-dark my-3"><font-awesome-icon :icon="['fas', 'arrow-left']"></font-awesome-icon>  Back</router-link>
            </div>
            <div v-if="blog">
                <div class="card mb-3">
                    <update-form :blog="blog" :refresh="fetchBlog"></update-form>
                </div>
                <gallery photo_type="blog_photo" :photo="blog.photo" :folder="blogsDirectory" :fallback-image="fallbackImage" :edit-mode="true" :refresh="fetchBlog"></gallery>
            </div>
        </div>
    </div>
</template>

<script>
import { GET_BLOG } from "../../../../store/types/blogs";
import UpdateForm from "../../../../components/Forms/Blogs/Update";
import Gallery from "../../../../components/Artworks/Gallery";

export default {
    metaInfo() {
        return {
            title: 'Update ' + (this.blog.title ? this.blog.title : 'Loading ...')
        }
    },

    components: {
        UpdateForm,
        Gallery
    },

    data() {
        return {
            loading: false,
            blogsDirectory: '/images/blogs',
            fallbackImage: 'logo.png',
        }
    },

    methods: {
        async fetchBlog() {
            this.loading = true;

            const id = this.$route.params.id;

            if (!id) return Popup.fire({
                'icon': 'error',
                'title': 'Identifier does not exist!'
            });

            try {
                const response = await this.$store.dispatch(GET_BLOG, id);
            } catch (error) {
                await Popup.fire({
                    'icon': 'error',
                    'title': '<div class="h4 m-0">'+error.exception+'</div>',
                    'text': error.message ? error.message : 'Error Occurred!'
                });

                throw error;
            }

            this.loading = false;
        }
    },

    computed: {
        blog() {
            return this.$store.state.blogs.blog;
        }
    },

    async created() {
        await this.fetchBlog();
    },
}
</script>

<style scoped>

</style>
