<template>
    <div class="product-description">
        <h1 class="product-description__title">{{ productDescriptionData.name }}</h1>
        <div class="product-description__rating-wrapper">
            <product-rating 
            :rating="productDescriptionData.rating"
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
            productDescriptionData: {
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
    .product-description {
        display: flex;
        flex-direction: column;
        gap: 35px;
    }

    .product-description__title {
        font-weight: 600;
        font-size: 40px;
        line-height: 140%;
    }

    .product-description__rating-wrapper {
        min-height: 30px;
        position: relative;
    }
</style>