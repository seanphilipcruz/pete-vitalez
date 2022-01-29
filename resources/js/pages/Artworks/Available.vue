<template>
    <div class="container" v-if="!loading">
        <div class="row justify-content-center my-5">
            <div class="col-6 text-center">
                <div class="h3 text-uppercase">Available Artworks for Sale</div>
                <p class="text-muted">These are my artworks available for sale with Certificate of Authenticity.</p>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12" v-if="!artworks">
                <div class="d-flex justify-content-center align-items-center">
                    <img :src="logo" alt="logo.png" class="img-fluid" width="450px" />
                    <div class="display-5 text-center my-3 text-open-sans">
                        Thank you for your support!
                    </div>
                </div>
            </div>
            <div class="col-12" v-else>
                <filter-bar :search="webpage.search" :fields="fields" :website="webpage" @searchWebpage="searchAvailableProducts" @sortData="changeSorting" />
                <artwork-items :folder="assets" :artworks="artworks" />
                <pagination :index_data="index_data" :last_data="last_data" :total_data="total_data" :next_page="next_page" :previous_page="previous_page" :next-page="nextPage" :prev-page="prevPage" />
            </div>
        </div>
    </div>
</template>

<script>
import { GET_ARTWORKS_PAGE } from "../../store/types/website";
import FilterBar from "../../components/FilterBar";
import ArtworkItems from "../../components/Artworks/Items";
import Pagination from "../../components/Pagination";
import utilHelper from "../../helpers/utl";

export default {
    metaInfo() {
        return {
            title: 'Artworks',
            meta: [
                {
                    hid: 'description',
                    name: 'description',
                    content: 'Here are the artworks available for sale',
                },
                {
                    hid: 'og-title',
                    name: 'og-title',
                    content: 'Artworks'
                },
                {
                    hid: 'og-description',
                    name: 'og-description',
                    content: 'Here are the artworks available for sale',
                },
            ]
        }
    },

    components: {
        Pagination,
        ArtworkItems,
        FilterBar
    },

    data() {
        return {
            assets: '/images/artworks',
            logo: '/assets/logo.png',
            loading: false,
            webpage: {
                search: '',
                page: 1,
                per_page: 12,
                product_status: 'Available',
                column_name: '',
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
            fields: [
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
                    column_equivalent: 'created_at',
                    sorting: null,
                    icon_desc: 'sort-numeric-up',
                    icon_asc: 'sort-numeric-down',
                },
                {
                    num: 3,
                    label: 'Price',
                    column_equivalent: 'price',
                    sorting: null,
                    icon_desc: 'sort-amount-up',
                    icon_asc: 'sort-amount-down',
                }
            ]
        }
    },

    methods: {
        async fetchItems() {
            this.loading = true;

            try {
                const query = {
                    page: this.webpage.page,
                    perPage: this.webpage.per_page,
                    keyword: this.webpage.search,
                    productStatus: this.webpage.product_status,
                    colName: this.webpage.column_name,
                    dir: this.webpage.sort_direction
                }

                const response = await this.$store.dispatch(GET_ARTWORKS_PAGE, query);

                this.api_response = response.data;
            } catch (error) {
                await Popup.fire({
                    'icon': 'error',
                    'title': '<div class="h3 m-0">'+error.exception+'</div>',
                    'text': (error.message ? error.message : 'Error Occurred')
                })

                throw error;
            }

            this.loading = false;
        },

        async changeSorting(header) {
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

            await this.fetchItems();
        },

        async searchAvailableProducts(search) {
            this.webpage.search = search;

            await this.fetchItems();
        },

        async nextPage() {
            this.loading = true;

            this.webpage.page = this.api_response.current_page + 1;

            await this.fetchItems();

            this.loading = false;
        },

        async prevPage() {
            this.loading = true;

            this.webpage.page = this.api_response.current_page - 1;

            await this.fetchItems();

            this.loading = false;
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

        artworks() {
            return this.$store.state.website.products;
        }
    },

    async created() {
        await this.fetchItems();
    },

    watch: {
        ['webpage.search']: utilHelper.debounce(async function() {
            await this.fetchItems();
        }, 800)
    }
}
</script>

<style scoped>

</style>
