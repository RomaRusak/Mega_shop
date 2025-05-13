<template>
    <div class="product-card-wrapper">
        <img 
        :src="require(`@/assets/${productCardMainImage(productId)}`)"
        class="product-card-img"
        >
        <footer class="product-card__footer">
            <div class="product-card__description">
                <h2 
                @click="toggleIsCutName"
                :class="{
                    'product-card__name': true,
                    'cut-name': isCutProductName,
                }"
                >
                    {{ productName(productId) }}
                </h2>
                <p class="product-card__brand">{{ productBrand(productId) }}</p>
            </div>
            <div class="product-card__price">
                {{ minProductPrice(productId) }}$ - {{ maxProductPrice(productId) }}$
            </div>
        </footer>
    </div>
</template>

<script>
import { computed } from 'vue';
import { useStore } from 'vuex';
import { ref } from 'vue';

    export default {
        props: {
            productId: {
                type: Number,
                required: true
            }
        },

        setup() {
            const store = useStore();
            let isCutProductName = ref(true);
            
            // computeds
            const productName = computed(() => store.getters.getProductName);
            const productBrand = computed(() => store.getters.getProductBrand);
            const minProductPrice = computed(() => store.getters.getMinProductPrice);
            const maxProductPrice = computed(() => store.getters.getMaxProductPrice);
            const productCardMainImage = computed(() => store.getters.getProductCardMainImage);

            const toggleIsCutName = () => {
                isCutProductName.value = !isCutProductName.value;
            }

            return {
                productName,
                productBrand,
                minProductPrice,
                maxProductPrice,
                productCardMainImage,
                isCutProductName,
                toggleIsCutName,
            };
        }
    };
</script>

<style scoped>
    .product-card-wrapper {
        display: flex;
        flex-direction: column;
        gap: 20px;
        text-align: center;
        cursor: pointer;
        transition: all .3s ease;
    }

    .product-card-wrapper:hover {
        transform: scale(1.05);
    }
    
    .product-card-img {
        border-radius: 12px;
        overflow: hidden;
        width: 100%;
        height: 370px;
    }

    .product-card__footer {
       display: flex;
       flex-direction: column;
       align-items: center;
       gap: 5px;
    }

    .product-card__name {
        font-size: 16px;
        font-weight: 600;
        color: #3C4242;
        max-width: 260px;
        overflow: hidden;
    }

    .cut-name {
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .product-card__brand {
        font-weight: 500;
        font-size: 14px;
        color: #807D7E;
    }

    .product-card__description {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .product-card__price {
        padding: 10px 22px;
        color: #3C4242;
        font-weight: 700;
        background-color: #F6F6F6;
        border-radius: 8px;
    }
</style>