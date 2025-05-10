<template>
    <div 
    :class="isChecked ? 'checked checkbox' : 'checkbox'"
    @click="hanldeCheckboxChange({key: filterKey, id: id})"
    >
    </div>
</template>

<script>
import { useStore } from 'vuex';

    export default {
        props: {
            isChecked: {
                type: Boolean,
                required: true,
            },
            filterKey: {
                type: String,
                required: true,
            },
            id: {
                type: Number,
                required: true,
            },
        },
        setup() {
            const store = useStore();

            //methods
            function hanldeCheckboxChange(payload) {
                store.commit('HANDLE_CHECKBOX_CHANGE', payload);
            }

            return {
                hanldeCheckboxChange,
            };
        }
    }
</script>

<style scoped>
    .checkbox {
        height: 20px;
        width: 20px;
        border: 1px solid black;
    }

    .checkbox.checked {
        background-color: green;
    }
</style>