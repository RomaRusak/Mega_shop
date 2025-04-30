<template>
    <h1>{{JSON.stringify(getProducts)}}</h1>
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