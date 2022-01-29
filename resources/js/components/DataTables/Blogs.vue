<template>
    <div class="card">
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-12 mb-3">
                    <div class="row justify-content-around">
                        <div class="col col-md">
                            <select-data @setPerPage="setShownData" :per-page="table.per_page"></select-data>
                        </div>
                        <div class="col col-md-10">
                            <search-bar @type="searchDataTable" :keyword="table.search"></search-bar>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row lead">
                                <div class="col" v-for="header in table.heading" :key="header.num">
                                    <button type="button" class="btn btn-outline-dark" @click="changeSorting(header)">
                                        {{ header.name }} <font-awesome-icon v-if="header.sorting === 'desc'" :icon="['fas', 'caret-up']"></font-awesome-icon> <font-awesome-icon v-else :icon="['fas', 'caret-down']"></font-awesome-icon>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="blogs">
                        <div class="card" v-for="blog in blogs" :key="blog.id">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col body">{{ blog.id }}</div>
                                    <div class="col body">{{ blog.title }}</div>
                                    <div class="col body">{{ trimString(parseHTML(blog.description), 35) }}</div>
                                    <div class="col body">{{ blog.visits }}</div>
                                    <div class="col body">
                                        <div class="badge" :class="blog.is_published === 0 ? 'bg-danger' : 'bg-success'">
                                            {{ blog.is_published === 0 ? 'Draft' : 'Published' }}
                                        </div>
                                    </div>
                                    <div class="col body">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-outline-dark" @click="updateArtwork(blog.id)">
                                                <font-awesome-icon :icon="['fas', 'edit']"></font-awesome-icon> Update
                                            </button>
                                            <button type="button" class="btn btn-outline-dark" @click="deleteArtwork(blog)">
                                                <font-awesome-icon :icon="['fas', 'trash']"></font-awesome-icon> Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-3">
                            <div class="card-body">
                                <div class="row justify-content-between">
                                    <div class="col">
                                        <button type="button" class="btn btn-outline-dark">Showing: {{ index_data }} of {{ last_data }} of {{ total_data }} entries</button>
                                    </div>
                                    <div class="col">
                                        <div class="float-end">
                                            <button type="button" class="btn btn-outline-dark" :class="previous_page === null ? 'disabled' : ''" @click="prevPage"><font-awesome-icon :icon="['fas', 'backward']"></font-awesome-icon></button>
                                            <button type="button" class="btn btn-outline-dark" :class="next_page === null ? 'disabled' : ''" @click="nextPage"><font-awesome-icon :icon="['fas', 'forward']"></font-awesome-icon></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-else>
                        <div class="card">
                            <div class="card-body">
                                <div class="card-text text-center">
                                    No available data found.
                                </div>
                            </div>
                        </div>
                        <div class="card mt-3">
                            <div class="card-body">
                                <div class="row justify-content-between">
                                    <div class="col">
                                        <button type="button" class="btn btn-outline-dark">Showing: {{ index_data }} of {{ last_data }} of {{ total_data }} entries</button>
                                    </div>
                                    <div class="col">
                                        <div class="float-end">
                                            <button type="button" class="btn btn-outline-dark" :class="previous_page === null ? 'disabled' : ''" @click="prevPage"><font-awesome-icon :icon="['fas', 'backward']"></font-awesome-icon></button>
                                            <button type="button" class="btn btn-outline-dark" :class="next_page === null ? 'disabled' : ''" @click="nextPage"><font-awesome-icon :icon="['fas', 'forward']"></font-awesome-icon></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { DELETE_BLOG, GET_BLOGS } from "../../store/types/blogs";
import SearchBar from "../../components/SearchBar";
import SelectData from "../../components/SelectData";
import utilHelper from "../../helpers/utl";

export default {
    components: {
        SearchBar,
        SelectData
    },

    data() {
        return {
            loading: false,
            table: {
                heading: [
                    {
                        num: 1,
                        name: 'Id',
                        column_equivalent: 'id',
                        sorting: null
                    },
                    {
                        num: 2,
                        name: 'Title',
                        column_equivalent: 'title',
                        sorting: null
                    },
                    {
                        num: 3,
                        name: 'Description',
                        column_equivalent: 'description',
                        sorting: null
                    },
                    {
                        num: 4,
                        name: 'Visits',
                        column_equivalent: 'visits',
                        sorting: null
                    },
                    {
                        num: 5,
                        name: 'Article Status',
                        column_equivalent: 'is_published',
                        sorting: null
                    },
                    {
                        num: 6,
                        name: 'Actions',
                        column_equivalent: '',
                        sorting: null
                    },
                ],
                search: '',
                page: 1,
                per_page: 5,
                sort_by: null,
                column_name: '',
                sort_direction: 'asc',
            },
            api_response: {
                current_page: null,
                from: 0,
                to: 0,
                total: 0,
                prev_page_url: null,
                next_page_url: null,
            },
        }
    },

    methods: {
        parseHTML(html) {
            let doc = new DOMParser().parseFromString(html, 'text/html');

            return doc.body.textContent || "";
        },

        trimString(string = "", limit = 0, end = '...') {
            if(string.length > limit) {
                return string.slice(0, limit) + end;
            }

            return string;
        },

        async fetchBlogs() {
            this.loading = true;

            const query = {
                page: this.table.page,
                perPage: this.table.per_page,
                keyword: this.table.search,
                colName: this.table.column_name,
                dir: this.table.sort_direction
            }

            try {
                const result = await this.$store.dispatch(GET_BLOGS, query);

                this.api_response = result.data;
            } catch (error) {
                await Popup.fire({
                    'icon': 'error',
                    'title': '<div class="h4 m-0">'+error.exception+'</div>',
                    'text': error.message
                });

                throw error;
            }
        },

        async searchDataTable(search) {
            this.table.search = search;

            await this.fetchBlogs();
        },

        async setShownData(per_page) {
            this.table.per_page = per_page;

            await this.fetchBlogs();
        },

        async changeSorting(header) {
            this.table.column_name = header.column_equivalent;

            // if sorting is null, make it ascending, if not null, check if it's ascending then turn it into descending, or else, make it ascending.
            if (!header.sorting) {
                header.sorting = 'asc';
                this.table.sort_direction = 'asc';
            } else if (header.sorting === 'asc') {
                header.sorting = 'desc';
                this.table.sort_direction = 'desc';
            } else {
                header.sorting = 'asc';
                this.table.sort_direction = 'asc';
            }

            await this.fetchBlogs();
        },

        async nextPage() {
            this.table.page = this.api_response.current_page + 1;

            await this.fetchBlogs();
        },

        async prevPage() {
            this.table.page = this.api_response.current_page - 1;

            await this.fetchBlogs();
        },

        async updateArtwork(id) {
            return await this.$router.push({ name: 'article-update', params: { id: id } });
        },

        async deleteArtwork(artwork) {
            Popup.fire({
                'icon': 'question',
                'title': 'Are you sure to delete this blog?',
                'text': 'Click to confirm deletion of '+artwork.title,
                'confirmButtonText': 'Confirm',
                'cancelButtonText': 'Cancel'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        const response = await this.$store.dispatch(DELETE_BLOG, artwork);

                        await this.fetchBlogs();

                        await Toast.fire({
                            'icon': 'success',
                            'title': response.data.message
                        });
                    } catch (error) {
                        this.$nextTick(() => {
                            Popup.fire({
                                'icon': 'error',
                                'title': '<div class="h3 mb-0">' + error.exception + '</div>',
                                'text': (error.message ? error.message : 'Error Occurred')
                            });
                        });

                        throw error;
                    }
                }
            });
        }
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
            return this.$store.state.blogs.blogs;
        }
    },

    watch: {
        ["table.search"]: utilHelper.debounce(async function() {
            await this.fetchBlogs();
        }, 800)
    },

    async created() {
        await this.fetchBlogs();
    }
}
</script>

<style scoped>

</style>
