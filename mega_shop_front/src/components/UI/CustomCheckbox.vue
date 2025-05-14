<template>
    <div 
    :class="isChecked ? 'checked checkbox' : 'checkbox'"
    @click="$emit('checkboxChange')"
    >
    </div>
</template>

<script>

    export default {
        props: {
            isChecked: {
                type: Boolean,
                required: true,
            },
        },
        emits: ['checkboxChange'],
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