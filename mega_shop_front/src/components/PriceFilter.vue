<template>
    <div>
        <p>{{ title }}</p>
        <div style="display: flex; flex-direction: column; align-items: center;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <span>{{ minProductPrice }}</span>
                <input 
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
            <div>
                <p>Selected  {{title}}: {{ selectedPrice }}</p>
            </div>
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