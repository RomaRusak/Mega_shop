<template>
    <Fragment />
</template>

<script>
import { Fragment } from 'vue';
import store from '@/store';
import { mapGetters, mapActions, mapMutations } from 'vuex';
import { debounce } from 'lodash';

export default {
    components: {Fragment},
    store,
    data() {
        return {
            debouncedChangeFilterParamsHandler: debounce(this.changeFilterParamsHandler, 1000)
        };
    },
    computed: {
        ...mapGetters(['getAllFilters', 'getPaginationDataByKey',]),

        getSelectedPaginationPage() {
            return this.getPaginationDataByKey('page');    
        }
    },
    watch: {
        getAllFilters(_, prevState) {
            //Не должно тригериться в момент инициализации стора
            if (!Object.values(prevState).length) return;

            this.SET_PRODUCTS_PAGINATION_PAGE({page: 1});
            this.debouncedChangeFilterParamsHandler();
        },

        getSelectedPaginationPage(_, prevState) {
            //Не должно тригериться в момент инициализации стора
            if (prevState === undefined) return;

            this.debouncedChangeFilterParamsHandler();
        }
    },
    methods: {
        ...mapMutations(['SET_PRODUCTS_PAGINATION_PAGE']),
        ...mapActions(['asyncFetchProductsData']),

        changeFilterParamsHandler() {
            const stateFilters = this.getAllFilters;

            const selectedBrands = this.getSelectedFilters(stateFilters.brands, 'isChecked', 'slug');
            const selectedColors = this.getSelectedFilters(stateFilters.colors, 'isChecked', 'name');
            const selectedSizes  = this.getSelectedFilters(stateFilters.sizes, 'isChecked', 'name');
            const selectedMinPrice = String(stateFilters.selectedMinPrice);
            const selectedMaxPrice = String(stateFilters.selectedMaxPrice);
            const selectedPaginationPage = this.getSelectedPaginationPage ?? 1;

            const updatedFilterParams = this.getUpdatedFilterParams({
                brand:     selectedBrands, 
                color:     selectedColors, 
                size:      selectedSizes, 
                min_price: selectedMinPrice, 
                max_price: selectedMaxPrice,
                page:      selectedPaginationPage,
            });
            
            const currentRoute = this.$route.path.split('?')[0];
            this.$router.push(currentRoute + `?${updatedFilterParams}`);

            this.asyncFetchProductsData({
                filterParams: updatedFilterParams,
                categorySlug: this.$route.params.categorySlug
            });
        },

        getSelectedFilters(items, activeProp, nameProp) {
            return items.filter((item) => item[activeProp]).map((item) => item[nameProp]);
        },

        getUpdatedFilterParams(selectedFilters) {
            const filterKeys = Object.keys(selectedFilters);
            const updatedFilterParams = [];
            
            filterKeys.forEach(filterKey=> {
                switch(filterKey) {
                    case 'brand':
                    case 'color':
                    case 'size':  {
                        const preparedParams = selectedFilters[filterKey].map(item => `${filterKey}[]=${item}`).join('&');
                        if (preparedParams.length) updatedFilterParams.push(preparedParams);
                        break;
                    }
                    case 'page':
                    case 'min_price':
                    case 'max_price': {
                        updatedFilterParams.push(`${filterKey}=${selectedFilters[filterKey]}`);
                       break;
                    }
                }
            });

            return updatedFilterParams.join('&')
        },

    },
}
</script>