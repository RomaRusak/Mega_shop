<template>
    <div class="product-variant-gallery-wrapper">
        <div class="product-variant-all">
            <div 
            v-for="(imgData, idx) in allImages"
            :key="idx"
            :class="{
                'product-variant-all__image-wrapper': true,
                'product-vatinat-all--active': imgData.isShownAsMainImage
            }"
            @click="$emit('changeMainImage', imgData.image)"
            >
                <img 
                class="product-variant-all__image"
                :src="require(`@/assets/${imgData.image}`)"
                >
            </div>
        </div>
        <div class="product-variant-main">
            <img 
            class="product-variant-main__image"
            v-if="mainImageSrc"
            :src="require(`@/assets/${mainImageSrc}`)"
            >
        </div>
    </div>
</template>

<script>
import { computed } from 'vue';
    export default {
        props: {
            prodVarGallery: {
                type: Object,
            }
        },
        
        emits: ['changeMainImage'],

        setup(props) {
            const allImages = computed(() => props.prodVarGallery.image_paths);
            const mainImageSrc = computed(() => {
                const mainImageData = props.prodVarGallery.image_paths.find(imgData => imgData.isShownAsMainImage);
                return mainImageData ? mainImageData.image : '';
            });

            return {
                allImages,
                mainImageSrc,
            }
        }
    }
</script>

<style scoped>
    .product-variant-gallery-wrapper {
        display: grid;
        grid-template-columns: 1fr 2fr;
        grid-column-gap: 10px;
    }

    .product-variant-all {
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 10px;
    }

    .product-variant-all__image {
        height: 100%;
        width: 100%;
        border-radius: 12.1px;
        overflow: hidden;
    }

    .product-variant-main__image {
        min-height: 650px;
        width: 100%;
    }

    .product-variant-all__image-wrapper {
        padding: 4px;
        height: 95px;
        width: 95px;
        border-radius: 12.1px;
        overflow: hidden;
        cursor: pointer;
    }

    .product-vatinat-all--active {
        border: 2px solid #3C4242;
    }
</style>