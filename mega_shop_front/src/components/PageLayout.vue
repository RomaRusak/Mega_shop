<template>
    <div class="container">
        <page-header />
        <router-view /> 
    </div>
</template>

<script>
import PageHeader from './PageHeader.vue';
    export default {
        components: {
            'page-header': PageHeader,
        }
    }
</script>

<style scoped>
    .container {
        max-width: 1200px;
        overflow: hidden;
        margin: 0 auto;
    }
</style>