<template>
    <page-header />
    <div class="container">
        <router-view /> 
    </div>
</template>

<script>
import PageHeader from './PageHeader.vue';
    export default {
        components: {
            'page-header': PageHeader,
        }
    }
</script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Urbanist:ital,wght@0,100..900;1,100..900&display=swap');
    * {
        margin: 0;
        padding: 0;
    }

    *,
    *::before,
    *::after {
        box-sizing: border-box;
    }

    ul[class],
    ol[class] {
        padding: 0;
    }

    ul,
    ol {
        list-style: none;
    }

    input,
    button,
    textarea,
    select {
        font: inherit;
    }

    img {
        max-width: 100%;
        display: block;
    }

    body {
        font-family: 'Causten', sans-serif;
        min-height: 100vh;
        scroll-behavior: smooth;
        text-rendering: optimizeSpeed;
        line-height: 1.5;
    }

    .container {
        max-width: 1200px;
        overflow: hidden;
        margin: 0 auto;
        margin-top: 125px;
    }
</style>