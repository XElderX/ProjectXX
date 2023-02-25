<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SurnameStoreRequest extends FormRequest
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
        $request = $this->request;

        return [
            'surname' => [
                'required', Rule::unique('surnames')->where(fn ($query) => $query->where('country_id', $request->get('country_id')))->ignore($this->id)
            ],
            'country_id' => [
                'required', 'exists:countries,id'
            ],
            'popularity' => [
                'required', 'integer', 'min:1', 'max:10'
            ]
        ];
    }
}
