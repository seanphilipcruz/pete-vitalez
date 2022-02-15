<template>
    <div id="hover-items" class="row mb-3">
        <div class="col-12 col-sm-6 col-md-3 mb-3" v-for="artwork in artworks.data" :key="artwork.id">
            <div class="card shadow" @click="viewArtwork(artwork)">
                <img :src="folder + '/' + (artwork.image ? artwork.image : fallbackImage)" :alt="artwork ? artwork.image : 'logo.png'" class="card-img-top">
                <div class="card-body text-center">
                    <div class="card-text">
                        <div class="card-title h4 fw-bold text-open-sans">{{ artwork.title }}</div>
                        <div class="card-subtitle">{{ trimString(artwork.sub_title, 18) }}</div>
                        <div class="text-black">₱{{ artwork.price }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        artworks: {
            required: true,
        },
        folder: {
            type: String,
            required: true
        },
    },

    data() {
        return {
            fallbackImage: 'logo.png',
        }
    },

    methods: {
        viewArtwork(artwork) {
            this.$router.push({ name: 'artwork-product', params: { id: artwork.id, title: artwork.title } });
        },

        trimString(string = "", limit = 0, end = '...') {
            if(string.length > limit) {
                return string.slice(0, limit) + end;
            }

            return string;
        },
    },

    computed: {

    }
}
</script>

<style scoped>

</style>
