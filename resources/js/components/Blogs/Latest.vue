<template>
    <div id="hover-items" class="col-12 col-md-8 width-100 mb-3">
        <div class="card" @click="fetch($props.latestArticle.id, $props.latestArticle.title)">
            <img :src="folder + '/' + $props.latestArticle.image"  :alt="$props.latestArticle.title" class="card-img-top">
            <div class="card-body">
                <div class="card-title">
                    <strong class="text-open-sans">{{ $props.latestArticle.title }}</strong>
                </div>
                <div class="card-subtitle">
                    <div class="h5">
                        <div class="fw-light">{{ $props.latestArticle.sub_title }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        latestArticle: {
            required: true,
        },
        fetch: {
            type: Function,
            required: true,
        }
    },

    components: {

    },

    data() {
        return {
            folder: '/images/blogs',
            logo: '/assets/logo.png',
            loading: false,
            id: this.$route.params.id,
            title: this.$route.params.title,
        }
    },
}
</script>

<style scoped>

</style>
