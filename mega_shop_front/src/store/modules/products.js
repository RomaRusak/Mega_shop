import axios from "axios";

export default {
    state() {
        return {
          productsData: {
            products: [],
            pagination: {},
          },
        };
      },
      mutations: {
        SET_PRODUCTS_DATA(state, {products, pagination}) {
            state.productsData = {
                products: [...products],
                pagination: {...pagination},
            };
        }
      },
      actions: {
        async asyncFetchProductsData({commit}) {
            try {
                const responce = await axios.get("http://mega_shop.com/api/products");

                if (responce.status === 200) {
                    const {products, pagination} = responce.data.data;

                    commit('SET_PRODUCTS_DATA', {products, pagination});
                }
            } catch(error) {
                console.error(error);
            }
        }
      },
      getters: {
        getProducts(state) {
          return state.productsData.products;
        }
      }
};