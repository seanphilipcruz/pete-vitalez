<template>
    <div id="view-message" class="modal fade" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">Message from {{ message.name }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-12">
                            <span class="fw-bold">Email: </span> {{ message.email }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="fw-bold mb-2">Message: </div>
                            <p class="lh-sm">{{ message.content }}</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">
                        <font-awesome-icon :icon="['fas', 'times-circle']" /> Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    computed: {
        message() {
            return this.$store.state.message.message;
        }
    }
}
</script>

<style scoped>

</style>
