<template>
    <div class="container" v-if="!loading">
        <div class="row justify-content-center mt-5 mb-3">
            <div class="col-6 text-center">
                <div class="h3 text-uppercase">Welcome to my Blogs!</div>
                <p class="text-muted text-open-sans">I post updates, and events here!</p>
            </div>
        </div>
        <div id="not-found-container" class="row" v-if="!blogs">
            <div class="col-12">
                <filter-bar :search="webpage.search" @searchWebpage="searchForBlogs" @sortData="changeBlogSorting" :fields="filter_fields"></filter-bar>
                <div class="d-flex justify-content-center align-items-center">
                    <img :src="logo" alt="logo.png" class="img-fluid" width="450px" />
                    <div class="display-5 text-center my-3 text-open-sans">
                        No blogs found, check back later!
                    </div>
                </div>
            </div>
        </div>
        <div v-else>
            <blogs-container
                :folder="assets"
                :articles="latestBlog"
                :search="webpage.search"
                :search-blogs="searchForBlogs"
                :change-blog-sorting="changeBlogSorting"
                :fields="filter_fields">
            </blogs-container>
            <pagination
                :total_data="total_data"
                :last_data="last_data"
                :index_data="index_data"
                :next_page="next_page"
                :previous_page="previous_page"
                :next-page="nextPage"
                :prev-page="prevPage">
            </pagination>
        </div>
    </div>
</template>

<script>
import { GET_BLOGS_PAGE, GET_LATEST_BLOG } from "../../store/types/website";
import BlogsContainer from "../../components/Blogs/Index.vue"
import Pagination from "../../components/Pagination";
import utilHelper from "../../helpers/utl";
import FilterBar from "../../components/FilterBar";

export default {
    metaInfo() {
        return {
            title: 'Blogs',
            meta: [
                {
                    hid: 'description',
                    name: 'description',
                    content: 'Here are the updates on my latest artworks and events I participated at'
                },
                {
                    hid: 'og-title',
                    name: 'og-title',
                    content: 'Blogs'
                },
                {
                    hid: 'og-description',
                    name: 'og-description',
                    content: 'Here are the updates on my latest artworks and events I participated at'
                },
            ]
        }
    },

    components: {
        Pagination,
        BlogsContainer,
        FilterBar
    },

    data() {
        return {
            assets: '/assets/blogs',
            logo: '/assets/logo.png',
            loading: false,
            webpage: {
                search: '',
                page: 1,
                per_page: 9,
                column_name: 'id',
                sort_direction: 'asc'
            },
            api_response: {
                current_page: null,
                from: 0,
                to: 0,
                total: 0,
                prev_page_url: null,
                next_page_url: null,
            },
            filter_fields: [
                {
                    num: 1,
                    label: 'Name',
                    column_equivalent: 'title',
                    sorting: null,
                    icon_desc: 'sort-alpha-up',
                    icon_asc: 'sort-alpha-down',
                },
                {
                    num: 2,
                    label: 'Date',
                    column_equivalent: 'updated_at',
                    sorting: null,
                    icon_desc: 'sort-numeric-up',
                    icon_asc: 'sort-numeric-down',
                },
                {
                    num: 3,
                    label: 'Views',
                    column_equivalent: 'visits',
                    sorting: null,
                    icon_desc: 'sort-amount-up',
                    icon_asc: 'sort-amount-down',
                }
            ],
        }
    },

    methods: {
        async fetchLatest() {
            try {
                const query = {
                    page: this.webpage.page,
                    perPage: this.webpage.per_page,
                    keyword: this.webpage.search,
                    colName: this.webpage.column_name,
                    dir: this.webpage.sort_direction
                }

                const response = await this.$store.dispatch(GET_LATEST_BLOG, query);
            } catch (error) {
                throw error;
            }
        },

        async fetchBlogs() {
            try {
                const query = {
                    page: this.webpage.page,
                    perPage: this.webpage.per_page,
                    keyword: this.webpage.search,
                    colName: this.webpage.column_name,
                    dir: this.webpage.sort_direction
                }

                const response = await this.$store.dispatch(GET_BLOGS_PAGE, query);

                this.api_response = response;
            } catch (error) {
                await Popup.fire({
                    'icon': 'error',
                    'title': '<div class="h3 m-0">'+error.exception+'</div>',
                    'text': (error.message ? error.message : 'Error Occurred')
                })

                throw error;
            }

        },

        async changeBlogSorting(header) {
            this.webpage.column_name = header.column_equivalent;

            // if sorting is null, make it ascending, if not null, check if it's ascending then turn it into descending, or else, make it ascending.
            if (!header.sorting) {
                header.sorting = 'asc';
                this.webpage.sort_direction = 'asc';
            } else if (header.sorting === 'asc') {
                header.sorting = 'desc';
                this.webpage.sort_direction = 'desc';
            } else {
                header.sorting = 'asc';
                this.webpage.sort_direction = 'asc';
            }

            await this.fetchBlogs();
        },

        async searchForBlogs(search) {
            this.webpage.search = search;

            await this.fetchBlogs();
        },

        async nextPage() {
            this.webpage.page = this.api_response.current_page + 1;

            await this.fetchBlogs();
        },

        async prevPage() {
            this.webpage.page = this.api_response.current_page - 1;

            await this.fetchBlogs();
        },
    },

    computed: {
        previous_page() {
            return this.api_response.prev_page_url;
        },

        next_page() {
            return this.api_response.next_page_url;
        },

        index_data() {
            return this.api_response.from;
        },

        last_data() {
            return this.api_response.to;
        },

        total_data() {
            return this.api_response.total;
        },

        blogs() {
            return this.$store.state.website.blogs;
        },

        latestBlog() {
            return this.$store.state.website.latestBlog;
        }
    },

    async created() {
        await this.fetchLatest();
        await this.fetchBlogs();
    },

    watch: {
        ['webpage.search']: utilHelper.debounce(async function() {
            await this.fetchBlogs();
        }, 3000)
    }
}
</script>

<style scoped>

</style>
