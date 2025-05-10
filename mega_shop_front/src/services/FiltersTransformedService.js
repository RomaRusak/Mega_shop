import ProductsRequestService from "./ProductsRequestService";

class FiltersTransformedService {
    static prepareArray(items, activeProp) {
        return items.map((item, idx) => ({...item, id: idx, [activeProp]: false}));
    }

    static preparePrice(price, roundMode){
        switch(true) {
            case roundMode === 'up':
                return Math.ceil(price);
            case roundMode === 'down':
                return Math.floor(price);
        }
    }

    static updateFiltersFromURL(filtersData) {
        const urlParams = ProductsRequestService.parseURL();
        const {categorySlug, filterParams} = urlParams;

        if (categorySlug) {
            filtersData = this.updateCategoryFromURL(filtersData, categorySlug);
        }

        if (filterParams) {
            filtersData = this.updateFilterParamsFromURL(filtersData, filterParams);
        }

        return filtersData;
    }

    static updateCategoryFromURL(filtersData, categorySlug) {
        return {
            ...filtersData,
            categories: filtersData.categories.map(category => {
                if (category.slug === categorySlug) return {...category, 'isSelected': true};
                return category;
               })
            };
    }

    static updateFilterParamsFromURL(filtersData, filterParams) {
        const prepareSelectedParams = (params) => {
            const preparedParams = {};

            const selectedParams = params.split('&').map(param => param.replace(/\[\]/, '').split('='));

            selectedParams.forEach(param => {
                const namesMap = {
                    brand: 'brands',
                    color: 'colors',
                    size: 'sizes',
                    min_price: 'selectedMinPrice',
                    max_price: 'selectedMaxPrice',
                };

                const name = namesMap[param[0]];
                const value = param[1];

                if (name) {
                    preparedParams[name] = preparedParams[name] || [];
                    preparedParams[name].push(value);
                }
            })

            return preparedParams;
        }

        const selectedParams = prepareSelectedParams(filterParams)
        
        for(const key in selectedParams) {
            const selectedParamVal = selectedParams[key];

            const updateFilters = (key, selectedParamVal) => {
                return {
                    ...filtersData,
                    [key]: filtersData[key].map(item => {
                        if (selectedParamVal.some(param => param === item.name || param === item.slug)) {
                            return {...item, isChecked: true};
                        }
                        return item;
                    })
                };
            };

            const updateFiltersPrice = (key, selectedParamVal) => {
                return {
                    ...filtersData,
                    [key]: selectedParamVal,
                }
            }

            switch (key) {
                case 'brands':
                case 'colors':
                case 'sizes':
                    filtersData = updateFilters(key, selectedParamVal);
                    break;
                case 'selectedMinPrice':
                case 'selectedMaxPrice':
                    filtersData = updateFiltersPrice(key, +selectedParamVal[0]);
            }
        }

        return filtersData;
    }

    static prepareFiltersData({
        uniqCategories,
        uniqBrands,
        uniqColors,
        uniqSizes,
        maxProductPrice,
        minProductPrice,
    }) {
        const prepMaxProductPrice = this.preparePrice(maxProductPrice, 'up');
        const prepMinProductPrice = this.preparePrice(minProductPrice, 'down');

        let filtersData = {
            categories: this.prepareArray(uniqCategories, 'isSelected'),
            brands: this.prepareArray(uniqBrands, 'isChecked'),
            colors: this.prepareArray(uniqColors.map(item => ({name: item})), 'isChecked'),
            sizes:  this.prepareArray(uniqSizes.map(item => ({name: item})), 'isChecked'),
            maxProductPrice: prepMaxProductPrice,
            minProductPrice: prepMinProductPrice,
            selectedMinPrice: prepMinProductPrice,
            selectedMaxPrice: prepMaxProductPrice,
        };
        
        filtersData = this.updateFiltersFromURL(filtersData);

        return filtersData;
    }
}

export default FiltersTransformedService