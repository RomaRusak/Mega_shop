import { createStore } from 'vuex';
import products from './modules/products';
import uniqFilterValues from './modules/uniqFilterValues';
import filterOptions from './modules/filterOptions';

const store = createStore({
  modules: {
    products,
    uniqFilterValues,
    filterOptions,
  }
});

export default store;