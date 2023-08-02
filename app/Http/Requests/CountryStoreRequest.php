<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CountryStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'country' => [
                'required', Rule::unique('countries')->ignore($this->id)
            ],
            'population' => [
                'required', 
            ],
            'flag'  => [
                'required',  'string'
            ],
            'timezone' => 'required|string|max:255',
        ];
    }
}
