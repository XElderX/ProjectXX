<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TownStoreRequest extends FormRequest
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
            'town_name' => [
                'required', Rule::unique('towns')->ignore($this->id)
            ],
            'country_id' => [
                'required', 
            ],
            'population' => [
                'required', 
            ],
            'weather' => [
                'required', 
            ],
        ];
    }
}
