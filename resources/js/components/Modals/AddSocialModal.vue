<template>
    <div id="add-social" class="modal fade" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">Add Social Link</div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form ref="social_form">
                    <div class="modal-body">
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
                        <div class="row mb-3 justify-content-center">
                            <div class="col-4 d-grid">
                                <button type="button" class="btn btn-outline-dark" @click="addSocial">
                                    <font-awesome-icon :icon="['fas', 'check-circle']" /> Save
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal" ref="close">
                        <font-awesome-icon :icon="['fas', 'times-circle']" /> Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { CREATE_SOCIAL } from "../../store/types/content";

const defaultForm = {
    site: null,
    url: null,
}

const formErrors = {
    site: null,
    url: null,
}

export default {
    props: {
        refresh: {
            type: Function,
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
        async addSocial() {
            try {
                const response = await this.$store.dispatch(CREATE_SOCIAL, this.form);

                this.$refs.close.click();

                this.$refs.social_form.reset();

                this.form = Object.assign({}, defaultForm);

                await this.$props.refresh();

                await Toast.fire({
                    'icon': response.data.status,
                    'title': response.data.message
                });
            } catch (error) {
                this.errors = error.response.data.message

                throw error;
            }
        }
    },
}
</script>

<style scoped>

</style>
