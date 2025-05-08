<template>
    <div 
    :class="paginationItemClass"
    @click="$emit('click', {page: pageNumber})"
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
        emits: ['click'],
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
        border: 1px solid black;
        cursor: pointer;
    }

    .page-number-wrapper.selected-page {
        background-color: green;
    }
</style>