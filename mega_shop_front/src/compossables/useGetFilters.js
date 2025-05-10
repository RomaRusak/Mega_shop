import { computed } from 'vue';
import { useStore } from 'vuex';

export function useGetFilters() {
    const store = useStore();

    const getFilters = computed(() => store.getters.getFilters);

    return {
        getFilters,
    };
}