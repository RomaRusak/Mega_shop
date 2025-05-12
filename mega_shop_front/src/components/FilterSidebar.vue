<template>
    <aside>
        <div class="fitlers-sidebar__wrapper">
            <div class="filter-item">
                <accordion-component 
                header="Categories:"
                :defaultIsOpen = "true"
                >
                    <template #body>
                        <category-filter />
                    </template>
                </accordion-component>
            </div>
            <div class="filter-item">
                <accordion-component
                header="Brands:"
                :defaultIsOpen = "false"
                >
                    <template #body>
                        <filter-checkboxes 
                        filterKey="brands"
                        title="Brands"
                        />
                    </template>
                </accordion-component>
            </div>
            <div class="filter-item">
                <accordion-component
                header="Colors:"
                :defaultIsOpen = "false"
                >
                    <template #body>
                        <filter-checkboxes 
                        filterKey="colors"
                        title="Colors"
                        />
                    </template>
                </accordion-component>
            </div>
            <div class="filter-item">
                <accordion-component
                header="Sizes:"
                :defaultIsOpen = "false"
                >
                    <template #body>
                        <filter-checkboxes 
                        filterKey="sizes"
                        title="Sizes"
                        />
                    </template>
                </accordion-component>
            </div>
            <div class="filter-item">
                <accordion-component 
                header="Price:"
                :defaultIsOpen = "true"
                >
                    <template #body>
                        <div style="display: flex; flex-direction: column; gap: 12px;">
                            <price-filter 
                            title="Min price"
                            filterKey="selectedMinPrice"
                            />
                            <price-filter 
                            title="Max price"
                            filterKey="selectedMaxPrice"
                            />
                        </div>
                    </template>
                </accordion-component>
            </div>
        </div>
    </aside>
</template>

<script>
import CategoryFilter from './CategoryFilter.vue';
import FilterCheckboxes from './FilterCheckboxes.vue';
import PriceFilter from './PriceFilter.vue';
import AccordionComponent from './UI/AccordionComponent.vue';

    export default {
        components: {
            'category-filter': CategoryFilter,
            'filter-checkboxes': FilterCheckboxes,
            'price-filter': PriceFilter,
            'accordion-component': AccordionComponent,
        },
    }
</script>

<style scoped>
    .fitlers-sidebar__wrapper {
        border: 1px solid #BEBCBD;
        border-radius: 2px;
        box-sizing: border-box;
        font-size: 16px;
        color: #3F4646;
    }

    .filter-item {
        padding: 20px;
        border-bottom: 1px solid #BEBCBD;
    }
</style>