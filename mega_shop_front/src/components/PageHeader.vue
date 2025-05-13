<template>
    <header class="header">
        <div class="header__nav-wrapper">
            <div class="logo-wrapper">
                <router-link to="/">
                    <img :src="headerLogo">
                </router-link>
            </div>
            <nav class="nav-list">
                <li 
                v-for="(link,idx) in navLinks"
                :key="idx"
                >
                    <router-link 
                    :to="link.href"
                    :class="{ 
                        active: isActive(link.name),
                        'nav-link': true,
                    }"
                    >
                        {{ link.text }}
                    </router-link>
                </li>
            </nav>
        </div>
    </header>
</template>

<script>
import headerLogo from '@/assets/header_logo.svg'
import { ref } from 'vue';
import { useRoute } from 'vue-router';
    export default {
        setup() {
            const navLinks = ref([
                {text: 'Home', href: '/', name: 'home'},
                {text: 'Products', href: '/products', name: 'products'},
            ]);

            const route = useRoute();

            const isActive = (name) => route.name === name;

            return {
                headerLogo,
                navLinks,
                isActive,
            }
        }
    }
</script>

<style scoped>
    .header {
        padding: 31px 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #BEBCBD;
        box-shadow: 1px 1px 4px #BEBCBD;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        background-color: #F6F6F6;
        z-index: 9999;
    }

    .nav-list {
        display: flex;
        align-items: center;
        list-style: none;
        gap: 40px;
    }

    .header__nav-wrapper {
        display: flex;
        align-items: center;
        gap: 88px;
        width: 100%;
        max-width: 1200px;
        overflow: hidden;
        margin: 0 auto;
    }

    .nav-link {
        text-decoration: none;
        font-size: 22px;
        font-weight: 500;
        color: #807D7E;
        transition: all .3s ease;
    }

    .active {
        font-weight: 700;
        color: #3C4242;
    }
</style>