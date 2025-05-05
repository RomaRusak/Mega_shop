<template>
    <div>
        <h2>{{ getProductName(productId) }}</h2>
        <p>category: {{ getProductCategory(productId) }}</p>
        <p>brand: {{ getProductBrand(productId) }}</p>
        <p>rating: {{ getProductRating(productId) }}</p>
        <p>Prices: {{getMinProductPrice(productId)}} - {{ getMaxProductPrice(productId) }}</p>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';
import store from '@/store';
    export default {
        props: {
            productId: {
                type: Number,
                required: true
            }
        },
        store,
        computed: {
            ...mapGetters([
                'getProductName',
                'getProductCategory',
                'getProductBrand',
                'getProductRating',
                'getMinProductPrice',
                'getMaxProductPrice',
            ]),
        }
    };
</script>