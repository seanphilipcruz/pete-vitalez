<template>
    <div class="container my-5 text-roboto">
        <div class="row justify-content-between my-3">
            <div class="col-6">
                <div class="h2">Website Messages</div>
            </div>
        </div>
        <message-table></message-table>
    </div>
</template>

<script>
import MessageTable from "../../../components/DataTables/Message";

export default {
    metaInfo() {
        return {
            title: 'Website Messages'
        }
    },

    components: {
        MessageTable
    }
}
</script>

<style scoped>

</style>
