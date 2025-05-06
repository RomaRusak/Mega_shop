<template>
    <div class="products-wrapper">
        <filter-sidebar />
        <div>
            <products-preloader  v-if="getProductsIsLoading"/>
            <div v-else>
                <div class="product-card-wrapper">
                    <product-card 
                    v-for="(productId) in getProductIds"
                    :key="productId"
                    :productId="productId"
                    />
                </div>
                <pagination-controls />
            </div>
            <products-filter-params-handler />
        </div>
    </div>
</template>

<script>
import store from '@/store';
import { mapGetters, mapActions, mapMutations } from 'vuex';
import FilterSidebar from './FilterSidebar.vue';
import ProductCard from './ProductCard.vue';
import ProductsFilterParamsHanlder from './ProductsFilterParamsHanlder.vue';
import PaginationControls from './PaginationControls.vue';
import ProductsPreloader from './UI/ProductsPreloader.vue';

    export default {
        store,
        components: {
            'filter-sidebar': FilterSidebar,
            'products-filter-params-handler': ProductsFilterParamsHanlder,
            'product-card': ProductCard,
            'pagination-controls': PaginationControls,
            'products-preloader': ProductsPreloader,
        },
        computed: {
            ...mapGetters(['getProductIds', 'getProductsIsLoading']),
        },
        methods: {
            ...mapMutations(['RESET_PRODUCTS_STORE', 'RESET_FILTERS_STORE']),
            ...mapActions(['asyncFetchProductsData', 'asyncFetchUniqFilterValues'])
        },

        async mounted() {
            try {
                await Promise.all([
                    this.asyncFetchProductsData(),
                    this.asyncFetchUniqFilterValues()
                ]);
            } catch (error) {
                console.error(error);
            }
        },

        beforeUnmount() {
            this.RESET_PRODUCTS_STORE();
            this.RESET_FILTERS_STORE();
        }
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