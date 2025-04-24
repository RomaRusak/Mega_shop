<?php

namespace App\Http\Services;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class ProductsValidationService {

    public function validate(array $validatedParams)
    {
        $validationRules = [
            'categorySlug' => [
                'required',
                'string',
                Rule::exists('categories', 'slug')
            ],
            'productSlug' => [
                'required',
                'string',
                Rule::exists('products', 'slug')
            ],
        ];

        $validatorData  = [];
        $validatorRules = [];
        
        foreach($validatedParams as $key => $validatedParam) {
            if (array_key_exists($key, $validationRules)) {
                $validatorData[$key] = $validatedParam;
                $validatorRules[$key] = $validationRules[$key];
            }
        }

        return Validator::make($validatorData, $validatorRules);
    }


}