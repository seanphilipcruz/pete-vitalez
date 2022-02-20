<template>
    <div id="addPhotoModal" class="modal fade" role="dialog" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title fw-bold fs-5">Add Extra Pictures</div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form ref="add_photo_form">
                    <div class="modal-body">
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
                            <div class="col-8 text-center">
                                <button v-if="image.src" type="button" class="btn btn-outline-dark" @click="crop()">Crop</button>
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
                                    <input id="title" type="text" class="form-control" :class="errors.title ? 'is-invalid': ''" v-model="form.title" placeholder="Photo Title">
                                    <label for="title">Photo Title</label>
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
                                <label for="photo_description" class="mb-2">Photo Description</label>
                                <editor id="photo_description" :api-key="tiny.key" :init="tiny.config" v-model="form.description" :class="errors.description ? 'is-invalid' : ''"></editor>
                                <div v-if="errors.description" class="invalid-feedback">
                                    <ul class="m-0" v-for="value in errors.description">
                                        {{ value }}
                                    </ul>
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
import  { Cropper } from "vue-advanced-cropper";
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
        type: {
            required: true,
        },
    },

    components: {
        Editor,
        Cropper,
    },

    data() {
        return {
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
                        const image_data = {
                            title: this.form.title,
                            description: this.form.description,
                            image: res.data.image_name
                        };

                        this.$emit('getPhotoData', image_data);
                        this.$refs["dismiss-button"].click();
                        this.form = Object.assign({}, defaultForm);

                        this.reset();

                        this.$emit('uploaded');
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
        }
    }
}
</script>

<style scoped>

</style>
