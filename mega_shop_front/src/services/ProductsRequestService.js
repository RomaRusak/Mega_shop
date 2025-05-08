class ProductsRequestService {
    static prepareRequest(params = this.parseURL()) {
        let baseEndPoint = 'http://mega_shop.com/api/products';

        const {filterParams, categorySlug} = params
        
        if (categorySlug) {
            baseEndPoint = baseEndPoint + `/${categorySlug}`;
        }
        
        return `${baseEndPoint}?${filterParams}`;
    }

    static parseURL() {
        const currentUrl = window.location.href;
        const params = {};

        const parsedUrl = new URL(currentUrl);
        const pathname = parsedUrl.pathname;

        params.categorySlug = pathname.split('/')[2] ?? '';
        params.filterParams = currentUrl.split('?')[1] ?? '';
        
        return params;
    }
}

export default ProductsRequestService;