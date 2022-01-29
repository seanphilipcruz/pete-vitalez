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
                    <div v-if="orders">
                        <div class="card" v-for="order in orders" :key="order.id">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col body">{{ order.id }}</div>
                                    <div class="col body">{{ order.product.title }}</div>
                                    <div class="col body">{{ order.customer.first_name }} {{ order.customer.middle_name }}  {{ order.customer.last_name }}</div>
                                    <div class="col body">{{ order.code }}</div>
                                    <div class="col body">PHP {{ order.total }}</div>
                                    <div class="col body">
                                        <div class="badge" :class="order.is_done === 0 ? 'bg-danger' : 'bg-success'">
                                            {{ order.is_done === 0 ? 'Pending' : 'Sold' }}
                                        </div>
                                    </div>
                                    <div class="col body">
                                        <div class="btn-group" v-if="order.is_done === 0">
                                            <button type="button" class="btn btn-outline-dark" @click="updateOrder(order)">
                                                Finish
                                            </button>
                                            <button type="button" class="btn btn-outline-dark" @click="deleteOrder(order)">
                                                Remove
                                            </button>
                                        </div>
                                        <div v-else>
                                            Order has been sold.
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
import { GET_ORDERS, UPDATE_ORDER, DELETE_ORDER } from "../../store/types/artworks";
import SearchBar from "../SearchBar";
import SelectData from "../SelectData";
import utilHelper from "../../helpers/utl";

export default {
    components: {
        SelectData,
        SearchBar,
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
                        name: 'Product',
                        column_equivalent: 'product_name',
                        sorting: null
                    },
                    {
                        num: 3,
                        name: 'Customer',
                        column_equivalent: 'customer_name',
                        sorting: null
                    },
                    {
                        num: 4,
                        name: 'Order Code',
                        column_equivalent: 'code',
                        sorting: null
                    },
                    {
                        num: 5,
                        name: 'Total',
                        column_equivalent: 'total',
                        sorting: null
                    },
                    {
                        num: 6,
                        name: 'Status',
                        column_equivalent: 'is_done',
                        sorting: null
                    },
                    {
                        num: 7,
                        name: 'Actions',
                        column_equivalent: '',
                        sorting: null
                    },
                ],
                search: '',
                page: 1,
                per_page: 5,
                sort_by: null,
                column_name: 'id',
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
        trimString(string = "", limit = 0, end = '...') {
            if(string.length > limit) {
                return string.slice(0, limit) + end;
            }

            return string;
        },

        async fetchOrders() {
            this.loading = true;

            const query = {
                page: this.table.page,
                perPage: this.table.per_page,
                keyword: this.table.search,
                colName: this.table.column_name,
                dir: this.table.sort_direction
            }

            try {
                const result = await this.$store.dispatch(GET_ORDERS, query);

                this.api_response = result.data;
            } catch (error) {
                await Popup.fire({
                    'icon': 'error',
                    'title': '<div class="h4 m-0">'+error.response.data.exception+'</div>',
                    'text': error.response.data.message
                });

                throw error;
            }
        },

        async searchDataTable(search) {
            this.table.search = search;

            await this.fetchOrders();
        },

        async setShownData(per_page) {
            this.table.per_page = per_page;

            await this.fetchOrders();
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

            await this.fetchOrders();
        },

        async nextPage() {
            this.table.page = this.api_response.current_page + 1;

            await this.fetchOrders();
        },

        async prevPage() {
            this.table.page = this.api_response.current_page - 1;

            await this.fetchOrders();
        },

        async updateOrder(order) {
            if (order.is_done === 0) {
                await Popup.fire({
                    'icon': 'question',
                    'title': 'Is this order finished? Action is irreversible.',
                    'text': 'An invoice or official receipt will be sent to the customer',
                    'confirmButtonText': 'Yes',
                    'cancelButtonText': 'No'
                }).then(async (result) => {
                    if (result.isConfirmed) {
                        try {
                            order.is_done = 1;

                            const response = await this.$store.dispatch(UPDATE_ORDER, order);

                            await this.fetchOrders();

                            await Toast.fire({
                                'icon': 'success',
                                'title': response.data.message,
                            });
                        } catch (error) {
                            throw error;
                        }
                    }
                })
            } else {
                await Popup.fire({
                    'icon': 'question',
                    'title': 'Is the order unfinished?',
                    'text': 'Click yes to confirm',
                    'confirmButtonText': 'Yes',
                    'cancelButtonText': 'No'
                }).then(async (result) => {
                    if (result.isConfirmed) {
                        try {
                            order.is_done = 0;

                            const response = await this.$store.dispatch(UPDATE_ORDER, order);

                            await this.fetchOrders();

                            await Toast.fire({
                                'icon': 'success',
                                'title': response.data.message,
                            });
                        } catch (error) {
                            throw error;
                        }
                    }
                })
            }
        },

        async deleteOrder(order) {
            Popup.fire({
                'icon': 'question',
                'title': 'Are you sure to delete this artwork?',
                'text': 'Click yes to confirm deletion of '+order.title,
                'confirmButtonText': 'Confirm',
                'cancelButtonText': 'Cancel'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        const response = await this.$store.dispatch(DELETE_ORDER, order);

                        await this.fetchOrders();

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

    async created() {
        await this.fetchOrders();
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

        orders() {
            return this.$store.state.orders.orders;
        }
    },

    watch: {
        ["table.search"]: utilHelper.debounce(async function() {
            await this.fetchOrders();
        }, 800)
    }
}
</script>

<style scoped>

</style>
