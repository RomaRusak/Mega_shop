<template>
  <page-preloader v-if="isShowPagePreloader"/>
  {{ JSON.stringify(selectedProductVariant) }}
  <prod-var-filter-checkboxes 
  :checkboxes = "uniqColors"
  filtersKey = 'uniqColors'
  title="Color"
  @checkboxChange="handleCheckboxChange"
  />
  <prod-var-filter-checkboxes 
  :checkboxes = "uniqSizes"
  filtersKey = 'uniqSizes'
   title="Size"
  @checkboxChange="handleCheckboxChange"
  />
</template>
<script>
import axios from 'axios';
import { onMounted,} from 'vue';
import { useRoute } from 'vue-router';
import PagePreloader from './UI/PagePreloader.vue';
import { ref } from 'vue';
import ProdVarFilterCheckboxes from './ProdVarFilterCheckboxes.vue';

  export default {
    components: {
      'page-preloader': PagePreloader,
      'prod-var-filter-checkboxes': ProdVarFilterCheckboxes,
    },

    setup() {
      const route = useRoute();
      const isShowPagePreloader = ref(false);
      const productVariants = ref([]);
      const uniqSizes = ref([]);
      const uniqColors = ref([]);
      const selectedProductVariant = ref({});

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

      function getUniqCheckboxValues(key) {
        const transformedData = productVariants.value.map((item) => (
          {
            value: item[key],
            isChecked: item[key] === selectedProductVariant.value[key],
          }
        ));

        const transformedUniqData = transformedData.filter((item, index, self) =>
          index === self.findIndex((value) => value.value === item.value)
        );

        const priorityOrder = ['red', 'green', 'blue', 's_size', 'm_size', 'l_size', 'xl_size'];

        transformedUniqData.sort((a, b) => {
          const aPriority = priorityOrder.indexOf(a.value);
          const bPriority = priorityOrder.indexOf(b.value);

          return aPriority - bPriority;
        });

        return transformedUniqData;
      }

      function handleCheckboxChange({selectedValue, filtersKey, checkedStatus}) {
        const updateCheckboxes = (filterArray) => {
          return filterArray.map(checkboxData => {
            if (checkboxData.value === selectedValue) {
              return {...checkboxData, isChecked: !checkedStatus};
            }
            return {...checkboxData, isChecked: false};
          });
        };

        if (filtersKey === 'uniqColors') {
          uniqColors.value = updateCheckboxes(uniqColors.value);

          if (checkedStatus) {
            selectedProductVariant.value = {};
            return;
          }
          
          selectedProductVariant.value = productVariants.value.find(({color}) => color === selectedValue);
          console.log(getUniqCheckboxValues('size'));
          //при изменении цвета размеры сбрасываются и дизейблятся те, у которых не подходиящего цвета
        }

        if (filtersKey === 'uniqSizes') {
          uniqSizes.value = updateCheckboxes(uniqSizes.value);
        }
      }

      onMounted(async () => {
        const request = prepareRequest('http://mega_shop.com/api/products/');
        const responce = await asyncFetchProductData(request);
        
        if (responce.status === 200) {
          productVariants.value = responce.data.data.product_variants; 
          selectedProductVariant.value = productVariants.value[0]
          uniqSizes.value = getUniqCheckboxValues('size');
          uniqColors.value = getUniqCheckboxValues('color');
        }
      });

      return {
        isShowPagePreloader,
        productVariants,
        uniqSizes,
        uniqColors,
        handleCheckboxChange,
        selectedProductVariant,
      }
    }
  }
</script>