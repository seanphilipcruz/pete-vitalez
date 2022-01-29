<template>
    <div id="add-event" class="modal fade" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title fw-bold fs-5">Add Event</div>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form ref="event_form">
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="form-floating">
                                    <input id="title" type="text" class="form-control" :class="errors.title ? 'is-invalid': ''" v-model="form.title" placeholder="Event Title">
                                    <label for="title">Event Title</label>
                                    <div class="invalid-feedback">
                                        <ul class="mb-1" v-for="error in errors.title">
                                            {{ error }}
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <input id="description" type="text" class="form-control" :class="errors.description ? 'is-invalid': ''" v-model="form.description" placeholder="Event Description">
                                    <label for="description">Event Description</label>
                                    <div class="invalid-feedback">
                                        <ul class="mb-1" v-for="error in errors.description">
                                            {{ error }}
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <div class="form-floating mb-3">
                                    <input id="start_date" type="date" class="form-control" :class="errors.start ? 'is-invalid': ''" v-model="form.start" placeholder="Start Date">
                                    <label for="start_date">Start Date</label>
                                    <div class="invalid-feedback">
                                        <ul class="mb-1" v-for="error in errors.start">
                                            {{ error }}
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-floating mb-3">
                                    <input id="end_date" type="date" class="form-control" :class="errors.end ? 'is-invalid': ''" v-model="form.end" placeholder="Start Date">
                                    <label for="end_date">End Date</label>
                                    <div class="invalid-feedback">
                                        <ul class="mb-1" v-for="error in errors.end">
                                            {{ error }}
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <select id="type" class="form-select" v-model="form.type" aria-label="Select event type">
                                        <option value="exhibition">Exhibitions</option>
                                        <option value="guesting">Guesting / Feature</option>
                                    </select>
                                    <label for="type">Event Type</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3 justify-content-center">
                            <div class="col-2 d-grid">
                                <button type="button" class="btn btn-outline-dark" @click="addEvent">
                                    <font-awesome-icon :icon="['fas', 'check-circle']" /> Save
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button class="btn btn-outline-dark" data-bs-dismiss="modal" ref="close">
                        <font-awesome-icon :icon="['fas', 'times-circle']" /> Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { CREATE_EVENT } from "../../store/types/content";

const defaultForm = {
    title: null,
    description: null,
    start: null,
    end: null,
    type: 'exhibition',
}

const formErrors = {
    title: null,
    description: null,
    start: null,
    end: null,
}

export default {
    props: {
        refresh: {
            type: Function,
            required: true
        }
    },

    data() {
        return {
            errors: Object.assign({}, formErrors),
            form: Object.assign({}, defaultForm),
        }
    },

    methods: {
        async addEvent() {
            try {
                const response = await this.$store.dispatch(CREATE_EVENT, this.form);

                this.$refs.close.click();

                this.$refs.event_form.reset();

                this.form = Object.assign({}, defaultForm);

                await this.$props.refresh();

                await Toast.fire({
                    'icon': response.data.status,
                    'title': response.data.message
                });
            } catch (error) {
                this.errors = error.response.data.message;

                throw error
            }
        },
    }
}
</script>

<style scoped>

</style>
