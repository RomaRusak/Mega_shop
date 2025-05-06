<template>
    <div>
        <div class="pagination-items-wrapper">
            <pagination-item 
            v-for="({pageNumber, isSelected}) in paginationItemsData"
            :key="pageNumber"
            :pageNumber="pageNumber"
            :isSelected="isSelected"
            @click="clickPaginationItemHandler"
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
import store from '@/store';
import { mapGetters, mapMutations } from 'vuex';
import PaginationItem from './UI/PaginationItem.vue';
import { debounce } from 'lodash';

    export default {
        store,
        components: {
            'pagination-item': PaginationItem,
        },
        computed: {
            ...mapGetters(['getPaginationDataByKey', 'getProductsIsLoading']),

            paginationItemsData() {
                const paginationItems = [];
                const totalPages = this.getPaginationDataByKey('total_pages')
                const selectedPage = this.getPaginationDataByKey('page');
                
                for(let i = 1; i <= totalPages; i++) {
                    paginationItems.push({
                        pageNumber: i,
                        isSelected: i === selectedPage,
                    });
                }

                return paginationItems;
            }
        },
        methods: {
            ...mapMutations(['SET_PRODUCTS_PAGINATION_PAGE']),

            clickPaginationItemHandler(payload) {
                if (this.getProductsIsLoading) {
                    return;
                }
                this.debouncedSetProductsPaginationPage(payload);
            },

            debouncedSetProductsPaginationPage: debounce(function(payload) {
                this.SET_PRODUCTS_PAGINATION_PAGE(payload);
            }, 300) 
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