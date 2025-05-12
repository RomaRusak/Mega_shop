<template>
    <div class="price-filter-wrapper">
        <p>{{ title }}</p>
        <div style="display: flex; flex-direction: column; align-items: flex-start;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <span>{{ minProductPrice }}</span>
                <input 
                class="price-input my-range"
                type="range" 
                :min="minProductPrice"
                :max="maxProductPrice" 
                step="1" 
                :value="selectedPrice"
                @input="setPrice({
                    selectedPrice: $event.target.value,
                    key: filterKey,
                    })"
                >
                <span>{{ maxProductPrice }}</span>
            </div>
        </div>
        <div>
            <p>Selected  {{title}}: <span class="bold">{{ selectedPrice }}</span></p>
        </div>
    </div>
</template>

<script>
import { useStore } from 'vuex';
import { computed } from 'vue';
import { useGetFilters } from '@/compossables/useGetFilters';
    export default {
        props: {
            title: {
                type: String,
                default: '',
            },
            filterKey: {
                type: String,
                required: true,
            },
        },
        setup(props) {
            const store = useStore();

            // computeds
            const {getFilters} = useGetFilters();
            const maxProductPrice = computed(() => getFilters.value('maxProductPrice'));
            const minProductPrice = computed(() => getFilters.value('minProductPrice'));
            const selectedPrice   = computed(() => getFilters.value(props.filterKey));

            //methods
            function setPrice(payload) {
                store.commit('SET_PRICE', payload);
            }

            return {
                maxProductPrice,
                minProductPrice,
                selectedPrice,
                setPrice,
            };
        }
    }
</script>

<style scoped>
    .price-filter-wrapper {
        font-size: 16px;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .bold {
        font-weight: bold;
    }

    .price-input {
        cursor: pointer;
    }

    .my-range {
        -webkit-appearance: none;
        width: 100%;
        height: 8px; 
        background: #ddd; 
        border-radius: 5px; 
        outline: none; 
    }

    .my-range::-webkit-slider-thumb {
        -webkit-appearance: none; 
        appearance: none;
        width: 18px; 
        height: 18px; 
        background: #808080; 
        border-radius: 50%; 
        cursor: pointer;
    }
</style>