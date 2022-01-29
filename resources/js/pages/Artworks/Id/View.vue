<template>
    <div class="container my-5">
        <div class="row mb-3">
            <div class="col-6">
                <router-link v-if="artwork.is_sold === 0" :to="{ name: 'available' }" class="btn btn-outline-dark my-3"><font-awesome-icon :icon="['fas', 'arrow-left']"></font-awesome-icon>  Back</router-link>
                <router-link v-else :to="{ name: 'sold' }" class="btn btn-outline-dark my-3"><font-awesome-icon :icon="['fas', 'arrow-left']"></font-awesome-icon>  Back</router-link>
            </div>
        </div>
        <main-product :folder="folder" :artwork="artwork"></main-product>
        <gallery :photo="artwork.photo"></gallery>
    </div>
</template>

<script>
import { GET_ARTWORK_PAGE } from "../../../store/types/website";
import MainProduct from "../../../components/Artworks/MainProduct";
import Gallery from "../../../components/Artworks/Gallery";
import OrderModal from "../../../components/Modals/OrderModal";

export default {
    metaInfo() {
        return {
            title: this.artwork.title ? this.artwork.title : 'Loading ...',
            meta: [
                {
                    hid: 'description',
                    name: 'description',
                    content: this.artwork.description ? this.parseHTML(this.artwork.description) : 'Loading ...',
                },
                {
                    hid: 'og-title',
                    name: 'og-title',
                    content: this.artwork.title ? this.artwork.title : 'Loading ...'
                },
                {
                    hid: 'og-description',
                    name: 'og-description',
                    content: this.artwork.description ? this.parseHTML(this.artwork.description) : 'Loading ...',
                },
            ]
        }
    },

    components: {
        Gallery,
        MainProduct
    },

    data() {
        return {
            loading: false,
            folder: '/images/artworks',
        }
    },

    methods: {
        async fetchItem() {
            this.loading = true;

            try {
                const id = this.$route.params.id;

                const response = await this.$store.dispatch(GET_ARTWORK_PAGE, id);
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
        artwork() {
            return this.$store.state.website.product;
        }
    },

    async created() {
        await this.fetchItem();
    },
}
</script>

<style scoped>

</style>
