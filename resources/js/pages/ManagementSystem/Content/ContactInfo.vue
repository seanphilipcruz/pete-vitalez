<template>
    <div class="row mb-3">
        <div class="col-12">
            <div class="row mb-3">
                <div class="col-12">
                    <router-link :to="{ name: 'dashboard' }" class="btn btn-outline-dark">
                        <font-awesome-icon :icon="['fas', 'arrow-left']" /> Back
                    </router-link>
                    <button v-if="!user_info" class="btn btn-outline-dark float-end" @click="saveContactInfo">
                        <font-awesome-icon :icon="['fas', 'check-circle']" /> Save
                    </button>
                    <button v-else-if="editMode && user_info" class="btn btn-outline-dark float-end" @click="updateContactInfo">
                        <font-awesome-icon :icon="['fas', 'check-circle']" /> Update
                    </button>
                    <button v-else class="btn btn-outline-dark float-end" @click="editMode = !editMode">
                        <font-awesome-icon :icon="['fas', 'wrench']" /> Edit
                    </button>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header fs-4 fw-bold">Contact Information</div>
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-6" v-if="!user_info">
                                    <div class="form-floating mb-3">
                                        <input id="save_name" type="text" class="form-control" placeholder="Name" v-model="form.name">
                                        <label for="save_name">Name</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input id="save_address" type="text" class="form-control" placeholder="Address" v-model="form.address">
                                        <label for="save_address">Address</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input id="save_email" type="text" class="form-control" placeholder="Email Address" v-model="form.email">
                                        <label for="save_email">Email</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input id="save_contact_number" type="text" class="form-control" placeholder="Contact Number" v-model="form.contact_number">
                                        <label for="save_contact_number">Contact Number</label>
                                    </div>
                                    <editor :api-key="tiny.key" :init="tiny.config" v-model="form.description"></editor>
                                </div>
                                <div class="col-6" v-else-if="!editMode && user_info">
                                    <div class="form-floating mb-3">
                                        <input id="name" type="text" class="form-control" placeholder="Name" readonly :value="user_info.name">
                                        <label for="name">Name</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input id="address" type="text" class="form-control" placeholder="Address" readonly :value="user_info.address">
                                        <label for="address">Address</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input id="email" type="text" class="form-control" placeholder="Email Address" readonly :value="user_info.email">
                                        <label for="email">Email</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input id="contact_number" type="text" class="form-control" placeholder="Contact Number" readonly :value="user_info.contact_number">
                                        <label for="contact_number">Contact Number</label>
                                    </div>
                                    <div class="mb-3">
                                        <div class="fs-5">Description // Meet The Artist</div>
                                        <div v-html="user_info.description"></div>
                                    </div>
                                </div>
                                <div class="col-6" v-if="editMode && user_info">
                                    <div class="form-floating mb-3">
                                        <input id="update_name" type="text" class="form-control" placeholder="Name" v-model="form.name">
                                        <label for="update_name">Name</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input id="update_address" type="text" class="form-control" placeholder="Address" v-model="form.address">
                                        <label for="update_address">Address</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input id="update_email" type="text" class="form-control" placeholder="Email Address" v-model="form.email">
                                        <label for="update_email">Email</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input id="update_contact_number" type="text" class="form-control" placeholder="Contact Number" v-model="form.contact_number">
                                        <label for="update_contact_number">Contact Number</label>
                                    </div>
                                    <editor :api-key="tiny.key" :init="tiny.config" v-model="form.description"></editor>
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
import { GET_CONTACT, CREATE_CONTACT, UPDATE_CONTACT } from "../../../store/types/content";
import Editor from "@tinymce/tinymce-vue";

const defaultForm = {
    id: null,
    name: null,
    address: null,
    email: null,
    contact_number: null,
    description: null,
}

const formErrors = {
    name: null,
    address: null,
    email: null,
    contact_number: null,
    description: null,
}

export default {
    components: {
        Editor,
    },

    data() {
        return {
            editMode: false,
            form: Object.assign({}, defaultForm),
            errors: Object.assign({}, formErrors),
            tiny: {
                key: process.env.MIX_APP_TINY_API_KEY,
                config: {
                    height: 300,
                    width: '100%',
                    plugins: [
                        'lists link image paste help wordcount'
                    ],
                    toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | help',
                    image_caption: true,
                    image_advtab: true,
                }
            },
        }
    },

    methods: {
        async getContactInfo() {
            try {
                const response = await this.$store.dispatch(GET_CONTACT);

                if (!this.user_info) {

                } else {
                    this.form = this.user_info;
                    this.form.description = this.user_info.description;
                }
            } catch (error) {
                throw error;
            }
        },

        async saveContactInfo() {
            try {
                const response = await this.$store.dispatch(CREATE_CONTACT, this.form);

                this.editMode = false;

                await Toast.fire({
                    'icon': response.data.status,
                    'title': response.data.message,
                });

                await this.getContactInfo();
            } catch (error) {
                throw error;
            }
        },

        async updateContactInfo() {
            try {
                const response = await this.$store.dispatch(UPDATE_CONTACT, this.form);

                this.editMode = false;

                await Toast.fire({
                    'icon': response.data.status,
                    'title': response.data.message,
                });

                await this.getContactInfo();
            } catch (error) {
                throw error;
            }
        }
    },

    computed: {
        user_info() {
            return this.$store.state.content.contact;
        }
    },

    async created() {
        await this.getContactInfo();
    },
}
</script>

<style scoped>

</style>
