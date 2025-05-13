<template>
    <div 
    class="product-card-wrapper" 
    @click="navigateToProductPage(getProductSlug(productId))"
    >
        <img 
        :src="require(`@/assets/${getProductCardMainImage(productId)}`)"
        class="product-card-img"
        >
        <footer class="product-card__footer">
            <div class="product-card__description">
                <h2 
                @mouseenter="toggleIsCutName"
                @mouseleave="toggleIsCutName"
                :class="{
                    'product-card__name': true,
                    'cut-name': isCutProductName,
                }"
                >
                    {{ getProductName(productId) }}
                </h2>
                <p class="product-card__brand">{{ getProductBrand(productId) }}</p>
            </div>
            <div class="product-card__price">
                {{ getMinProductPrice(productId) }}$ - {{ getMaxProductPrice(productId) }}$
            </div>
        </footer>
    </div>
</template>

<script>
import { computed } from 'vue';
import { useStore } from 'vuex';
import { ref } from 'vue';
import { useRouter, useRoute } from 'vue-router';

    export default {
        props: {
            productId: {
                type: Number,
                required: true
            }
        },

        setup() {
            const store = useStore();
            const router = useRouter();
            const route = useRoute();

            let isCutProductName = ref(true);
            
            // computeds
            const getProductName = computed(() => store.getters.getProductName);
            const getProductBrand = computed(() => store.getters.getProductBrand);
            const getMinProductPrice = computed(() => store.getters.getMinProductPrice);
            const getMaxProductPrice = computed(() => store.getters.getMaxProductPrice);
            const getProductCardMainImage = computed(() => store.getters.getProductCardMainImage);
            const getProductSlug = computed(() => store.getters.getProductSlug)

            const toggleIsCutName = () => {
                isCutProductName.value = !isCutProductName.value;
            }

            const navigateToProductPage = (slug) => {
                const {categorySlug} = route.params;
                router.push({ name: 'product', params: { categorySlug, productSlug: slug}});
            }

            return {
                getProductName,
                getProductBrand,
                getMinProductPrice,
                getMaxProductPrice,
                getProductCardMainImage,
                isCutProductName,
                getProductSlug,
                toggleIsCutName,
                navigateToProductPage,
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