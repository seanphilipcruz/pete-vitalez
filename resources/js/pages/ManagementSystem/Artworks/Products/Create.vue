<template>
    <div class="container my-5">
        <div class="row">
            <div class="col-6">
                <router-link :to="{ name: 'products-index' }" class="btn btn-outline-dark my-3"><font-awesome-icon :icon="['fas', 'arrow-left']"></font-awesome-icon>  Back</router-link>
            </div>
        </div>
        <div class="card">
            <create-form></create-form>
        </div>
    </div>
</template>

<script>
import CreateForm from "../../../../components/Artworks/CreateForm";

export default {
    metaInfo() {
        return {
            title: 'Add Artwork/Product'
        }
    },

    components: {
        CreateForm
    },

}
</script>

<style scoped>

</style>
