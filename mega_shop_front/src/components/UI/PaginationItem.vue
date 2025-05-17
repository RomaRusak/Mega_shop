<template>
    <div 
    :class="paginationItemClass"
    @click="$emit('clickPaginateItem', {page: pageNumber})"
    >
        <span>{{ pageNumber }}</span>
    </div>
</template>

<script>
import { computed } from 'vue';
    export default {
        props: {
            pageNumber: {
                required: true,
            },
            isSelected: {
                required: true,
                type: Boolean,
            }
        },
        emits: ['clickPaginateItem'],
        setup(props) {
            //computeds
            const paginationItemClass = computed(() => {
                return props.isSelected ? 'page-number-wrapper selected-page' : 'page-number-wrapper';
            });

            return {
                paginationItemClass,
            }
        }
    }
</script>

<style scoped>
    .page-number-wrapper {
        padding: 10px;
        box-shadow: 2px 2px 4px black;
        cursor: pointer;
    }

    .page-number-wrapper.selected-page {
        background-color: #ddd;
    }
</style>