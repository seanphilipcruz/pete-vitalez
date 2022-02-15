<template>
    <div id="cropperModal" class="modal fade" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">Crop Image</div>
                    <button type="button" class="btn-close" data-dismiss="modal"></button>
                </div>
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
                </div>
                <div class="modal-footer">
                    <button ref="dismiss-button" type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Cropper } from "vue-advanced-cropper";
import 'vue-advanced-cropper/dist/style.css';

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

export default {
    props: {
        type: {
            type: String,
            required: true,
        }
    },

    components: {
        Cropper
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
                    this.$emit('getImageName', res.data.image_name);
                    this.$refs["dismiss-button"].click();
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
        }
    }
}
</script>

<style scoped>

</style>
