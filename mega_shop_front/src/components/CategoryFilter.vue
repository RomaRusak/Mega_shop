<template>
    <div>
        <ul class="categories-list">
            <li 
            v-for="category in getFilters('categories')" 
            :key="category.id"
            @click="categoryClickHandler(category)"
            :class="{
                'selected': category.isSelected,
                'categories-list__li': true
            }"
            >
                <p>{{ category.name }}</p>
            </li>
        </ul>
    </div>
</template>

<script>
import { useStore } from 'vuex';
import { useRouter, useRoute } from 'vue-router';
import { useGetFilters } from '@/compossables/useGetFilters';
    export default {
        setup() {
            const store = useStore();
            const router = useRouter();
            const route = useRoute();

            //computeds
            const { getFilters } = useGetFilters();
            
            //methods
            function categoryClickHandler(category) {
                const categorySlug = getCategorySlug(category.slug);

                router.push({ name: 'products', params: { categorySlug,}})
                store.commit('SET_CATEGORY', category.id);
            }

            function getCategorySlug(slug) {
                const existingCategorySlug = route.params.categorySlug;

                if (existingCategorySlug === slug) {
                    return ''
                }

                return slug;
            }

            return {
                getFilters,
                categoryClickHandler,
            }
        }
    }
</script>

<style scoped>
    .categories-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
        font-size: 16px;
    }

    .categories-list__li {
        cursor: pointer;
    }

    .selected {
       font-weight: bold;
    }
</style>