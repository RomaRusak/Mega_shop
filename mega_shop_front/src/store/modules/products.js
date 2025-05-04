import ProductsRequestService from "@/services/ProductsRequestService";
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
        async asyncFetchProductsData({commit}, payload) {
          try {
                const request = ProductsRequestService.prepareRequest(payload)
                const responce = await axios.get(request);

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