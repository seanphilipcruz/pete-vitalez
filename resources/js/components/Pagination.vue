<template>
    <div class="row justify-content-between mb-3">
        <div class="col-8">
            <button type="button" class="btn btn-outline-dark">Showing: {{ index_data }} of {{ last_data }} of {{ total_data }} entries</button>
        </div>
        <div class="col">
            <div class="float-end">
                <button type="button" class="btn btn-outline-dark" :class="previous_page === null ? 'disabled' : ''" @click="prevPage"><font-awesome-icon :icon="['fas', 'backward']"></font-awesome-icon></button>
                <button type="button" class="btn btn-outline-dark" :class="next_page === null ? 'disabled' : ''" @click="nextPage"><font-awesome-icon :icon="['fas', 'forward']"></font-awesome-icon></button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        index_data: {
            required: true
        },
        last_data: {
            required: true
        },
        total_data: {
            required: true
        },
        previous_page: {
            required: true
        },
        next_page: {
            required: true
        },

        prevPage: {
            type: Function,
            required: true
        },

        nextPage: {
            type: Function,
            required: true
        }
    },
}
</script>

<style scoped>

</style>
