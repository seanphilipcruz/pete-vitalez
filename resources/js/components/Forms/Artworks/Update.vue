<template>
    <form ref="form" v-model="valid" class="text-roboto fw-bold" novalidate>
        <div class="card-header">
            <div class="card-title">
                <div class="h3 my-2">Update {{ artwork.title }}</div>
            </div>
        </div>
        <div class="card body">
            <div class="my-3">
                <div class="row justify-content-center mb-3">
                    <div class="col-3 text-center">
                        <img :src="artworksDirectory + form.image" class="img-fluid" :alt="form.image" />
                    </div>
                </div>
                <div class="row justify-content-center mb-3">
                    <div class="col col-md-8">
                        <div class="float-end">
                            <button type="button" class="btn btn-outline-dark" data-bs-target="#addPhotoModal" data-bs-toggle="modal"><font-awesome-icon :icon="['fas', 'plus']"></font-awesome-icon>  Add Image</button>
                        </div>
                    </div>
                </div>
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
                    <div class="col col-md-4">
                        <div class="row">
                            <div class="col col-md-6">
                                <div class="form-floating">
                                    <input type="number" id="price" class="form-control" :class="form_errors.price ? 'is-invalid' : ''" v-model="form.price" @input="handleInput" placeholder="Price">
                                    <label for="price">Price</label>
                                    <div v-if="form_errors.price" class="invalid-feedback">
                                        <ul class="m-0" v-for="value in form_errors.price">
                                            {{ value }}
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col col-md-6">
                                <div class="form-floating">
                                    <input type="number" id="frame_price" class="form-control" :class="form_errors.frame_price ? 'is-invalid' : ''" v-model="form.frame_price" @input="handleInput" placeholder="Frame Price">
                                    <label for="frame_price">Frame Price</label>
                                    <div v-if="form_errors.frame_price" class="invalid-feedback">
                                        <ul class="m-0" v-for="value in form_errors.frame_price">
                                            {{ value }}
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col col-md-4">
                        <div class="form-floating">
                            <select id="is_sold" class="form-select" v-model="form.is_sold" data-popper-placement="Status">
                                <option value="0">Available</option>
                                <option value="1">Sold</option>
                            </select>
                            <label for="is_sold">Product Status</label>
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
                        <button type="button" class="btn btn-outline-dark" @click="submit" v-if="!loading"><font-awesome-icon :icon="['fas', 'check-circle']"></font-awesome-icon> Update</button>
                        <button type="button" class="btn btn-outline-dark" disabled v-else><span class="spinner-border spinner-border-sm"></span> Saving</button>
                    </div>
                </div>
            </div>
        </div>
        <cropper-modal @getImageName="setImageName" type="artwork"></cropper-modal>
        <add-photo-modal @getPhotoData="setPhotoData" type="artwork_photo" @uploaded="submit"></add-photo-modal>
    </form>
</template>

<script>
import { UPDATE_ARTWORK } from "../../../store/types/artworks";
import Editor from "@tinymce/tinymce-vue";
import CropperModal from "../../Modals/PhotoCropper";
import AddPhotoModal from "../../Modals/AddPhoto";

const defaultForm = {
    title: null,
    sub_title: null,
    description: null,
    price: null,
    frame_price: null,
    image: null,
    is_sold: 0,
    is_framed: 0,
    photo: false,
}

const errors = {
    title: null,
    sub_title: null,
    description: null,
    price: null,
    frame_price: null,
    image: null,
    is_framed: 0,
}

export default {
    props: {
        artwork: {
            type: Object,
            required: true
        },
        refresh: {
            type: Function,
            required: true,
        }
    },

    components: {
        Editor,
        CropperModal,
        AddPhotoModal
    },

    data() {
        return {
            loading: false,
            valid: true,
            form: Object.assign({}, defaultForm),
            form_errors: Object.assign({}, errors),
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
                await this.$store.dispatch(UPDATE_ARTWORK, this.form);

                this.$props.refresh();

                await Toast.fire({
                    'icon': 'success',
                    'title': 'Artwork has been updated'
                });
            } catch (error) {
                const { status, message } = error.response.data;

                this.form_errors = message;

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

        setPhotoData(image_data) {
            this.form.photo.push(image_data);
        },

        uploadImage(e) {
            e.preventDefault();

            this.$refs.upload.click();
        }
    },

    computed: {
        artworksDirectory()  {
            return '/images/artworks/';
        }
    },

    watch: {
        artwork: {
            deep: true,
            immediate: true,
            handler: function (value, oldValue) {
                this.form = value;
            }
        }
    }
}
</script>

<style scoped>

</style>
