<template>
    <div>
        <div class="pagination-items-wrapper">
            <pagination-item 
            v-for="({pageNumber, isSelected}) in paginationItemsData"
            :key="pageNumber"
            :pageNumber="pageNumber"
            :isSelected="isSelected"
            @clickPaginateItem="clickPaginationItemHandler"
            />
        </div>
        <div class="pagination-info-wrapper">
            <span>max products per page: {{ getPaginationDataByKey('products_per_page') }}</span>
            <span>showed products: {{ getPaginationDataByKey('total_showed_products') }}</span>
            <span>total products: {{ getPaginationDataByKey('total_products') }}</span>
        </div>
    </div>
</template>

<script>
import { useStore } from 'vuex';
import PaginationItem from './UI/PaginationItem.vue';
import { computed } from 'vue';
import { debounce } from 'lodash';

    export default {
        components: {
            'pagination-item': PaginationItem,
        },
        setup() {
            const store = useStore();

            // computeds
            const paginationItemsData = computed(() => {
                const paginationItems = [];
                const totalPages = getPaginationDataByKey('total_pages')
                const selectedPage = getPaginationDataByKey('page');
                
                for(let i = 1; i <= totalPages; i++) {
                    paginationItems.push({
                        pageNumber: i,
                        isSelected: i === selectedPage,
                    });
                }

                return paginationItems;
            });

            const getProductsIsLoading = computed(() => store.getters.getProductsIsLoading);

            //methods
            function getPaginationDataByKey(key) {
                return store.getters.getPaginationDataByKey(key);
            }

            const debouncedSetProductsPaginationPage = debounce(function(payload) {
                store.commit('SET_PRODUCTS_PAGINATION_PAGE', payload);
            }, 300);

            function clickPaginationItemHandler(payload) {
                if (getProductsIsLoading.value) {
                    return;
                }
                debouncedSetProductsPaginationPage(payload);
            }


            return {
                paginationItemsData,
                getPaginationDataByKey,
                clickPaginationItemHandler,
            }
        }
    }
</script>

<style scoped>
    .pagination-items-wrapper {
        display: flex;
        justify-content: center;
        gap: 10px;
        padding: 5px 0 5px;
        align-items: center;
    }

    .pagination-info-wrapper {
        display: flex;
        justify-content: flex-end;
        gap: 20px;
        align-items: center;
    }
</style>