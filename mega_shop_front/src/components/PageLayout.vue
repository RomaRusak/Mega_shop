<template>
   <page-header />
    <router-view /> 
</template>

<script>
import PageHeader from './PageHeader.vue';
    export default {
        components: {
            'page-header': PageHeader,
        }
    }
</script>