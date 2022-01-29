<template>
  <div class="form-floating">
      <input type="text" id="search" class="form-control" placeholder="Search here" @keydown="search" v-model="query">
      <label for="search">Search</label>
  </div>
</template>

<script>
export default {
    props: {
        keyword: {
            type: String
        }
    },

    data() {
        return {
            query: this.$props.keyword,
        }
    },

    methods: {
        search() {
            this.$emit('type', this.query);
        }
    }
}
</script>

<style scoped>

</style>
