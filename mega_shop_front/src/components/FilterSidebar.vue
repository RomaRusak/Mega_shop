<template>
    <aside>
        <category-filters />
        <filter-checkboxes 
        filterKey="brands"
        />
        <filter-checkboxes 
        filterKey="colors"
        />
        <filter-checkboxes 
        filterKey="sizes"
        />
    </aside>
</template>

<script>
import store from '@/store';
import { mapActions } from 'vuex';
import CategoryFilters from './CategoryFilters.vue';
import FilterCheckboxes from './FilterCheckboxes.vue';

    export default {
        store,
        components: {
            'category-filters': CategoryFilters,
            'filter-checkboxes': FilterCheckboxes,
        },
        methods: {
            ...mapActions(['asyncFetchUniqFilterValues']),
        },
        mounted() {
            this.asyncFetchUniqFilterValues();
        }
    }
</script>