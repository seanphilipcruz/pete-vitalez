<template>
    <div class="container my-5 text-open-sans">
        <div class="row justify-content-between my-3">
            <div class="col-6">
                <div class="h2">Manage Artwork Requests</div>
            </div>
        </div>
        <requests-table></requests-table>
    </div>
</template>

<script>
import RequestsTable from "../../../../components/DataTables/Requests";
export default {
    metaInfo() {
        return {
            title: 'Manage Artwork Requests'
        }
    },

    components: {
        RequestsTable
    }
}
</script>

<style scoped>

</style>
