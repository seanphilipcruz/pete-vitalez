<template>
      <div class="row mb-3">
          <div class="col-12" v-if="!loading">
              <div class="row mb-3">
                  <div class="col-12">
                      <button class="btn btn-outline-dark float-end" data-bs-target="#add-event" data-bs-toggle="modal">
                          <font-awesome-icon :icon="['fas', 'plus']" /> Add
                      </button>
                  </div>
              </div>
              <div class="row mb-3">
                  <div class="col-12">
                      <div class="card">
                          <div class="card-header fs-4 fw-bold">Events Participated</div>
                          <div class="card-body">
                              <div class="card" v-if="!events">
                                  <div class="card-body text-center fw-bold">
                                      Added exhibitions / guestings will reflect here
                                  </div>
                              </div>
                              <div class="card mb-3" v-else v-for="event in events" :key="event.id">
                                  <div class="card-body">
                                      <div class="row fw-bold">
                                          <div class="col-md-6">
                                              {{ event.title }}
                                              <div class="fw-light">{{ event.description }}</div>
                                          </div>
                                          <div class="col-md-3" v-if="!event.start && !event.end"></div>
                                          <div class="col-md-3 text-end" v-else-if="!event.end">{{ event.start }}</div>
                                          <div class="col-md-3 text-end" v-else>{{ event.start }} - {{ event.end }}</div>
                                          <div class="col-md-3">
                                              <div class="btn-group float-end">
                                                  <button type="button" class="btn btn-outline-dark" data-bs-target="#update-event" data-bs-toggle="modal" @click="getEvent(event)">
                                                      <font-awesome-icon :icon="['fas', 'wrench']" />
                                                  </button>
                                                  <button type="button" class="btn btn-outline-dark" @click="deleteEvent(event)">
                                                      <font-awesome-icon :icon="['fas', 'trash']" />
                                                  </button>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <add-event :refresh="getEvents"></add-event>
              <update-event :refresh="getEvents" :event="event"></update-event>
          </div>
          <div class="col-12 text-center" v-else>
              <div class="spinner-border text-dark" role="status">
                  <span class="visually-hidden">Loading ...</span>
              </div>
          </div>
      </div>
</template>

<script>
import { GET_EVENTS, GET_EVENT, DELETE_EVENT } from "../../../store/types/content";
import AddEvent from "../../../components/Modals/AddEvent";
import UpdateEvent from "../../../components/Modals/UpdateEvent";

export default {
    components: {
        UpdateEvent,
        AddEvent
    },

    data() {
        return {
            loading: false,
        }
    },

    methods: {
        async getEvents() {
            this.loading = true;

            try {
                const response = await this.$store.dispatch(GET_EVENTS);
            } catch (error) {
                throw error;
            }

            this.loading = false;
        },

        async getEvent(event) {
            try {
                const response = await this.$store.dispatch(GET_EVENT, event.id);
            } catch (error) {
                throw error;
            }
        },

        async deleteEvent(event) {
            await Popup.fire({
                'icon': 'question',
                'title': 'Are you sure?',
                'text': 'Delete event '+event.title+'?',
                'confirmButtonText': 'Yes',
                'cancelButtonText': 'No',
            }).then(async (result) => {
                if (result.isConfirmed) {
                    await this.$store.dispatch(DELETE_EVENT, event);

                    await this.getEvents();
                }
            }).catch((error) => {
                throw error;
            });
        }
    },

    computed: {
        events() {
            return this.$store.state.content.events;
        },

        event() {
            return this.$store.state.content.event;
        }
    },

    async created() {
        await this.getEvents();
    }
}
</script>

<style scoped>

</style>
