
import FiltersTransformedService from "@/services/FiltersTransformedService";
import axios from "axios";

export default {
    state() {
        return {
            jsonedDefFiltOpt: '',
            filterOptions: {
                categories: [],
                brands: [],
                colors: [],
                sizes: [],
                maxProductPrice:  0,
                minProductPrice:  0,
                selectedMinPrice: 0,
                selectedMaxPrice: 0,
            }
        }
    },
    mutations: {    
        INIT_FILTER_OPTIONS_STORE(state, {preparedData}) {
            state.jsonedDefFiltOpt = JSON.stringify(preparedData),
            state.filterOptions = {...preparedData};
        },

        SET_CATEGORY(state, id) {
            state.filterOptions = {
                ...state.filterOptions,
                categories: state.filterOptions.categories.map(category => {
                    if (category.id === id) return {...category, isSelected: true};
                    return {...category, isSelected: false};
                })
            };
        },

        HANDLE_CHECKBOX_CHANGE(state, {id, key}) {
            state.filterOptions = {
                ...state.filterOptions,
                [key]: state.filterOptions[key].map(item => {
                    if (item.id === id) {
                        return { ...item, isChecked: !item.isChecked };
                    }
                    return item;
                })
            };
        },

        SET_PRICE(state, {selectedPrice, key}) {
            state.filterOptions = {
                ...state.filterOptions,
                [key]: +selectedPrice,
            };
        }
    },
    actions: {
        async asyncFetchUniqFilterValues({ commit }) {
          try {
            const responce = await axios.post("http://mega_shop.com/api/filters");
            if (responce.status === 200) {
    
              const { max_product_price, min_product_price, uniq_brands, uniq_categories, uniq_colors, uniq_sizes } = responce.data.data;

              const preparedData = FiltersTransformedService.prepareFiltersData({
                uniqCategories: uniq_categories,
                uniqBrands: uniq_brands,
                uniqColors: uniq_colors,
                uniqSizes:  uniq_sizes,
                maxProductPrice: max_product_price,
                minProductPrice: min_product_price,
              })
    
              commit('INIT_FILTER_OPTIONS_STORE', {preparedData});
            }
          } catch (error) {
            console.error(error);
          }
        }
      },
    getters: {
        getFilters(state) {
            return (key) => {
                return state.filterOptions[key];
            }
        },
        getAllFilters(state) {
            return state.filterOptions;
        }
    }
}