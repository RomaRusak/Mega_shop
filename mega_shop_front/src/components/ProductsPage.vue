<template>
    <div class="products-wrapper">
        <filter-sidebar />
        {{ JSON.stringify(this.getProducts) }}
        <products-url-params-updater />
    </div>
</template>

<script>
import store from '@/store';
import { mapGetters } from 'vuex';
import FilterSidebar from './FilterSidebar.vue';
import ProductsURLParamsUpdater from './ProductsURLParamsUpdater.vue';

    export default {
        store,
        components: {
            'filter-sidebar': FilterSidebar,
            'products-url-params-updater': ProductsURLParamsUpdater
        },
        computed: {
            ...mapGetters(['getProducts']),
        },
    }
</script>

<style scoped>
    .gold {
        background-color: gold;
    }

    .products-wrapper {
        display: grid;
        grid-template-columns: 300px 1fr;
    }
</style>