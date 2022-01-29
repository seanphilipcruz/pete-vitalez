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
                    <div v-if="!messages">
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
                    <div v-else>
                        <div class="card" v-for="message in messages" :key="message.id">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col body">{{ message.id }}</div>
                                    <div class="col body">{{ message.name }}</div>
                                    <div class="col body">{{ message.email }}</div>
                                    <div class="col body">{{ trimString(parseHTML(message.content), 35) }}</div>
                                    <div class="col body">
                                        <div class="badge" :class="message.is_read === 0 ? 'bg-danger' : 'bg-success'">
                                            {{ message.is_read === 0 ? 'Unread' : 'Read' }}
                                        </div>
                                    </div>
                                    <div class="col body">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-outline-dark" data-bs-target="#view-message" data-bs-toggle="modal" @click="getMessage(message.id)">
                                                <font-awesome-icon :icon="['fas', 'envelope-open']" /> View
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
                </div>
            </div>
        </div>
        <view-message />
    </div>
</template>

<script>
import { GET_MESSAGES, GET_MESSAGE } from "../../store/types/message";
import SelectData from "../SelectData";
import SearchBar from "../SearchBar";
import ViewMessage from "../Modals/ViewMessageModal";
import utilHelper from "../../helpers/utl";

export default {
    components: {
        ViewMessage,
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
                        name: 'Name',
                        column_equivalent: 'name',
                        sorting: null
                    },
                    {
                        num: 3,
                        name: 'Email',
                        column_equivalent: 'email',
                        sorting: null
                    },
                    {
                        num: 4,
                        name: 'Message',
                        column_equivalent: 'content',
                        sorting: null
                    },
                    {
                        num: 5,
                        name: 'Status',
                        column_equivalent: 'is_read',
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

        async getMessage(id) {
            try {
                const result = await this.$store.dispatch(GET_MESSAGE, id);

                await this.fetchMessages();
            } catch (error) {
                throw error;
            }
        },

        async fetchMessages() {
            this.loading = true;

            const query = {
                page: this.table.page,
                perPage: this.table.per_page,
                keyword: this.table.search,
                colName: this.table.column_name,
                dir: this.table.sort_direction
            }

            try {
                const result = await this.$store.dispatch(GET_MESSAGES, query);

                this.api_response = result.data;
            } catch (error) {
                await Popup.fire({
                    'icon': 'error',
                    'title': '<div class="h4 m-0">'+error.response.data.exception+'</div>',
                    'text': error.response.data.message
                });

                throw error;
            }

            this.loading = false;
        },

        async searchDataTable(search) {
            this.table.search = search;

            await this.fetchMessages();
        },

        async setShownData(per_page) {
            this.table.per_page = per_page;

            await this.fetchMessages();
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

            await this.fetchMessages();
        },

        async nextPage() {
            this.table.page = this.api_response.current_page + 1;

            await this.fetchMessages();
        },

        async prevPage() {
            this.table.page = this.api_response.current_page - 1;

            await this.fetchMessages();
        },
    },

    async created() {
        await this.fetchMessages();
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

        messages() {
            return this.$store.state.message.messages;
        },

        message() {
            return this.$store.state.message.message;
        }
    },

    watch: {
        ["table.search"]: utilHelper.debounce(async function() {
            await this.fetchMessages();
        }, 800)
    }
}
</script>

<style scoped>

</style>
