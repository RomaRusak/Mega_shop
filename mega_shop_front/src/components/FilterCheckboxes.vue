<template>
    <div>
        <ul class="checkboxes-list">
            <li
            v-for="filt in getFilters(filterKey)"
            :key="filt.id"
            >
            <div style="display: flex; gap: 15px; align-items: center;">
                <input 
                style="display: none;"
                type="checkbox" 
                :id="filt.name"
                :checked="filt.isChecked" 
                @click.prevent="handleCheckboxChange({key: filterKey, id: filt.id})"
                >
                <custom-checkbox 
                :isChecked="filt.isChecked"
                @checkboxChange="handleCheckboxChange({key: filterKey, id: filt.id})"
                />
                <label :for="filt.name">{{ filt.name }}</label>
            </div>
            </li>
        </ul>
    </div>
</template>

<script>
import { useStore } from 'vuex';
import CustomCheckbox from './UI/CustomCheckbox.vue';
import { useGetFilters } from '@/compossables/useGetFilters';
    export default {
        props: {
            filterKey: {
                type: String,
                required: true,
            },

            title: {
                type: String,
                default: '',
            },
        },
        components: {'custom-checkbox': CustomCheckbox},
        setup() {
            const store = useStore();
            
            //computeds
            const {getFilters} = useGetFilters();

            //methods
            function handleCheckboxChange(payload) {
                store.commit('HANDLE_CHECKBOX_CHANGE', payload);
            }

            return {
                getFilters,
                handleCheckboxChange,
            }
        }
    }
</script>

<style scoped>
    .checkboxes-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
        font-size: 16px;
    }
</style>