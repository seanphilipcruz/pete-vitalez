<template>
    <transition name="alert-fade">
        <div v-show="alert.shown" class="alert alert-dismissible" :class="alert.type === 'error' ? 'alert-danger' : 'alert-warning'" role="alert">
            {{ alert.message }}
            <button type="button" class="btn-close" aria-label="Close" @click="dismiss"></button>
        </div>
    </transition>
</template>

<script>
export default {
    props: {
        alert: Object
    },

    methods: {
        dismiss() {
            this.$emit('dismiss');
        }
    }
}
</script>

<style scoped>

</style>
