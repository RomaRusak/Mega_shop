import ProductsRequestService from "@/services/ProductsRequestService";
import axios from "axios";
import ProductsTransformedService from "@/services/ProductsTransformedService";

export default {
    state() {
        return {
          productsData: {
            isLoading: false,
            products: [],
            pagination: {},
          },
        };
      },
      mutations: {
        SET_PRODUCTS_DATA(state, {products, pagination}) {
          state.productsData = {
              ...state.productsData,
              products: [...products],
              pagination: {...pagination},
          };
        },

        SET_PRODUCTS_PAGINATION_PAGE(state, {page}) {
          state.productsData.pagination = {
            ...state.productsData.pagination,
            page,
          }
        },

        SET_IS_LOADING_STATUS(state, {loadingStatus}) {
          state.productsData = {
            ...state.productsData,
            isLoading: loadingStatus,
          }
        },

        RESET_PRODUCTS_STORE(state) {
          state.productsData = {
            isLoading: false,
            products: [],
            pagination: {},
          };
        }
      },
      actions: {
        async asyncFetchProductsData({commit}, payload) {
          try {
                const request = ProductsRequestService.prepareRequest(payload);

                commit('SET_IS_LOADING_STATUS', {loadingStatus: true});

                const responce = await axios.get(request);

                if (responce.status === 200) {
                  const {products, pagination} = responce.data.data;
                  const transformedProducts = ProductsTransformedService.prepareProductsData(products);

                  commit('SET_PRODUCTS_DATA', {products: transformedProducts, pagination});
                }

                commit('SET_IS_LOADING_STATUS', {loadingStatus: false});
            } catch(error) {
              console.error(error);
              commit('SET_IS_LOADING_STATUS', {loadingStatus: false});
            }
        }
      },
      getters: {
        getProducts(state) {
          return state.productsData.products;
        },
        
        getProductIds(state) {
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
            const productVariantPrices = product.product_variants.map(({price_with_discount}) => +price_with_discount);

            return Math.min(...productVariantPrices);
          }
        },

        getMaxProductPrice(state, getters) {
          return (id) => {
            const product = getters.getProductById(id);
            const productVariantPrices = product.product_variants.map(({price_with_discount}) => +price_with_discount);

            return Math.max(...productVariantPrices);
          }
        },

        getPaginationData(state) {
          return state.productsData.pagination;
        },

        getPaginationDataByKey(state) {
          return (key) => {
            return state.productsData.pagination[key];
          }
        },

        getProductsIsLoading(state) {
          return state.productsData.isLoading;
        },

        getProductCardMainImage(state, getters) {
          return (id) => {
            const product = getters.getProductById(id);
            const gallery = product.product_variants[0].gallery.image_paths;
            const {image} = gallery.find(imgData => imgData.isMainImage);
            return image;
          }
        },

        getProductSlug(state, getters) {
          return (id) => {
            const product = getters.getProductById(id);
            return product.slug;
          }
        }
      }
};