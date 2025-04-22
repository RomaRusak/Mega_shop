<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class ShowProductsRequest extends FormRequest
{

    private $rules = [
        'productSlug'  => ['required', 'string', 'exists:products,slug'],
        'categorySlug' => ['required', 'string', 'exists:categories,slug'],
    ];

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    private function getParamsFromUrlPath(array $paramsArr): array
    {   
        $requestParams = ['categorySlug' => null, 'productSlug' => null];
        $productSlugRegExpPattern = '/^[a-zA-Z0-9-_]+-\d+$/';

        foreach($paramsArr as $key => $param) {
            if (preg_match($productSlugRegExpPattern, $param)) {
               $requestParams['productSlug'] = $param;
               $previousKey = $key - 1;

               if (array_key_exists($previousKey, $paramsArr)) {
                    $requestParams['categorySlug'] = $paramsArr[$previousKey];
               }
            }
        }

        return $requestParams;
    }

    protected function prepareForValidation(): void
    {
        $basePaths   = 'api/products/';
        [
            'requestPath'      => $requestPath,
            'basePathPosition' => $basePathPosition,
        ] = $this->getRequestPathData('api/products/');

        $params        = substr($requestPath, $basePathPosition + strlen($basePaths));
        $paramsArr     = explode('/', $params);
        $urlPathParams = $this->getParamsFromUrlPath($paramsArr);

        $productSlug  = $urlPathParams['productSlug'];
        $categorySlug = $urlPathParams['categorySlug'];

        $this->merge([
            'productSlug' => $productSlug,
            'categorySlug'=> $categorySlug,
        ]);
    }

    public function rules(Request $request): array
    {
        $categorySlug = $this->categorySlug;

        $rules= ['productSlug' => implode('|', $this->rules['productSlug'])];

        if (isset($categorySlug)) {
            $rules['categorySlug'] = implode('|', $this->rules['categorySlug']);
        }

        return $rules;
    }

    protected function failedValidation(Validator $validator) {
        $errors = $validator->errors();

        throw new ValidationException($validator, response()->json([
            'errors'  => $errors->toArray(),
        ], 422));
    }
}
