<template>
    <div>
        <p>Categories</p>
        <ul>
            <li 
            v-for="category in getFilters('categories')" 
            :key="category.id"
            @click="SELECT_CATEGORY(category.id)"
            :class="{ 'selected': category.isSelected }"
            >
                <router-link :to="'/products/' + category.slug">{{ category.name }}</router-link>
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
            ...mapMutations(['SELECT_CATEGORY']),
        },
    }
</script>

<style scoped>
    .selected {
        background-color: orange;
    }
</style>