<template>
    <div class="container my-5 text-open-sans">
        <div class="row">
            <div class="col-6">
                <router-link :to="{ name: 'products-index' }" class="btn btn-outline-dark my-3"><font-awesome-icon :icon="['fas', 'arrow-left']"></font-awesome-icon>  Back</router-link>
            </div>
        </div>
        <div class="card" v-if="artwork">
            <update-form :artwork="artwork"></update-form>
        </div>
    </div>
</template>

<script>
import { GET_ARTWORK } from "../../../../store/types/artworks";
import UpdateForm from "../../../../components/Artworks/UpdateForm";

export default {
    metaInfo() {
        return {
            title: 'Update ' + (this.artwork.title ? this.artwork.title : 'Loading ...')
        }
    },

    components: {
        UpdateForm
    },

    data() {
        return {
            loading: false,
        }
    },

    methods: {
        async fetchArtwork() {
            this.loading = true;

            const id = this.$route.params.id;

            if (!id) return Popup.fire({
                'icon': 'error',
                'title': 'Identifier does not exist!'
            });

            try {
                const response = await this.$store.dispatch(GET_ARTWORK, id);
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
        artwork() {
            return this.$store.state.artworks.artwork;
        }
    },

    async created() {
        await this.fetchArtwork();
    },
}
</script>

<style scoped>

</style>
