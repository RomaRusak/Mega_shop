<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Validation\Rule;

class IndexProductsRequest extends FormRequest
{
    private $requestData = [
        'color'              => [
            'defaultValue' => [],
            'requestRules' => ['nullable', 'string_or_array'],
            'requiredType' => 'array',
        ],
        'size'               => [
            'defaultValue' => [],
            'requestRules' => ['nullable', 'string_or_array'],
            'requiredType' => 'array',
        ],
        'min_price'          => [
            'defaultValue' => null,
            'requestRules' => ['nullable', 'numeric'],
            'requiredType' => 'float',
        ],
        'max_price'          => [
            'defaultValue' => null,
            'requestRules' => ['nullable', 'numeric'],
            'requiredType' => 'float',
        ],
        'page'               => [
            'defaultValue' => 1,
            'requestRules' => ['nullable', 'numeric'],
            'requiredType' => 'integer',
        ],
        'products_per_page'  => [
            'defaultValue' => 20,
            'requestRules' => ['nullable', 'numeric'],
            'requiredType' => 'integer',
        ],
        'brand'              => [
            'defaultValue' => [],
            'requestRules' => ['nullable', 'string_or_array'],
            'requiredType' => 'array',
        ],
        'category'           => [
            'defaultValue' => null,
            'requestRules' => ['nullable', 'string'],
            'requiredType' => 'string',
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
        $rules = [];

        foreach($this->requestData as $paramName => $paramData) {
            $rules[$paramName] = implode('|', $paramData['requestRules']);
        }

        return $rules;
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
