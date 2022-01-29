<template>
    <div class="parallax-contact-image row justify-content-center align-items-center">
        <div class="col-8">
            <div class="contact-form row justify-content-center">
                <div class="col-12">
                    <div class="row justify-content-center align-items-center" v-if="!$props.contact">
                        <div class="col-8">
                            <div class="fs-4 fw-bold text-uppercase text-roboto text-center mb-3">CONTACT ME</div>
                            <contact-form />
                        </div>
                    </div>
                    <div class="row align-items-center" v-else>
                        <div class="col-md-4 text-roboto">
                            <div class="fs-4 fw-bold text-uppercase mb-3">CONTACT ME</div>
                            <div>{{ $props.contact.name ? $props.contact.name : 'Your name' }}</div>
                            <div>{{ $props.contact.address ? $props.contact.address : 'Your address' }}</div>
                            <div>Phone: {{ $props.contact.contact_number ? $props.contact.contact_number : 'Your phone number' }}</div>
                            <div>{{ $props.contact.email ? $props.contact.email : 'Your email' }}</div>
                            <div id="sharing-links" class="my-3">
                                <a :href="social.url" type="button" target="_blank" v-for="social in $props.socials" :key="social.id">
                                    <font-awesome-icon :icon="['fab', 'facebook']" size="2x" class="mx-2" v-if="social.site === 'facebook'" />
                                    <font-awesome-icon :icon="['fab', 'twitter']" size="2x" class="mx-2" v-else-if="social.site === 'twitter'" />
                                    <font-awesome-icon :icon="['fab', 'instagram']" size="2x" class="mx-2" v-else-if="social.site === 'instagram'" />
                                    <font-awesome-icon :icon="['fab', 'linkedin-in']" size="2x" class="mx-2" v-else-if="social.site === 'linkedin'" />
                                </a>
                            </div>
                        </div>
                        <div class="col-12 col-md-8">
                            <contact-form />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ContactForm from "./ContactForm";

export default {
    props: {
        contact: {
            type: Object,
        },

        socials: {
            type: Object,
        }
    },

    components: {
        ContactForm
    }
}
</script>

<style scoped>

</style>
