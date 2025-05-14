<template>
    <h2>{{ title }}</h2>
    <ul>
        <li 
        v-for="(checkboxData, idx) in checkboxes"
        :key="idx"
        >
        <div style="display: flex; align-items: center; gap: 10px;">
            <input 
            style="display: none;"
            type="checkbox" 
            :id="checkboxData.value"
            :checked="checkboxData.isChecked" 
            @click.prevent="$emit('checkboxChange', {selectedValue: checkboxData.value, filtersKey, checkedStatus: checkboxData.isChecked})"
            >
            <custom-checkbox 
            :isChecked="checkboxData.isChecked"
            @checkboxChange="$emit('checkboxChange', {selectedValue: checkboxData.value, filtersKey, checkedStatus: checkboxData.isChecked})"
            />
            <label 
            :for="checkboxData.value"
            >
                {{ checkboxData.value }}
            </label>
        </div>
        </li>
    </ul>
</template>

<script>
import CustomCheckbox from './UI/CustomCheckbox.vue';
    export default {
        props: {
            checkboxes: {
                type: Array,
                required: true,
            },

            filtersKey: {
                type: String,
                required: true,
            },

            title: {
                type: String,
                default: '',
            }
        },

        emits: ['checkboxChange'],

        components: {
            'custom-checkbox': CustomCheckbox
        },

        setup() {

        }
    }
</script>