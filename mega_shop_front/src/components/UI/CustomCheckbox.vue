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
        height: 30px;
        width: 30px;
        border: 1px solid #BEBCBD;
        border-radius: 12px;
        position: relative;
    }

    .checkbox.checked::before {
        content: "";
        display: block;
        height: 20px;
        width: 20px;
        position: absolute;
        top: calc(50% - 10px);
        left: calc(50% - 10px);
        background-image: url('../../assets/check_icon.svg');
        background-position: center;
        background-size: cover;
    }
</style>