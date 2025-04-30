<template>
    <div>
        {{ JSON.stringify(getProducts) }}
    </div>
</template>

<script>
import store from '@/store';
import { mapGetters } from 'vuex';
import { mapActions } from 'vuex';

    export default {
        store,
        computed: {
            ...mapGetters(['getProducts']),
        },
        methods: {
            ...mapActions(['asyncFetchProductsData']),
        },
        mounted() {
            this.asyncFetchProductsData()
        }
    }
</script>

<style scoped>
    .gold {
        background-color: gold;
    }
</style>