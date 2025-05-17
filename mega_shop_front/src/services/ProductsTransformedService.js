class ProductsTransformedService {

    static prepareProdVarsGallery(products) {
        return products.map(product => {
            return {...product, product_variants: product.product_variants.map(variant => {
              return {...variant, gallery: {...variant.gallery, image_paths: JSON.parse(variant.gallery.image_paths)}};
            })}
          });
    }

    static prepareProductsData(products) {
        const transformedProducts = this.prepareProdVarsGallery(products);
        
        return transformedProducts;
    }
}

export default ProductsTransformedService;