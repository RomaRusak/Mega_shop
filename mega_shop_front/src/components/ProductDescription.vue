<template>
    <div class="product-description">
        <div class="product-description__title-wrapper">
            <h2 class="product-description__title">Product Description</h2>
        </div>
        <div class="product-description__tabs-wrapper">
            <div class="product-description__tabs">
                <div 
                v-for="(tab, index) in tabs"
                :key="index"
                @click="setCurrentTab(tab.value)"
                :class="{
                    'product-description-tab': true,
                    'active': tab.isActive,
                }"
                >
                    {{ tab.value }}
                </div>
            </div>
            <div class="product-description__content">
                <div v-if="activeTabVal === 'Description'">
                    <p>{{ productDescription }}</p>
                </div>
                <div v-if="activeTabVal === 'User comments'">
                    <reviews-slider 
                    v-if="productReviews.length"
                    :reviews="productReviews"
                    />
                    <p 
                    v-else
                    class="no-reviews-message"
                    >
                        Currently, the product has no reviews.
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, computed } from 'vue';
import ReviewsSlider from './UI/ReviewsSlider.vue';
    export default {
        props: {
            productDescriptionData: {
                type: Object,
                required: true,
            }
        },

        components: {'reviews-slider': ReviewsSlider},

        setup(props) {
            const tabs = ref([{value: 'Description', isActive: true}, {value: 'User comments', isActive: false}]);

            //commputeds
            const activeTabVal = computed(() => {
                return tabs.value.find(tab => tab.isActive).value;
            });

            const productDescription = computed(() => props.productDescriptionData.description);
            const productReviews = computed(() => props.productDescriptionData.reviews);

            //methods
            const setCurrentTab = (selectedTabVal) => {
                tabs.value = tabs.value.map(tab => {
                    if (tab.value === selectedTabVal) {
                        return {...tab, isActive: true};
                    }
                    return {...tab, isActive: false};
                })
            }


            return {
                tabs,
                setCurrentTab,
                activeTabVal,
                productDescription,
                productReviews,
            }
        }
    }
</script>

<style scoped>
    .product-description {
        grid-column: 1/3;
        display: flex;
        flex-direction: column;
        gap: 30px;
        padding-bottom: 40px;
    }

    .product-description__title {
        color: #3C4242;
        font-weight: 600;
        font-size: 28px;
        line-height: 33.5px;
        position: relative;
        padding-left: 21px;
    }

    .product-description__title-wrapper {
        display: flex;
        justify-content: center;
    }

    .product-description__title::before {
        content: "";
        position: absolute;
        display: block;
        height: 100%;
        width: 6px;
        background-color: #8A33FD;
        left: 0;
    }

    .product-description__tabs-wrapper {
        width: 60%;
        margin: 0 auto;
        color: #807D7E;
        display: flex;
        flex-direction: column;
        gap: 25px;
    }

    .product-description__tabs {
        display: flex;
        justify-content: center;
        gap: 30px;
        font-size: 18px;
    }

    .product-description-tab {
        cursor: pointer;
        padding: 8px;
    }

    .product-description-tab.active {
        color: #3C4242;
    }

    .product-description__content {
        font-weight: 400;
        font-size: 16px;   
        line-height: 25px;
        min-height: 200px;
    }

    .no-reviews-message {
        text-align: center;
        font-size: 18px;
    }
</style>