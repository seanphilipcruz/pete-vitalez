<template>
    <div class="row">
        <div class="col-12" v-if="photo">
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
    </div>
</template>

<script>
export default {
    props: {
        photo: {
            required: true,
        }
    },

}
</script>

<style scoped>

</style>
