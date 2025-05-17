<template>
    <div 
    :class="isChecked ? 'checked checkbox' : 'checkbox'"
    @click="handleClick"
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
            isDisabled: {
                type: Boolean,
                default: false,
            }
        },
        emits: ['checkboxChange'],

        setup(props, {emit}) {
            const handleClick = () => {
                if (!props.isDisabled) {
                    emit('checkboxChange');
                }
            }
            
            return {
                handleClick,
            }
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