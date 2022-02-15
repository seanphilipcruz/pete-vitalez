<template>
    <div id="update-social" class="modal fade" role="dialog" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content" v-if="$props.social.id">
                <div class="modal-header">
                    <div class="modal-title fs-5">
                        <div class="fw-bold">Update <span class="text-capitalize">{{ $props.social.site }}</span> Link</div>
                    </div>
                    <button type="button" ref="close" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form ref="social_update_form">
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="form-floating">
                                    <select id="website" class="form-select" :class="errors.site ? 'is-invalid': ''" v-model="form.site">
                                        <option value="null" selected>Select social media</option>
                                        <option value="facebook">Facebook</option>
                                        <option value="twitter">Twitter</option>
                                        <option value="instagram">Instagram</option>
                                        <option value="linkedin">LinkedIn</option>
                                    </select>
                                    <label for="website">Site</label>
                                    <div class="invalid-feedback">
                                        <ul class="mb-1" v-for="error in errors.site">
                                            {{ error }}
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="form-floating">
                                    <input id="url" type="text" class="form-control" :class="errors.url ? 'is-invalid' : ''" placeholder="Url" v-model="form.url">
                                    <label for="url">Url</label>
                                    <div class="invalid-feedback">
                                        <ul class="mb-1" v-for="error in errors.url">
                                            {{ error }}
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <div class="col-12">
                                    <div class="form-floating">
                                        <select id="order" class="form-select" v-model="form.order">
                                            <option value="0">0</option>
                                            <option :value="order" v-for="order in order_count" :key="order">{{ order }}</option>
                                        </select>
                                        <label for="order">Order</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="btn-group">
                        <button type="button" class="btn btn-outline-dark" @click="UpdateSocial">
                            <font-awesome-icon :icon="['fas', 'check-circle']" /> Update
                        </button>
                        <button type="button" class="btn btn-outline-dark" @click="DeleteSocial">
                            <font-awesome-icon :icon="['fas', 'trash']" /> Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { UPDATE_SOCIAL, DELETE_SOCIAL } from "../../store/types/content";

const defaultForm = {
    site: null,
    url: null,
    order: null
}

const formErrors = {
    site: null,
    url: null,
    order: null
}

export default {
    props: {
        refresh: {
            type: Function,
            required: true,
        },

        social: {
            type: Object,
            required: true,
        },

        order_count: {
            type: Number,
            required: true,
        }
    },

    data() {
        return {
            errors: Object.assign({}, formErrors),
            form: Object.assign({}, defaultForm),
        }
    },

    methods: {
        async UpdateSocial() {
            try {
                const response = await this.$store.dispatch(UPDATE_SOCIAL, this.form);

                this.$refs.close.click();

                await this.$props.refresh();

                await Toast.fire({
                    icon: response.data.status,
                    title: response.data.message,
                });
            } catch (err) {
                throw err;
            }
        },

        async DeleteSocial() {
            try {
                await Popup.fire({
                    'icon': 'question',
                    'title': 'Are you sure?',
                    'html': 'Delete <span class="text-capitalize">'+this.$props.social.site+'</span>?',
                    'confirmButtonText': 'Yes',
                    'cancelButtonText': 'No',
                }).then(async (result) => {
                    if (result.isConfirmed) {
                        const response = await this.$store.dispatch(DELETE_SOCIAL, this.$props.social);

                        await this.$refs.close.click();

                        await this.$props.refresh();

                        await Toast.fire({
                            icon: response.data.status,
                            title: response.data.message,
                        });
                    }
                }).catch((error) => {
                    throw error;
                });
            } catch (err) {
                throw err;
            }
        }
    },

    watch: {
        social: {
            deep: true,
            immediate: true,
            handler: function (value, oldValue) {
                console.debug(value);
                this.form = value;
            }
        }
    }
}
</script>

<style scoped>

</style>
