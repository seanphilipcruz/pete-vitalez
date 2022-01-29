<template>
    <div class="container my-5 text-open-sans">
        <div class="row justify-content-between my-3">
            <div class="col-6">
                <div class="h2">Manage Artworks/Products</div>
            </div>
            <div class="col-6">
                <router-link :to="{ name: 'products-create' }" type="button" class="btn btn-outline-dark float-end"><font-awesome-icon :icon="['fas', 'plus']"></font-awesome-icon>  New</router-link>
            </div>
        </div>
        <artworks-table></artworks-table>
    </div>
</template>

<script>
import ArtworksTable from "../../../../components/DataTables/Artworks";

export default {
    metaInfo() {
        return {
            title: 'Manage Artworks/Products'
        }
    },

    components: {
        ArtworksTable
    }
}
</script>

<style scoped>

</style>
