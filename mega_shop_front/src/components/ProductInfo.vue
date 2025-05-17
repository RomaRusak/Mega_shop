<template>
    <div class="product-info">
        <h1 class="product-info__title">{{ productInfoData.name }}</h1>
        <div class="product-info__rating-wrapper">
            <product-rating 
            :rating="productInfoData.rating"
            :starSize="30"
            style="position: absolute; top: 0; left: -15px;"
            />
        </div>
    </div>
</template>

<script>
import ProductRating from './UI/ProductRating.vue';
    export default {
        props: {
            productInfoData: {
                type: Object,
                required: true,
            }
        },

        components: {
            'product-rating': ProductRating,
        },

        setup() {
            
        }
    }
</script>

<style scoped>
    .product-info {
        display: flex;
        flex-direction: column;
        gap: 35px;
    }

    .product-info__title {
        font-weight: 600;
        font-size: 40px;
        line-height: 140%;
    }

    .product-info__rating-wrapper {
        min-height: 30px;
        position: relative;
    }
</style>