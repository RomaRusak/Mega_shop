<template>
  <h1>Product Page</h1>
  <page-preloader v-if="isShowPagePreloader"/>
</template>
<script>
import axios from 'axios';
import { onMounted,} from 'vue';
import { useRoute } from 'vue-router';
import PagePreloader from './UI/PagePreloader.vue';
import { ref } from 'vue';

  export default {
    components: {
      'page-preloader': PagePreloader,
    },

    setup() {
      const route = useRoute();
      const isShowPagePreloader = ref(false);

      function prepareRequest(baseEndpoint) {
        const {categorySlug, productSlug} = route.params;

        if (categorySlug) {
          baseEndpoint += `${categorySlug}/`;  
        }

        return baseEndpoint += productSlug;
      } 

      async function asyncFetchProductData(request) {
        try {
          isShowPagePreloader.value = true;
          const responce = await axios.get(request);

          setTimeout(() => {
            isShowPagePreloader.value = false;
          }, 700);

          return responce;
        } catch(error) {
          console.error(error);
          isShowPagePreloader.value = false;
        }
      }

      onMounted(async () => {
        const request = prepareRequest('http://mega_shop.com/api/products/');
        const responce = await asyncFetchProductData(request);
        
        if (responce.status === 200) {
          console.log(responce);
        }
      });

      return {
        isShowPagePreloader,
      }
    }
  }
</script>