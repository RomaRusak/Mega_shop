<template>
     <div style="display: flex;">
        <img 
        :style=starStyles 
        :src="starLeftPartActive"
        >
        <img
        v-if="isFullStar"
        :style=starStyles
        :src=starRightPartActive
        >
    </div>
</template>

<script>
import starLeftPartActive from '@/assets/starLeftActive.png'
import starRightPartActive from '@/assets/starRightActive.png';
import { computed } from 'vue';
    export default {
        props: {
            isFullStar: {
                type: Boolean,
                required: true,
            },

            starSize: {
                type: Number,
                default: 25,
            }
        },

        setup(props) {
            const starStyles = computed(() => ({height: `${props.starSize}px`, width: `${props.starSize}px`}));

            return {
                starLeftPartActive,
                starRightPartActive,
                starStyles,
            }
        }
    }
</script>