<template>
  <swiper 
  :modules="modules" 
  :slides-per-view="1" 
  navigation 
  :loop="true" 
  :pagination="{ clickable: true }"
  >
    <swiper-slide 
    v-for="(review, idx) in reviews"
    :key="idx"
    >
    <div class="slide-wrapper">
      <header class="slider__header">
        <div style="display: flex; gap: 10px;">
          <span class="slider__user-name">{{getUser(review.id)}}</span>
          <span class="slider__review-date">{{ gerReviewDate(review.id) }}</span>
        </div>
        <product-rating :rating="getRating(review.id)"/>
      </header>
      <div class="slide__content">
        <p>{{ gerReviewText(review.id) }}</p>
      </div>
    </div>
    </swiper-slide>
  </swiper>
</template>
<script>
import { Navigation, Pagination, A11y } from 'swiper/modules';
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import { computed } from 'vue';
import ProductRating from './ProductRating.vue';

  export default {
    props: {
      reviews: {
        type: Array,
        default: () => [],
      }
    },

    components: {
      Swiper,
      SwiperSlide,
      'product-rating': ProductRating,
    },
    setup(props) {

      //computeds
      const getUser = computed(() => (id) => {
        return findReviewById(id).user.name;
      });

      const getRating = computed(() => (id) => {
        return findReviewById(id).rating;
      });

      const gerReviewText = computed(() => (id) => {
        return findReviewById(id).review_text;
      });

      const gerReviewDate = computed(() => (id) => {
        const reviewDate = findReviewById(id).review_date;
        
        return new Date(reviewDate).toCustomFormat();
      });

      //methods
      function findReviewById(id) {
        return props.reviews.find(reviews => reviews.id === id);
      }

      return {
        getUser,
        getRating,
        gerReviewText,
        gerReviewDate,
        modules: [Navigation, Pagination, A11y],
      };
    },
  };
</script>

<style scoped>
  .slide-wrapper {
    min-height: 200px;
    cursor: pointer;
    display: flex;
    flex-direction: column;
    gap: 12px;
  }

  .slider__header {
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .slider__user-name {
    font-weight: 600;
    color: #3C4242;
    font-size: 18px;
  }

  .slide__content {
    padding: 20px;
  }

  .slide__content > p {
    text-indent: 2rem;
    text-align: justify;
  }
</style>