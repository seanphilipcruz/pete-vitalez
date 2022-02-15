<template>
    <div id="events-modal" class="modal fade text-open-sans" data-bs-backdrop="static" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="fs-5 fw-bold">Participated Events</span>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="card" v-if="!events">
                        <div class="card-body text-center fw-bold">
                            More exhibitions / guestings will reflect here
                        </div>
                    </div>
                    <div class="card mb-3" v-else v-for="event in events" :key="event.id">
                        <div class="card-body">
                            <div class="row fw-bold">
                                <div class="col-md-8">
                                    {{ event.title }}
                                    <div class="fw-light">{{ event.description }}</div>
                                </div>
                                <div class="col-md-4" v-if="!event.start && !event.end"></div>
                                <div class="col-md-4 text-end" v-else-if="!event.end">{{ event.start }}</div>
                                <div class="col-md-4 text-end" v-else>{{ event.start }} - {{ event.end }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Dismiss</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        events: {
            required: true,
        }
    }
}
</script>

<style scoped>

</style>
