import { createStore } from 'vuex';
import products from './modules/products';
import filterOptions from './modules/filterOptions';

const store = createStore({
  modules: {
    products,
    filterOptions,
  }
});

export default store;