<template>
    <div 
    :style="{ display: 'flex', justifyContent: 'center', alignItems: 'center', minHeight: `${starSize}px` }"
    >
        <rating-star-image 
        v-for="({isFullStar}, idx) in ratingDataArr"
        :key="idx"
        :isFullStar="isFullStar"
        :starSize="starSize"
        />
    </div>
</template>

<script>
import { computed } from 'vue';

import RatingStarImage from './RatingStarImage.vue';
    export default {
        props: {
            rating: {
                type: Number,
                required: true,
            },

            starSize: {
                type: Number,
                default: 25,
            }
        },

        components: {
            'rating-star-image': RatingStarImage,
        },

        setup(props) {
            const ratingDataArr = computed(() => {
                const roundedRating = Math.round(props.rating * 2) / 2;
                const isFullStarArr = [];

                for(let i = 0; i < roundedRating; i++ ) {
                    if (i === 0) continue;

                    if (!(i % 2 === 0)) {
                        isFullStarArr.push({isFullStar: true});
                        continue;
                    }

                    if (i +1 >= roundedRating) {
                        isFullStarArr.push({isFullStar: false});
                    }
                }

                return isFullStarArr;
            });

            return {
                ratingDataArr,
            };
        }
    }
</script>