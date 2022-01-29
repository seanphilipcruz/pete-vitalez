<template>
    <div class="row mb-3">
        <div class="col-12">
            <div class="row">
                <latest-blog :latest-article="articles" :fetch="fetchBlog"></latest-blog>
                <most-visits :fetch="fetchBlog"></most-visits>
            </div>
            <hr class="my-4">
            <div class="row mb-3">
                <filter-bar :search="search" @searchWebpage="searchBlogs" @sortData="changeBlogSorting" :fields="fields"></filter-bar>
                <articles-container :fetch="fetchBlog"></articles-container>
            </div>
        </div>
    </div>
</template>

<script>
import MostVisits from "./MostVisits";
import LatestBlog from "./Latest";
import ArticlesContainer from "./Container";
import FilterBar from "../FilterBar";

export default {
    components: {
        FilterBar,
        LatestBlog,
        MostVisits,
        ArticlesContainer
    },

    props: {
        folder: {
            required: true,
        },
        articles: {
            required: true,
        },
        search: {
            type: String,
            required: true,
        },
        searchBlogs: {
            type: Function,
            required: true,
        },
        changeBlogSorting: {
            type: Function,
            required: true,
        },
        fields: {
            type: Array,
            required: true
        }
    },

    methods: {
        async fetchBlog(id, title) {
            await this.$router.push({ name: 'blog-view', params: { id: `${id}`, title: `${title}` } });
        }
    }
}
</script>

<style scoped>

</style>
