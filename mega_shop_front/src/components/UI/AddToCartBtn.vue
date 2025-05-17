<template>
    <button class="cart-add-button">
        <img :src="cartIcon">
        <span>Add to cart</span>
    </button>
</template>

<script>
import cartIcon from '@/assets/cart_icon.svg'
    export default {
        setup() {
            return {
                cartIcon,
            }
        }
    }
</script>

<style scoped>
    .cart-add-button {
        padding: 10px 22px;
        color: #3C4242;
        font-weight: 500;
        background-color: #8A33FD;
        border-radius: 8px;
        font-size: 18px;
        display: flex;
        align-items: center;
        gap: 25px;
        border: none;
        color: #FFFFFF;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 12px;
    }


</style>