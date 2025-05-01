const prepare= (items, activeProp) => {
    return items.map((item, idx) => ({...item, id: idx, [activeProp]: false}));
}

export default {
    state() {
        return {
            filterOptions: {
                categories: [],
                brands: [],
                color: [],
                sizes: [],
            }
        }
    },
    mutations: {    
        INIT_FILTER_OPTIONS_STORE(state, payload) {
            const categories = payload.uniqCategories;
            const brands = payload.uniqBrands;
            const colors = payload.uniqColors;
            const sizes = payload.uniqSizes;

            const preparedCategories = prepare(categories, 'isSelected');
            const prepapedBrands     = prepare(brands, 'isChecked');
            const preparedColors     = prepare(colors, 'isChecked');
            const preparedSizes      = prepare(sizes, 'isChecked');
            
            state.filterOptions = {
                categories: preparedCategories,
                brands: prepapedBrands,
                colors: preparedColors,
                sizes: preparedSizes,
            };
        },

        SELECT_CATEGORY(state, id) {
            state.filterOptions.categories = state.filterOptions.categories.map(category => {
                if (category.id === id) return {...category, isSelected: true};
                return {...category, isSelected: false};
            });
        },

        HANDLE_CHECKBOX_CHANGE(state, payload) {
            const {id, key} = payload;

            state.filterOptions = {
                ...state.filterOptions,
                [key]: state.filterOptions[key].map(item => {
                    if (item.id === id) {
                        return { ...item, isChecked: !item.isChecked };
                    }
                    return item;
                })
            };
            console.log(state.filterOptions);
        }
    },
    getters: {
        getFilters(state) {
            return (key) => {
                return state.filterOptions[key];
            }
        }
    }
}