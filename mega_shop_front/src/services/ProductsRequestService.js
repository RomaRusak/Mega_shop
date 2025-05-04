class ProductsRequestService {
    static prepareRequest({filterParams, categorySlug}) {
        let baseEndPoint = 'http://mega_shop.com/api/products';
        
        if (categorySlug) {
            baseEndPoint = baseEndPoint + `/${categorySlug}`;
        }
        
        return `${baseEndPoint}?${filterParams}`;
    }
}

export default ProductsRequestService;