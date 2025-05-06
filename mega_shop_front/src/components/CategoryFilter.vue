<template>
    <div>
        <p>Categories</p>
        <ul>
            <li 
            v-for="category in getFilters('categories')" 
            :key="category.id"
            @click="categoryClickHandler(category)"
            :class="{ 'selected': category.isSelected }"
            >
                <!-- <router-link :to="'/products/' + category.slug">{{ category.name }}</router-link> -->
                <p>{{ category.slug }}</p>
            </li>
        </ul>
    </div>
</template>

<script>
import store from '@/store';
import { mapGetters, mapMutations } from 'vuex';
    export default {
        store,
        computed: {
            ...mapGetters(['getFilters']),
        },
        methods: {
            ...mapMutations(['SET_CATEGORY']),

            categoryClickHandler(category) {
                const categorySlug = this.getCategorySlug(category.slug);

                this.$router.push({ name: 'products', params: { categorySlug,}})
                this.SET_CATEGORY(category.id);
            },

            getCategorySlug(slug) {
                const existingCategorySlug = this.$route.params.categorySlug;

                if (existingCategorySlug === slug) {
                    return ''
                }

                return slug;
            }
        },
    }
</script>

<style scoped>
    .selected {
        background-color: orange;
    }
</style>