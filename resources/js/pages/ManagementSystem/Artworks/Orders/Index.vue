<template>
    <div class="container my-5 text-open-sans">
        <div class="row justify-content-between my-3">
            <div class="col-6">
                <div class="h2">Manage Orders</div>
            </div>
        </div>
        <orders-table></orders-table>
    </div>
</template>

<script>
import OrdersTable from "../../../../components/DataTables/Orders";

export default {
    metaInfo() {
        return {
            title: 'Manage Orders'
        }
    },

    components: {
        OrdersTable
    }
}
</script>

<style scoped>

</style>
