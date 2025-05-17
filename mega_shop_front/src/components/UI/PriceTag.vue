<template>
    <div class="price-tag">
        <span 
        v-if="priceBeforeDiscount !== priceAfterDiscount"
        style=" text-decoration: line-through;"
        >
            {{ priceBeforeDiscount }}$
        </span>
        <span>{{ priceAfterDiscount }}$</span>
    </div>
</template>

<script>
import { computed } from 'vue';
    export default {
        props: {
            selectedProdVarPriceData: {
                type: Object,
                required: true,
            }
        },

        setup(props) {
            const priceBeforeDiscount = computed(() => props.selectedProdVarPriceData.price);
            const priceAfterDiscount = computed(() => props.selectedProdVarPriceData.priceWithDiscount);

            return {
                priceBeforeDiscount,
                priceAfterDiscount,
            }
        }

    }
</script>

<style scoped>
    .price-tag {
        padding: 10px 22px;
        color: #3C4242;
        font-weight: 700;
        background-color: #F6F6F6;
        border-radius: 8px;
        font-size: 18px;
        display: flex;
        align-items: center;
        gap: 25px;
    }
</style>