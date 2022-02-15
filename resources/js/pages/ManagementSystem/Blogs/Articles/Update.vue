<template>
    <div class="container my-5">
        <div class="row">
            <div class="col-6">
                <router-link :to="{ name: 'articles-index' }" class="btn btn-outline-dark my-3"><font-awesome-icon :icon="['fas', 'arrow-left']"></font-awesome-icon>  Back</router-link>
            </div>
        </div>
        <div class="card" v-if="blog">
            <update-form :blog="blog"></update-form>
        </div>
    </div>
</template>

<script>
import { GET_BLOG } from "../../../../store/types/blogs";
import UpdateForm from "../../../../components/Forms/Blogs/Update";

export default {
    metaInfo() {
        return {
            title: 'Update ' + (this.blog.title ? this.blog.title : 'Loading ...')
        }
    },

    components: {
        UpdateForm
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
