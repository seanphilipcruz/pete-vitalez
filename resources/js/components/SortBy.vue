<template>
    <div class="form-floating">
        <select id="select_data" class="form-control" aria-label="Select how many rows to be shown" v-model="header_title" @change="setSortField">
            <option value="null" selected>Select field</option>
            <option :value="title.name" v-for="title in heading" :key="title.num">{{ title.name }}</option>
        </select>
        <label for="select_data">Sort By</label>
    </div>
</template>

<script>
export default {
    props: {
        heading: {
            type: Array,
            required: true
        }
    },

    data() {
        return {
            header_title: null
        }
    },

    methods: {
        setSortField() {
            this.$emit('change', this.header_title);
        }
    }
}
</script>

<style scoped>

</style>
