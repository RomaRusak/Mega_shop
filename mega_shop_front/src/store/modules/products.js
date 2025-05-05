import ProductsRequestService from "@/services/ProductsRequestService";
import ProductsTransformedService from "@/services/ProductsTransformedService";
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
                  const preparedProducts = ProductsTransformedService.prepareProductsData({products});

                  commit('SET_PRODUCTS_DATA', {products: preparedProducts, pagination});
                }
            } catch(error) {
                console.error(error);
            }
        }
      },
      getters: {
        getProducts(state) {
          return state.productsData.products;
        },
        
        getProductIds(state) {
          console.log(state.productsData.products);
          return state.productsData.products.map(product => product.id);
        },

        getProductById(state) {
          return (id) => {
            return state.productsData.products.find(product => product.id === id);
          }
        },

        getProductName(state, getters) {
          return (id) => {
            return getters.getProductById(id).name;
          }
        },

        getProductCategory(state, getters) {
          return (id) => {
            return getters.getProductById(id).category.name;
          }
        },

        getProductBrand(state, getters) {
          return (id) => {
            return getters.getProductById(id).brand.name;
          }
        },

        getProductRating(state, getters) {
          return (id) => {
            return getters.getProductById(id).rating;
          }
        },

        getMinProductPrice(state, getters) {
          return (id) => {
            const product = getters.getProductById(id);
            const productVariantPrices = product.product_variants.map(({priceWithDiscount}) => +priceWithDiscount);

            return Math.min(...productVariantPrices);
          }
        },

        getMaxProductPrice(state, getters) {
          return (id) => {
            const product = getters.getProductById(id);
            const productVariantPrices = product.product_variants.map(({priceWithDiscount}) => +priceWithDiscount);

            return Math.max(...productVariantPrices);
          }
        },
      }
};