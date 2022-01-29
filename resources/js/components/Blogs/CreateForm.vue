<template>
    <form ref="form" v-model="valid" novalidate>
        <div class="card-header">
            <div class="card-title">
                <div class="h3 my-2">Add New Artwork</div>
            </div>
        </div>
        <div class="card body">
            <div class="my-3">
                <div class="row justify-content-center mb-3">
                    <div class="col-4">
                        <div class="form-floating">
                            <input type="text" id="title" class="form-control" :class="form_errors.title ? 'is-invalid' : ''" v-model="form.title" placeholder="Title">
                            <label for="title" class="form-label">Title</label>
                            <div v-if="form_errors.title" class="invalid-feedback">
                                <ul class="m-0" v-for="value in form_errors.title">
                                    {{ value }}
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-floating">
                            <input type="text" id="subtitle" class="form-control" :class="form_errors.sub_title ? 'is-invalid' : ''" v-model="form.sub_title" placeholder="Sub Title">
                            <label for="subtitle" class="form-label">Sub Title</label>
                            <div v-if="form_errors.sub_title" class="invalid-feedback">
                                <ul class="m-0" v-for="value in form_errors.sub_title">
                                    {{ value }}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-8 mb-3">
                        <editor :api-key="tiny.key" :init="tiny.config" v-model="form.description" :class="form_errors.description ? 'is-invalid' : ''"></editor>
                        <div v-if="form_errors.description" class="invalid-feedback">
                            <ul class="m-0" v-for="value in form_errors.description">
                                {{ value }}
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center mb-3">
                    <div class="col-4">
                        <div class="form-floating">
                            <input type="date" id="date" class="form-control" :class="form_errors.date ? 'is-invalid' : ''" v-model="form.date" placeholder="Date">
                            <label for="date">Date</label>
                            <div v-if="form_errors.date" class="invalid-feedback">
                                <ul class="m-0" v-for="value in form_errors.date">
                                    {{ value }}
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-floating">
                            <select id="is_sold" class="form-select" v-model="form.is_published" data-popper-placement="Status">
                                <option value="1">Published</option>
                                <option value="0">Draft</option>
                            </select>
                            <label for="is_sold">Blog Status</label>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center mb-3">
                    <div class="col-6 text-center">
                        <a href="#cropperModal" ref="upload" data-bs-toggle="modal" hidden>Upload Image</a>
                        <label for="file_upload">Artwork Image</label>
                        <input id="file_upload" type="file" class="form-control" :class="form_errors.image ? 'is-invalid' : ''" @click="uploadImage" placeholder="Artwork Image">
                        <div v-if="form_errors.image" class="invalid-feedback">
                            <ul class="m-0" v-for="value in form_errors.image">
                                {{ value }}
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-4 text-center">
                        <button id="submit_button" type="button" class="btn btn-outline-dark" @click="submit"><font-awesome-icon :icon="['fas', 'check-circle']"></font-awesome-icon> Save</button>
                    </div>
                </div>
            </div>
        </div>
        <cropper-modal @getImageName="setImageName" type="blog"></cropper-modal>
    </form>
</template>

<script>
import { CREATE_BLOG } from "../../store/types/blogs";
import Editor from "@tinymce/tinymce-vue";
import CropperModal from "../Modals/CropperModal";

const defaultForm = {
    title: null,
    sub_title: null,
    description: null,
    date: null,
    image: null,
    visits: 0,
    likes: 0,
    is_published: 1,
}

const errors = {
    title: null,
    sub_title: null,
    description: null,
    date: null,
    image: null,
    visits: null,
    likes: null,
    is_published: null,
}

export default {
    components: {
        Editor,
        CropperModal
    },

    data() {
        return {
            loading: false,
            valid: true,
            form_errors: Object.assign({}, errors),
            form: Object.assign({}, defaultForm),
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
        async submit() {
            this.loading = true;

            try {
                await this.$store.dispatch(CREATE_BLOG, this.form);

                await Toast.fire({
                    'icon': 'success',
                    'title': 'An article has been added'
                });

                this.$nextTick(() => {
                    this.$router.push({ name: 'articles-index' });
                });
            } catch (error) {
                const { status, message } = error.response.data;

                this.form_errors = message;

                document.getElementById('submit_button').setAttribute('disabled', 'disabled');

                setTimeout(() => {
                    document.getElementById('submit_button').removeAttribute('disabled');
                }, 2500);


                throw error
            }

            this.loading = false;
        },

        handleInput (e) {
            let stringValue = e.target.value.toString()
            let regex = /^\d*(\.\d{1,2})?$/
            if(!stringValue.match(regex) && this.price!== '') {
                this.price = this.previousPrice
            }
            this.previousPrice = this.price;
        },

        setImageName(image) {
            this.form.image = image;
        },

        uploadImage(e) {
            e.preventDefault();

            this.$refs.upload.click();
        },
    },
}
</script>

<style scoped>

</style>
