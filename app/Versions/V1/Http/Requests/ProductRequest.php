<?php

namespace App\Versions\V1\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read string $name
 * @property-read string $description
 * @property-read integer $amount
 * @property-read integer $price
 * @property-read integer $new_price
 */
class ProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:50'],
            'description' => ['nullable', 'string', 'max:625'],
            'amount' => ['required', 'integer', 'nullable'],
            'price' => ['required', 'integer', 'min:0'],
            'new_price' => ['nullable', 'integer', 'before:price'],
            'image.*' => ['nullable', 'image']
        ];
    }
}
