import Vue from "vue";

const contentService = {
    async getContact() {
        const response = await axios.get(route('contact.info'));

        return response;
    },

    async storeContact(contact) {
        const response = await axios.post(route('contact.info.store'), contact);

        return response;
    },

    async updateContact(contact) {
        const response = await axios.patch(route('contact.info.update', contact.id), contact);

        return response;
    },

    async getEvents() {
        const response = await axios.get(route('events.info'));

        return response;
    },

    async getEvent(id) {
        const response = await axios.get(route('event.info', id));

        return response;
    },

    async storeEvent(event) {
        const response = await axios.post(route('events.info.store'), event);

        return response;
    },

    async updateEvent(event) {
        const response = await axios.patch(route('events.info.update', event.id), event);

        return response;
    },

    async deleteEvent(event) {
        const response = await axios.delete(route('events.info.delete', event.id));

        return response;
    },

    async getSocials() {
        const response = await axios.get(route('socials.info'));

        return response;
    },

    async getSocial(id) {
        const response = await axios.get(route('social.info', id));

        return response;
    },

    async storeSocial(site) {
        const response = await axios.post(route('socials.info.store'), site);

        return response;
    },

    async updateSocial(site) {
        const response = await axios.patch(route('socials.info.update', site.id), site);

        return response;
    },

    async deleteSocial(site) {
        const response = await axios.delete(route('socials.info.delete', site.id));

        return response;
    }
}

export default contentService;
