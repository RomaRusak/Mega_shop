class ProductsTransformedService {
    static findMaxDiscountPercent(discounts) {
        if (!discounts.length) {
            return 0;
        }

        return Math.max(...discounts.map(({discount_percent}) => +discount_percent));
    }

    static getPriceWithDiscount(price, maxDiscountPercent) {
        if (maxDiscountPercent === 0) {
            return price;
        }
        
        const transformedPrice = +price;
        const discountAmount = (transformedPrice * maxDiscountPercent) / 100;
        return (transformedPrice - discountAmount).toFixed(2);
    }

    static prepareProductsData({products}) {
        const preparedProducts = products.map(product => {
            const {product_variants} = product;
            
            const updatedProductVariants = product_variants.map(prodVar => {
                const maxDiscountPercent = ProductsTransformedService.findMaxDiscountPercent(prodVar.discounts);
                const priceWithDiscount  = ProductsTransformedService.getPriceWithDiscount(prodVar.price, maxDiscountPercent);
                
                return {...prodVar, maxDiscountPercent, priceWithDiscount};
            });

            return {...product, product_variants: updatedProductVariants};
        });
        return preparedProducts;
    }
}

export default ProductsTransformedService;