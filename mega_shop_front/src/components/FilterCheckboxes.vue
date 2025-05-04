<template>
    <div>
        <p>{{title}}</p>
        <ul style="display: flex; flex-direction: column; gap: 5px;">
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
                @click.prevent="HANDLE_CHECKBOX_CHANGE({key: filterKey, id: filt.id})"
                >
                <custom-checkbox 
                :isChecked="filt.isChecked"
                :filterKey = "filterKey"
                :id="filt.id"
                />
                <label :for="filt.name">{{ filt.name }}</label>
            </div>
            </li>
        </ul>
    </div>
</template>

<script>
import store from '@/store';
import CustomCheckbox from './UI/CustomCheckbox.vue';
import { mapGetters, mapMutations } from 'vuex';
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
        store,
        components: {'custom-checkbox': CustomCheckbox},
        computed: {
            ...mapGetters(['getFilters']),
        },
        methods: {
            ...mapMutations(['HANDLE_CHECKBOX_CHANGE']),
        },
    }
</script>