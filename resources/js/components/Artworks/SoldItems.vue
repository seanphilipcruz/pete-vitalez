<template>
    <div id="hover-items" class="row mb-3 justify-content-center width-100">
        <div class="col-12" v-for="(artwork, key) in artworks.data" :key="artwork.id">
            <div class="card shadow mb-3" @click="viewArtwork(artwork)" v-if="key % 2 === 0">
                <div class="row g-0 justify-content-center align-items-center">
                    <div class="col-sm">
                        <img :src="folder + '/' + (artwork.image ? artwork.image : fallbackImage)" :alt="artwork ? artwork.image : 'logo.png'" class="img-fluid rounded-start">
                    </div>
                    <div class="col-sm-6 col-md-8">
                        <div class="card-body text-center">
                            <div class="card-title h4">{{ artwork.title }}</div>
                            <div class="card-subtitle">{{ trimString(artwork.sub_title, 18) }}</div>
                            <div v-html="artwork.description" class="card-text text-wrap"></div>
                            <div class="text-black">
                                <div class="badge rounded-pill bg-danger">Sold</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow mb-3" @click="viewArtwork(artwork)" v-if="key % 2">
                <div class="row g-0 justify-content-center align-items-center">
                    <div class="col-sm-6 col-md-8">
                        <div class="card-body text-center">
                            <div class="card-body text-center">
                                <div class="card-title h4">{{ artwork.title }}</div>
                                <div class="card-subtitle">{{ trimString(artwork.sub_title, 18) }}</div>
                                <div v-html="artwork.description" class="card-text"></div>
                                <div class="text-black">
                                    <div class="badge rounded-pill bg-danger">Sold</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm">
                        <img :src="folder + '/' + (artwork.image ? artwork.image : fallbackImage)" :alt="artwork ? artwork.image : 'logo.png'" class="img-fluid rounded-start">
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
