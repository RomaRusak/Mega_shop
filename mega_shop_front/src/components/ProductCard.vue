<template>
    <div>
        <h2>{{ productName(productId) }}</h2>
        <p>category: {{ productCategory(productId) }}</p>
        <p>brand: {{ productBrand(productId) }}</p>
        <p>rating: {{ productRating(productId) }}</p>
        <p>Prices: {{ minProductPrice(productId) }} - {{ maxProductPrice(productId) }}</p>
        <p>Image: {{ productCardMainImage(productId) }}</p>
        <img :src="require(`@/assets/${productCardMainImage(productId)}`)">
    </div>
</template>

<script>
import { computed } from 'vue';
import { useStore } from 'vuex';

    export default {
        props: {
            productId: {
                type: Number,
                required: true
            }
        },

        setup() {
            const store = useStore();
            
            // computeds
            const productName = computed(() => store.getters.getProductName);
            const productCategory = computed(() => store.getters.getProductCategory);
            const productBrand = computed(() => store.getters.getProductBrand);
            const productRating = computed(() => store.getters.getProductRating);
            const minProductPrice = computed(() => store.getters.getMinProductPrice);
            const maxProductPrice = computed(() => store.getters.getMaxProductPrice);
            const productCardMainImage = computed(() => store.getters.getProductCardMainImage);

            return {
                productName,
                productCategory,
                productBrand,
                productRating,
                minProductPrice,
                maxProductPrice,
                productCardMainImage,
            };
        }
    };
</script>