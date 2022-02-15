<template>
    <div class="row mb-3">
        <div class="col-12" v-if="!photo || !photo.length">
            <div class="h3 mb-3">Gallery</div>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-center align-items-center" style="height: 30vh">
                        <div class="h3">
                            No additional photos found.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12" v-else>
            <div class="h3 mb-3">Gallery</div>
            <div class="card">
                <div class="card-body">
                    <div id="hover-items" class="row">
                        <div class="col-6 col-sm-6 col-md-3" v-for="pictures in $props.photo" :key="pictures.id" data-bs-target="#update-photo" data-bs-toggle="modal">
                            <div class="card shadow" @click="fetchPhoto(pictures.id)">
                                <img :src="folder + '/' + (pictures.image ? pictures.image : fallbackImage)" :alt="pictures.title">
                                <div class="card-body text-center">
                                    <div class="card-title fw-bold">{{ pictures.title }}</div>
                                    <div class="card-text" v-html="pictures.description"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <update-photo type="artwork_photo" :photo="extra_photos" @updated="refresh()" :edit-mode="editMode" :loading-state="loading"></update-photo>
    </div>
</template>

<script>
import { GET_PHOTO } from "../../store/types/photos";
import { GET_MISC_PHOTO } from "../../store/types/website";
import UpdatePhoto from "../../components/Modals/UpdatePhoto";

export default {
    props: {
        photo: {
            required: true,
        },
        folder: {
            required: true,
        },
        fallbackImage: {
            required: true,
        },
        editMode: {
            type: Boolean,
            required: true,
        },
        refresh: {
            type: Function,
            required: true,
        }
    },

    components: {
        UpdatePhoto
    },

    data() {
        return {
            loading: false,
        }
    },

    methods: {
        async fetchPhoto(id) {
            this.loading = true;

            if (this.$props.editMode) {
                try {
                    const response = await this.$store.dispatch(GET_PHOTO, id);
                } catch (error) {
                    await Popup.fire({
                        'icon': 'error',
                        'title': '<div class="h4 m-0">'+error.exception+'</div>',
                        'text': error.message ? error.message : 'Error Occurred!'
                    });

                    throw error;
                }
            } else {
                try {
                    const response = await this.$store.dispatch(GET_MISC_PHOTO, id);
                } catch (error) {
                    await Popup.fire({
                        'icon': 'error',
                        'title': '<div class="h4 m-0">'+error.exception+'</div>',
                        'text': error.message ? error.message : 'Error Occurred!'
                    });

                    throw error;
                }
            }

            this.loading = false;
        },
    },

    computed: {
        extra_photos() {
            if (this.$props.editMode) {
                return this.$store.state.photos.photo;
            } else {
                return this.$store.state.website.photo;
            }
        }
    }
}
</script>

<style scoped>

</style>
