<template>
    <div class="products-wrapper">
        <filter-sidebar />
        <div>
            <products-preloader  v-if="getProductsIsLoading"/>
            <div v-else>
                <div class="products-card-wrapper">
                    <product-card 
                    v-for="(productId) in getProductIds"
                    :key="productId"
                    :productId="productId"
                    />
                </div>
                <pagination-controls />
            </div>
        </div>
    </div>
</template>

<script>
import { onMounted, onBeforeUnmount, computed } from 'vue';
import { useStore } from 'vuex';
import FilterSidebar from './FilterSidebar.vue';
import ProductCard from './ProductCard.vue';
import PaginationControls from './PaginationControls.vue';
import ProductsPreloader from './UI/ProductsPreloader.vue';
import { useProductsFilterParamsHanlde } from '@/compossables/useProductsFilterParamsHanlde';

export default {
  components: {
    'filter-sidebar': FilterSidebar,
    'product-card': ProductCard,
    'pagination-controls': PaginationControls,
    'products-preloader': ProductsPreloader,
  },

  setup() {
    const store = useStore();
    
    //compossible
    useProductsFilterParamsHanlde();

    // computeds
    const getProductIds = computed(() => store.getters.getProductIds);
    const getProductsIsLoading = computed(() => store.getters.getProductsIsLoading);

    //methods
    function resetProductsStore() {
        store.commit('RESET_PRODUCTS_STORE')
    }

    function resetFiltersStore() {
        store.commit('RESET_FILTERS_STORE');
    }

    function asyncFetchProductsData() {
        store.dispatch('asyncFetchProductsData')
    }

    function asyncFetchUniqFilterValues() {
        store.dispatch('asyncFetchUniqFilterValues')
    }

     //lifeHooks
    onMounted(async () => {
        try {
            await Promise.all([asyncFetchProductsData(), asyncFetchUniqFilterValues()]);
        } catch (error) {
            console.error(error);
        }
    });

    onBeforeUnmount(() => {
        resetProductsStore();
        resetFiltersStore();
    });

    return {
        getProductIds,
        getProductsIsLoading,
    };
  },
};
</script>

<style scoped>

    .products-wrapper {
        display: grid;
        grid-template-columns: 300px 1fr;
        grid-column-gap: 50px;
    }

    .products-card-wrapper {
        display: grid;
        grid-template-columns: repeat(auto-fill, 260px);
        justify-content: space-between;
        grid-row-gap: 40px;
    }
</style>