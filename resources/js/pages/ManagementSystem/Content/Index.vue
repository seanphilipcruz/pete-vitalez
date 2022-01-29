<template>
    <div class="container my-4 text-open-sans">
        <contact-info></contact-info>
        <events></events>
        <social></social>
    </div>
</template>

<script>
import Events from "./Events";
import ContactInfo from "./ContactInfo";
import Social from "./Social";

export default {
    metaInfo() {
        return {
            title: 'Managing Website Information'
        }
    },

    components: {
        Social,
        ContactInfo,
        Events
    }
}
</script>

<style scoped>

</style>
