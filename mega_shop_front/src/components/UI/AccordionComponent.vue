<template>
    <div class="accordion-item">
        <div :class="isOpen ? 'accordion-header active' : 'accordion-header'" @click="toggle">
            <span>
                {{header}}
            </span>
            <img 
            class="accordion-header__icon" 
            :src="arrowIcon"
            >
        </div>
        <div class="accordion-body">
            <slot name="body"></slot>
        </div>
  </div>
</template>

<script>
import { ref } from 'vue';
import arrowIcon from '@/assets/arrow_icon.svg';

    export default {
        props: {
            header: {
                type: String,
                required: true
            },
            defaultIsOpen: {
                type: Boolean,
                default: false,
            }
        },
        setup(props) {
            const isOpen = ref(props.defaultIsOpen);

            const toggle = () => {
                isOpen.value = !isOpen.value;
            };

            return {
                isOpen,
                toggle,
                arrowIcon,
            };
        }
    }
</script>

<style scoped>
    .accordion-item {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .accordion-header {
        cursor: pointer;
        padding: 10px;
        border: 1px solid #ddd;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .accordion-header__icon {
        transition: all 0.4s ease; 
        transform: rotate(180deg);
    }

    .active .accordion-header__icon {
        transform: rotate(0);
    }

    .active + .accordion-body {
        max-height: 500px;
    }

    .accordion-body {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s ease-out; 
    }
</style>