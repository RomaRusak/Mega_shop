<template>
    <div class="products-wrapper">
        <filter-sidebar />
        <div class="product-card-wrapper">
            <product-card 
            v-for="(productId) in getProductIds"
            :key="productId"
            :productId="productId"
            />
        </div>
        <products-url-params-updater />
    </div>
</template>

<script>
import store from '@/store';
import { mapGetters } from 'vuex';
import FilterSidebar from './FilterSidebar.vue';
import ProductsURLParamsUpdater from './ProductsURLParamsUpdater.vue';
import ProductCard from './ProductCard.vue';

    export default {
        store,
        components: {
            'filter-sidebar': FilterSidebar,
            'products-url-params-updater': ProductsURLParamsUpdater,
            'product-card': ProductCard,
        },
        computed: {
            ...mapGetters(['getProductIds']),
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

    .product-card-wrapper {
        display: grid;
        grid-template-columns: repeat(auto-fill, 400px);
        justify-content: space-between;
        grid-gap: 15px;
    }
</style>