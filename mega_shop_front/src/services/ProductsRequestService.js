class ProductsRequestService {
    static prepareRequest(params) {
        let baseEndPoint = 'http://mega_shop.com/api/products';

        if (!params) {
            return baseEndPoint;
        }

        const {filterParams, categorySlug} = params
        
        if (categorySlug) {
            baseEndPoint = baseEndPoint + `/${categorySlug}`;
        }
        
        return `${baseEndPoint}?${filterParams}`;
    }
}

export default ProductsRequestService;