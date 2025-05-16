<template>
    <div class="product-variant-filters__wrapper">
        <h2>{{ title }}</h2>
        <ul class="product-variant-filters__list">
            <li 
            v-for="(checkboxData, idx) in checkboxes"
            :key="idx"
            class="product-variant-filters__li"
            >
            <div
            :class="{
                'checkbox-wrapper': true,
                'disabled': checkboxData.isDisabled
            }"
            >
                <input 
                style="display: none;"
                type="checkbox" 
                :id="checkboxData.value"
                :checked="checkboxData.isChecked" 
                :disabled="checkboxData.isDisabled"
                @click.prevent="$emit('checkboxChange', {selectedValue: checkboxData.value, filtersKey,})"
                >
                <custom-checkbox 
                :isChecked="checkboxData.isChecked"
                :isDisabled="checkboxData.isDisabled"
                @checkboxChange="$emit('checkboxChange', {selectedValue: checkboxData.value, filtersKey,})"
                />
                <label 
                :for="checkboxData.value"
                >
                    {{ checkboxData.value }}
                </label>
            </div>
            </li>
        </ul>
    </div>
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

<style scoped>
    .product-variant-filters__wrapper {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .product-variant-filters__list {
        display: flex;
        align-items: center;
        gap: 30px;
    }

    .product-variant-filters__li {
        min-width: 90px;
    }

    .checkbox-wrapper {
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
    }

    .disabled {
        opacity: 0.5; 
        cursor: not-allowed; 
    }
</style>