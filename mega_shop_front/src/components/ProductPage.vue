<template>
  <page-preloader v-if="isShowPagePreloader"/>
  <div class="product-variant-wrapper">
    <product-variant-gallery 
    :prodVarGallery="prodVarGallery"
    @changeMainImage="handleChangeMainImage"
    />
    <div class="product-variant-info">
      <product-description 
      :productDescriptionData="productDescriptionData"
      />
      <div 
      class="product-variant-info__filters-container"
      >
        <prod-var-filter-checkboxes 
        :checkboxes = "uniqColors"
        filtersKey = 'uniqColors'
        title="Colours available"
        @checkboxChange="handleCheckboxChange"
        />
        <prod-var-filter-checkboxes 
        :checkboxes = "uniqSizes"
        filtersKey = 'uniqSizes'
        title="Select size"
        @checkboxChange="handleCheckboxChange"
        />
      </div>
      <div class="product-variant-info__buy_block">
        <price-tag 
        :selectedProdVarPriceData="selectedProdVarPriceData"
        />
      </div>
    </div>
  </div>
</template>
<script>
import axios from 'axios';
import { onMounted,} from 'vue';
import { useRoute } from 'vue-router';
import PagePreloader from './UI/PagePreloader.vue';
import { ref, watch } from 'vue';
import ProdVarFilterCheckboxes from './ProdVarFilterCheckboxes.vue';
import ProductVariantGallery from './ProductVariantGallery.vue';
import ProductDescription from './ProductDescription.vue';
import PriceTag from './UI/PriceTag.vue';

  export default {
    components: {
      'page-preloader': PagePreloader,
      'prod-var-filter-checkboxes': ProdVarFilterCheckboxes,
      'product-variant-gallery': ProductVariantGallery,
      'product-description': ProductDescription,
      'price-tag': PriceTag,
    },

    setup() {
      const route = useRoute();
      const isShowPagePreloader = ref(false);
      const productVariants = ref([]);
      const uniqSizes = ref([]);
      const uniqColors = ref([]);
      const selectedProductVariant = ref({});
      const prodVarGallery = ref({image_paths: []});
      const productDescriptionData = ref({name: '', rating: 0});
      const selectedProdVarPriceData = ref({price: 0, priceWithDiscount: 0});

      //watchers
      watch(selectedProductVariant, (selectedProdVarState) => {
        const { gallery, price, price_with_discount } = selectedProdVarState;
        const preparedImagePaths = JSON.parse(gallery.image_paths)?.map(imgData => ({
          ...imgData, 
          isShownAsMainImage: imgData.isMainImage
        })) || [];

        prodVarGallery.value = {
          ...gallery, 
          image_paths: preparedImagePaths
        };

        selectedProdVarPriceData.value = {
          ...selectedProdVarPriceData.value, 
          price: +price, 
          priceWithDiscount: +price_with_discount,
        };
      });

      //methods
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

      function getIsDiabledStatus(selectedProdVarColor, key, value) {
        if (key === 'color') {
          return false;
        }

        const filteredProductVariantsByColor = productVariants.value.filter(({color}) => color === selectedProdVarColor); 

        return !filteredProductVariantsByColor.some(({size}) => size === value);
      }

      function findSelectedProductVariant(selectedValues) {
        if (Object.values(selectedValues).some(selectedVal => !selectedVal)) {
          return {};
        }

        const {selectedColor, selectedSize} = selectedValues;
        const selectedProductVariant = productVariants.value.find(({size, color}) => (
          size === selectedSize && color === selectedColor
        ));

        return selectedProductVariant ?? {};
      }
      
      function getUniqCheckboxValues(key) {

        const transformedData = productVariants.value.map((item) => (
          {
            value: item[key],
            isChecked: item[key] === selectedProductVariant.value[key],
            isDisabled: getIsDiabledStatus(selectedProductVariant.value.color, key, item[key]),
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

      function handleCheckboxChange({selectedValue, filtersKey}) {
        const updateCheckboxes = (filterArray) => {
          return filterArray.map(checkboxData => {
            if (checkboxData.value === selectedValue) {
              return {...checkboxData, isChecked: true};
            }
            return {...checkboxData, isChecked: false};
          });
        };

        const getSelectedCheckboxVal = (data) => {

          const selectedCheckbox = data.find(({isChecked}) => isChecked);
          if (!selectedCheckbox) {
            return null;
          }

          return selectedCheckbox.value
        };
        
        if (filtersKey === 'uniqColors') {
          uniqColors.value = updateCheckboxes(uniqColors.value);

          uniqSizes.value = uniqSizes.value.map(checkboxData => (
            {
              ...checkboxData, 
              isDisabled: getIsDiabledStatus(selectedValue, 'size', checkboxData.value)
            }
          )).map((checkboxData, _, self) => {
            const notDisCheckboxes = self.filter(({isDisabled}) => !isDisabled);
            const firstNotDisCheckboxVal = notDisCheckboxes[0].value;

            return {...checkboxData, isChecked: checkboxData.value === firstNotDisCheckboxVal};
          });
        }

        if (filtersKey === 'uniqSizes') {
          uniqSizes.value = updateCheckboxes(uniqSizes.value);
        }

        const selectedColor = getSelectedCheckboxVal(uniqColors.value);
        const selectedSize  = getSelectedCheckboxVal(uniqSizes.value);

        selectedProductVariant.value = findSelectedProductVariant({selectedColor, selectedSize});
      }

      function handleChangeMainImage(selectedImgName) {
        const gallery = prodVarGallery.value;
        prodVarGallery.value = {...gallery, image_paths: gallery.image_paths.map(imgData => {
          return {...imgData, isShownAsMainImage: imgData.image === selectedImgName};
        })};
      }

      onMounted(async () => {
        const request = prepareRequest('http://mega_shop.com/api/products/');
        const responce = await asyncFetchProductData(request);
        
        if (responce.status === 200) {
          const respData = responce.data.data;
          
          productDescriptionData.value = {
            ...productDescriptionData.value,
            name: respData.name,
            rating: +respData.rating,
          }
          
          productVariants.value = respData.product_variants; 

          selectedProductVariant.value = productVariants.value[0]
          uniqColors.value = getUniqCheckboxValues('color');
          uniqSizes.value = getUniqCheckboxValues('size');
        }
      });

      return {
        isShowPagePreloader,
        productVariants,
        uniqSizes,
        uniqColors,
        handleCheckboxChange,
        selectedProductVariant,
        prodVarGallery,
        handleChangeMainImage,
        productDescriptionData,
        selectedProdVarPriceData,
      }
    }
  }
</script>

<style scoped>
  .product-variant-wrapper {
    display: grid;
    grid-template-columns: 1fr 1fr;
    grid-column-gap: 75px;
  }

  .product-variant-info {
    padding: 30px 0;
    color: #3C4242;
    max-width: 500px;
    display: flex;
    flex-direction: column;
    gap: 40px;
  }

  .product-variant-info__filters-container {
    display: flex;
    flex-direction: column;
    gap: 30px;
  }

  .product-variant-info__buy_block {
    display: flex;
    justify-content: space-between;
  }
</style>