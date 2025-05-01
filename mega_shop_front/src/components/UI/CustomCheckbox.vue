<template>
    <div 
    :class="isChecked ? 'checked checkbox' : 'checkbox'"
    @click="HANDLE_CHECKBOX_CHANGE({key: filterKey, id: id})"
    >
    </div>
</template>

<script>
import store from '@/store';
import { mapMutations } from 'vuex';
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
        store,
        methods: {
            ...mapMutations(['HANDLE_CHECKBOX_CHANGE']),
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