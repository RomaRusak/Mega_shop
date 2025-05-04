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
                @input="SET_PRICE({
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
import store from '@/store';
import { mapGetters, mapMutations } from 'vuex';
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
        store,
        computed: {
            ...mapGetters(['getFilters']),
            maxProductPrice() {
                return this.getFilters('maxProductPrice');
            },
            minProductPrice() {
                return this.getFilters('minProductPrice');
            },
            selectedPrice() {
                return this.getFilters(this.filterKey);
            }
        },
        methods: {
            ...mapMutations(['SET_PRICE']),
        }
    }
</script>