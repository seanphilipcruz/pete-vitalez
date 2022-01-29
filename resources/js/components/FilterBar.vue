<template>
    <div class="row mb-3">
        <div class="col-12 col-sm">
            <input id="search" type="text" class="form-control" placeholder="Search" @keydown="searchWebpage" v-model="keyword">
        </div>
        <div class="col-12 col-sm-2 d-grid">
            <button id="filterDropdown" type="button" class="btn btn-outline-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                Filter <font-awesome-icon :icon="['fas', 'filter']"></font-awesome-icon>
            </button>

            <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                <li v-for="field in fields" :key="field.num"><a href="#" class="dropdown-item" @click="sortData(field)">{{ field.label }} <font-awesome-icon v-if="field.sorting === 'asc'" :icon="['fas', field.icon_desc]"></font-awesome-icon> <font-awesome-icon v-else :icon="['fas', field.icon_asc]"></font-awesome-icon></a></li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        search: {
            required: true
        },
        fields: {
            type: Array,
            required: true,
        }
    },

    data() {
        return {
            keyword: this.$props.search,
        }
    },

    methods: {
        searchWebpage() {
            this.$emit('searchWebpage', this.keyword);
        },

        sortData(field) {
            this.$emit('sortData', field);
        }
    },
}
</script>

<style scoped>

</style>
