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

        return {
            categories: this.prepareArray(uniqCategories, 'isSelected'),
            brands: this.prepareArray(uniqBrands, 'isChecked'),
            colors: this.prepareArray(uniqColors.map(item => ({name: item})), 'isChecked'),
            sizes:  this.prepareArray(uniqSizes.map(item => ({name: item})), 'isChecked'),
            maxProductPrice: prepMaxProductPrice,
            minProductPrice: prepMinProductPrice,
            selectedMinPrice: prepMinProductPrice,
            selectedMaxPrice: prepMaxProductPrice,
        };
    }
}

export default FiltersTransformedService