<template>
    <Fragment />
</template>

<script>
import { Fragment } from 'vue';
import store from '@/store';
import { mapGetters, mapActions } from 'vuex';
import { debounce } from 'lodash';

export default {
    components: {Fragment},
    store,
    data() {
        return {
            debouncedUpdateURL: debounce(this.updateURL, 1000)
        };
    },
    computed: {
        ...mapGetters(['getAllFilters'])
    },
    watch: {
        getAllFilters(stateFilters) {
            this.debouncedUpdateURL(stateFilters);
        }
    },
    methods: {
        ...mapActions(['asyncFetchProductsData']),

        updateURL(stateFilters) {
            const selectedBrands = this.getSelectedFilters(stateFilters.brands, 'isChecked', 'slug');
            const selectedColors = this.getSelectedFilters(stateFilters.colors, 'isChecked', 'name');
            const selectedSizes  = this.getSelectedFilters(stateFilters.sizes, 'isChecked', 'name');
            const selectedMinPrice = String(stateFilters.selectedMinPrice);
            const selectedMaxPrice = String(stateFilters.selectedMaxPrice);

            const updatedFilterParams = this.getUpdatedFilterParams({
                brand: selectedBrands, 
                color: selectedColors, 
                size: selectedSizes, 
                min_price: selectedMinPrice, 
                max_price: selectedMaxPrice,
            });
            
            // const currentRoute = this.$route.path.split('?')[0];
            // this.$router.push(currentRoute + `?${updatedFilterParams}`);

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
                    case 'min_price':
                    case 'max_price': {
                        updatedFilterParams.push(`${filterKey}=${selectedFilters[filterKey]}`);
                       break;
                    }
                }
            });

            return updatedFilterParams.join('&')
        }
    },
    created() {
        this.$router.push('/products');
    }
}
</script>