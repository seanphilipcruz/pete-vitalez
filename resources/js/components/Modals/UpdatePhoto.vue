<template>
    <div id="update-photo" class="modal fade" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content fw-bold" v-if="photo">
                <div class="modal-header">
                    <div class="modal-title h5 fw-bold">{{ photo.title }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form ref="update_photo_form">
                    <div class="modal-body" v-if="editMode">
                        <div class="text-center" v-if="$props.loadingState">
                            <div class="spinner-border text-dark" role="status">
                                <div class="visually-hidden">Loading ...</div>
                            </div>
                        </div>
                        <div v-else>
                            <div class="row justify-content-center mb-3" v-if="!image.src">
                                <div class="col-6 text-center">
                                    <img :src="(type === 'artwork_photo' ? artworksDirectory : blogsDirectory) + form.image" class="img-fluid" :alt="form.image" />
                                </div>
                            </div>
                            <div class="row justify-content-center mb-3">
                                <div class="col-8">
                                    <cropper ref="cropper"
                                             :src="image.src"
                                             :stencil-props="stencil_props"
                                             :resize-image="{ adjustStencil: false }"
                                             :stensil-size="stencil_size"
                                             image-restriction="stencil"
                                             :auto-zoom="true">
                                    </cropper>
                                </div>
                            </div>
                            <div class="row justify-content-center mb-3">
                                <div class="col-6 text-center">
                                    <button v-if="image.src" type="button" class="btn btn-outline-dark" @click="crop()">Crop & Save</button>
                                    <button v-if="image.src" type="button" class="btn btn-outline-dark" @click="reset()">Reset</button>
                                    <button v-if="!image.src" type="button" class="btn btn-outline-dark" @click="$refs.file.click()">
                                        <input type="file" ref="file" accept="image/*" hidden @change="loadImage($event)">
                                        Select File
                                    </button>
                                </div>
                            </div>
                            <div class="row justify-content-center mb-3">
                                <div class="col-8">
                                    <div class="form-floating">
                                        <input id="update_title" type="text" class="form-control" :class="errors.title ? 'is-invalid': ''" v-model="form.title" placeholder="Photo Title">
                                        <label for="update_title">Photo Title</label>
                                        <div class="invalid-feedback">
                                            <ul class="mb-1" v-for="error in errors.title">
                                                {{ error }}
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center mb-3">
                                <div class="col-8">
                                    <label for="update_photo_description" class="mb-2">Photo Description</label>
                                    <editor id="update_photo_description" :api-key="tiny.key" :init="tiny.config" v-model="form.description" :class="errors.description ? 'is-invalid' : ''"></editor>
                                    <div v-if="errors.description" class="invalid-feedback">
                                        <ul class="m-0" v-for="value in errors.description">
                                            {{ value }}
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3 justify-content-center">
                                <div class="col-4 d-grid">
                                    <div class="btn-group" v-if="!saving">
                                        <button type="button" class="btn btn-outline-dark" @click="updatePhoto">
                                            <font-awesome-icon :icon="['fas', 'check-circle']" />&nbsp;Update
                                        </button>
                                        <button type="button" class="btn btn-outline-dark" @click="deletePhoto">
                                            <font-awesome-icon :icon="['fas', 'trash']" />&nbsp;Delete
                                        </button>
                                    </div>
                                    <button type="button" class="btn btn-outline-dark disabled" v-else>
                                        <span class="spinner-border text-dark" role="status">
                                            <i class="visually-hidden">Loading ...</i>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body" v-else>
                        <div class="text-center" v-if="loadingState">
                            <div class="spinner-border text-dark" role="status">
                                <div class="visually-hidden">Loading ...</div>
                            </div>
                        </div>
                        <div v-else>
                            <div class="row justify-content-center mb-3">
                                <div class="col-6 col-sm-8 col-md-8 text-center">
                                    <img :src="artworksDirectory + form.image" class="img-fluid" :alt="form.image" />
                                </div>
                            </div>
                            <div class="row justify-content-center mb-3">
                                <div class="col-6 col-sm-8 col-md-8">
                                    <div class="text-center h6 fw-bold">{{ form.title }}</div>
                                </div>
                            </div>
                            <div class="row justify-content-center mb-3">
                                <div class="col-6 col-sm-8 col-md-8">
                                    <div class="text-center h6 fw-bold" v-html="form.description"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button ref="dismiss-button" type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">
                            <font-awesome-icon :icon="['fas', 'times-circle']" /> Close
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import { UPDATE_PHOTO, DELETE_PHOTO } from "../../store/types/photos";
import { Cropper } from "vue-advanced-cropper";
import 'vue-advanced-cropper/dist/style.css';
import Editor from "@tinymce/tinymce-vue";

function getMimeType(file, fallback = null) {
    const byteArray = (new Uint8Array(file)).subarray(0, 4);

    let header = '';

    for(let i = 0; i < byteArray.length; i++) {
        header += byteArray[i].toString(16);
    }

    switch (header) {
        case "89504e47":
            return "image/png";
        case "47494638":
            return "image/gif";
        case "ffd8ffe0":
        case "ffd8ffe1":
        case "ffd8ffe2":
        case "ffd8ffe3":
        case "ffd8ffe8":
            return "image/jpeg";
        default:
            return fallback;
    }
}

const defaultForm = {
    title: null,
    description: null,
    image: null,
}

const formErrors = {
    title: null,
    description: null,
    image: null,
}

export default {
    props: {
        photo: {
            required: true,
        },

        type: {
            required: true,
        },
        editMode: {
            type: Boolean,
            required: true,
        },
        loadingState: {
            type: Boolean,
            required: true,
        }
    },

    components: {
        Editor,
        Cropper,
    },

    data() {
        return {
            saving: false,
            loading: false,
            image: {
                src: null,
                type: null
            },
            stencil_props: {
                handlers: {
                    eastNorth: true,
                    north: true,
                    westNorth: true,
                    west: true,
                    westSouth: true,
                    south: true,
                    eastSouth: true,
                    east: true
                },
                movable: false,
                sizeable: false,
            },
            stencil_size: {
                width: 300,
                height: 300
            },
            form: Object.assign({}, this.$props.photo),
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
        crop() {
            const { canvas } = this.$refs.cropper.getResult();

            const form = new FormData;
            const config = {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }
            canvas.toBlob(async blob => {
                // upload the image to the server.
                form.append('image', blob);
                form.append('type', this.$props.type);

                await this.$axios.post(route('upload.photo'), form, config)
                    .then((res) => {
                        this.form.image = res.data.image_name;
                        this.reset();

                        Toast.fire({
                            'icon': res.data.status,
                            'title': res.data.message
                        });
                    }).catch((error) => {
                        this.$refs["dismiss-button"].click();
                        this.reset();
                        Toast.fire({
                            'icon': error.data.status,
                            'title': error.data.message
                        });
                    });
            }, this.image.type);
        },

        reset() {
            this.image = {
                src: null,
                type: null
            }
        },

        loadImage(e) {
            const { files } = e.target;

            if (files && files[0]) {
                if (this.image.src) {
                    URL.revokeObjectURL(this.image.src);
                }

                const blob = URL.createObjectURL(files[0]);

                const reader = new FileReader();

                reader.onload = (e) => {
                    this.image = {
                        src: blob,
                        type: getMimeType(e.target.result, files[0].type),
                    };
                };

                reader.readAsArrayBuffer(files[0]);
            }
        },

        destroyed(e) {
            if (this.image.src) {
                URL.revokeObjectURL(this.image.src);
            }
        },

        async updatePhoto() {
            this.saving = true;

            try {
                const response = await this.$store.dispatch(UPDATE_PHOTO, this.form);
                this.$emit('updated');
                this.$refs["dismiss-button"].click();

                Toast.fire({
                    'icon': response.data.status,
                    'title': response.data.message
                });
            } catch (error) {
                throw error;
            }

            this.saving = false;
        },

        async deletePhoto() {
            this.saving = true;

            Popup.fire({
                'icon': 'question',
                'title': 'Are you sure to delete this Photo?',
                'confirmButtonText': 'Yes',
                'cancelButtonText': 'No',
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        const response = await this.$store.dispatch(DELETE_PHOTO, this.photo);
                        this.$emit('updated');
                        this.$refs["dismiss-button"].click();

                        Toast.fire({
                            'icon': response.data.status,
                            'title': response.data.message
                        });
                    } catch (error) {
                        throw error;
                    }
                }
            });

            this.saving = false;
        }
    },

    computed: {
        artworksDirectory()  {
            return '/images/artworks/';
        },

        blogsDirectory() {
            return '/images/blogs/';
        }
    },

    watch: {
        photo: {
            deep: true,
            immediate: true,
            handler: function(value, oldValue) {
                this.form = value;
            }
        }
    }
}
</script>

<style scoped>

</style>
