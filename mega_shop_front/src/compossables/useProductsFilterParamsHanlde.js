import { computed, watch } from 'vue';
import { debounce } from 'lodash';
import { useStore } from 'vuex';
import { useRoute, useRouter } from 'vue-router';

export function useProductsFilterParamsHanlde() {
    const store = useStore();
    const router = useRouter();
    const route = useRoute();

    // computeds
    const getAllFilters = computed(() => store.getters.getAllFilters);
    const getPaginationDataByKey = computed(() => store.getters.getPaginationDataByKey);

    const getSelectedPaginationPage = computed(() => getPaginationDataByKey.value('page'));

    const debouncedChangeFilterParamsHandler = debounce(changeFilterParamsHandler, 1000);

    // watchers
    watch(getAllFilters, (_, prevState) => {
        if (!Object.values(prevState).length) return;

        setProductsPaginationPage({ page: 1 });
        debouncedChangeFilterParamsHandler();
    });

    watch(getSelectedPaginationPage, (_, prevPage) => {
        if (prevPage === undefined) return;

        debouncedChangeFilterParamsHandler();
    });

    //methods
    function setProductsPaginationPage(payload) {
        store.commit('SET_PRODUCTS_PAGINATION_PAGE', payload)
    }

    function asyncFetchProductsData(payload) {
        store.dispatch('asyncFetchProductsData', payload);
    }

    function changeFilterParamsHandler() {
        const stateFilters = getAllFilters.value;
        const selectedBrands = getSelectedFilters(stateFilters.brands, 'isChecked', 'slug');
        const selectedColors = getSelectedFilters(stateFilters.colors, 'isChecked', 'name');
        const selectedSizes = getSelectedFilters(stateFilters.sizes, 'isChecked', 'name');
        const selectedMinPrice = String(stateFilters.selectedMinPrice);
        const selectedMaxPrice = String(stateFilters.selectedMaxPrice);
        const selectedPaginationPage = getSelectedPaginationPage.value ?? 1;

        const updatedFilterParams = getUpdatedFilterParams({
            brand: selectedBrands,
            color: selectedColors,
            size: selectedSizes,
            min_price: selectedMinPrice,
            max_price: selectedMaxPrice,
            page: selectedPaginationPage,
        });

        const currentRoute = route.path.split('?')[0];
        router.push(currentRoute + `?${updatedFilterParams}`);

        asyncFetchProductsData({
            filterParams: updatedFilterParams,
            categorySlug: route.params.categorySlug,
        });
    }

    function getSelectedFilters(items, activeProp, nameProp) {
        return items.filter((item) => item[activeProp]).map((item) => item[nameProp]);
    }

    function getUpdatedFilterParams(selectedFilters) {
        const filterKeys = Object.keys(selectedFilters);
        const updatedFilterParams = [];

        filterKeys.forEach((filterKey) => {
            switch (filterKey) {
                case 'brand':
                case 'color':
                case 'size': {
                    const preparedParams = selectedFilters[filterKey]
                        .map((item) => `${filterKey}[]=${item}`)
                        .join('&');
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

        return updatedFilterParams.join('&');
    }
}