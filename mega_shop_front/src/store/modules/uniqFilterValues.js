import axios from "axios";

const prepare= (filterValues) => {
  return {
    ...filterValues,
    maxProductPrice: Math.ceil(+filterValues.maxProductPrice),
    minProductPrice: Math.floor(+filterValues.minProductPrice),
  };
};

export default {
  state() {
    return {
      uniqFilterValues: {
        maxProductPrice: 0,
        minProductPrice: 0,
        uniqBrands: [],
        uniqCategories: [],
        uniqColors: [],
        uniqSizes: [],
      },
    };
  },
  mutations: {
    INIT_UNIQ_FILTER_VALUES(state, filterValues) {
      const preparedFilterValues = prepare(filterValues);

      state.uniqFilterValues = {
        maxProductPrice: preparedFilterValues.maxProductPrice,
        minProductPrice: preparedFilterValues.minProductPrice,
        uniqBrands: preparedFilterValues.uniqBrands,
        uniqCategories: preparedFilterValues.uniqCategories,
        uniqColors: preparedFilterValues.uniqColors,
        uniqSizes: preparedFilterValues.uniqSizes,
      };
    }
  },
  actions: {
    async asyncFetchUniqFilterValues({ commit }) {
      try {
        const responce = await axios.post("http://mega_shop.com/api/filters");
        if (responce.status === 200) {

          const { max_product_price, min_product_price, uniq_brands, uniq_categories, uniq_colors, uniq_sizes } = responce.data.data;

          commit('INIT_UNIQ_FILTER_VALUES', {
            maxProductPrice: max_product_price,
            minProductPrice: min_product_price,
            uniqBrands: uniq_brands,
            uniqCategories: uniq_categories,
            uniqColors: uniq_colors,
            uniqSizes: uniq_sizes,
          });

          commit('INIT_FILTER_OPTIONS_STORE', {
            uniqCategories: uniq_categories,
            uniqBrands: uniq_brands,
            uniqColors: uniq_colors.map(item => ({name: item})),
            uniqSizes:  uniq_sizes.map(item => ({name: item}))
          });
        }
      } catch (error) {
        console.error(error);
      }
    }
  },
}