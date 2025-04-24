<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class ProductsIndexRequest extends FormRequest
{
    private $requestData = [
        'color'              => [
            'defaultValue' => [],
            'rules'        => ['nullable', 'string_or_array'],
            'requiredType' => 'array',
        ],
        'size'               => [
            'defaultValue' => [],
            'rules'        => ['nullable', 'string_or_array'],
            'requiredType' => 'array',
        ],
        'min_price'          => [
            'defaultValue' => null,
            'rules'        => ['nullable', 'numeric'],
            'requiredType' => 'float',
        ],
        'max_price'          => [
            'defaultValue' => null,
            'rules'        => ['nullable', 'numeric'],
            'requiredType' => 'float',
        ],
        'page'               => [
            'defaultValue' => 1,
            'rules'        => ['nullable', 'numeric'],
            'requiredType' => 'integer',
        ],
        'products_per_page'  => [
            'defaultValue' => 5,
            'rules'        => ['nullable', 'numeric'],
            'requiredType' => 'integer',
        ],
        'brand'              => [
            'defaultValue' => [],
            'rules'        => ['nullable', 'string_or_array'],
            'requiredType' => 'array',
        ],
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

    public function rules(): array
    {
        foreach($this->requestData as $paramName => $paramData) {
            $rules[$paramName] = implode('|', $paramData['rules']);
        }
        
        return $rules;
    }

    protected function failedValidation(Validator $validator) {
        $errors = $validator->errors();

        throw new ValidationException($validator, response()->json([
            'errors'  => $errors->toArray(),
        ], 422));
    }

    private function convertToReqType(mixed $value, string $requiredType)
    {
        switch($requiredType) {
            case 'array':
                return (array) $value;
            case 'string':
                return (string) $value;
            case 'integer':
                return (integer) $value;
            case 'float':
                return (float) $value;
        }
    }

    protected function passedValidation(): void
    {   
        $transfomedRequestParams = [];
        $allRequestParams        = array_keys($this->requestData);
        
        foreach($allRequestParams  as $requestParam) {

            $currentParamValue     = $this->$requestParam;
            $currentParamData      = $this->requestData[$requestParam];
            
            if (!isset($currentParamValue)) {
                $transfomedRequestParams[$requestParam] = $currentParamData['defaultValue'];
                continue;
            }
            
            $requiredType   = $currentParamData['requiredType'];
            $isRequiredType = gettype($currentParamValue) === $requiredType;
            
            if (!$isRequiredType) {
                $currentParamValue = $this->convertToReqType($currentParamValue, $requiredType);
            }

            $transfomedRequestParams[$requestParam] = $currentParamValue;
        }

        $this->merge($transfomedRequestParams);
    }
}
