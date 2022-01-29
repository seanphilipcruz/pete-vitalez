<template>
    <div class="form-floating">
        <select id="select_data" class="form-control" aria-label="Select how many rows to be shown" @change="setPerPage" v-model="per_page">
            <option :value="value" selected v-for="value in values" :key="value">{{ value }}</option>
        </select>
        <label for="select_data">Show Data</label>
    </div>
</template>

<script>
export default {
    props: {
        perPage: {
            type: Number || String,
        }
    },

    data() {
        return {
            per_page: this.$props.perPage,
            values: [5, 10, 25, 50]
        }
    },

    methods: {
        setPerPage() {
            this.$emit('setPerPage', this.per_page);
        }
    },
}
</script>

<style scoped>

</style>
