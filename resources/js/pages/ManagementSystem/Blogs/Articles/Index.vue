<template>
    <div class="container my-5 text-open-sans">
        <div class="row justify-content-between my-3">
            <div class="col-6">
                <div class="h2">Manage Articles/Blogs</div>
            </div>
            <div class="col-6">
                <router-link :to="{ name: 'article-create' }" type="button" class="btn btn-outline-dark float-end"><font-awesome-icon :icon="['fas', 'plus']"></font-awesome-icon>  New</router-link>
            </div>
        </div>
        <blogs-table></blogs-table>
    </div>
</template>

<script>
import BlogsTable from "../../../../components/DataTables/Blogs";

export default {
    metaInfo() {
        return {
            title: 'Manage Articles/Blogs',
        }
    },

    components: {
        BlogsTable
    },
}
</script>

<style scoped>

</style>
