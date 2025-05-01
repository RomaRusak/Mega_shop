<template>
    <div class="products-wrapper">
        <!-- {{ JSON.stringify(this.getProducts) }} -->
        <filter-sidebar />
    </div>
</template>

<script>
import store from '@/store';
import { mapGetters } from 'vuex';
import { mapActions } from 'vuex';
import FilterSidebar from './FilterSidebar.vue';

    export default {
        store,
        components: {'filter-sidebar': FilterSidebar},
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

    .products-wrapper {
        display: grid;
        grid-template-columns: 300px 1fr;
    }
</style>