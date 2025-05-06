<template>
    <aside>
        <category-filter />
        <filter-checkboxes 
        filterKey="brands"
        title="Brands"
        />
        <filter-checkboxes 
        filterKey="colors"
        title="Colors"
        />
        <filter-checkboxes 
        filterKey="sizes"
        title="Sizes"
        />
        <price-filter 
        title="Min price"
        filterKey="selectedMinPrice"
        />
        <price-filter 
        title="Max price"
        filterKey="selectedMaxPrice"
        />
    </aside>
</template>

<script>
import CategoryFilter from './CategoryFilter.vue';
import FilterCheckboxes from './FilterCheckboxes.vue';
import PriceFilter from './PriceFilter.vue';

    export default {
        components: {
            'category-filter': CategoryFilter,
            'filter-checkboxes': FilterCheckboxes,
            'price-filter': PriceFilter,
        },
    }
</script>