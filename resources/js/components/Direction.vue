<template>
    <div class="form-floating">
        <select id="select_data" class="form-control" aria-label="Select how many rows to be shown" v-model="direction" @change="setSortDirection">
            <option value="ascending" selected>Ascending</option>
            <option value="descending" selected>Descending</option>
        </select>
        <label for="select_data">Sort Direction</label>
    </div>
</template>

<script>
export default {
    data() {
        return {
            direction: 'ascending',
        }
    },

    methods: {
        setSortDirection() {
            this.$emit('set_direction', this.direction)
        }
    }
}
</script>

<style scoped>

</style>
