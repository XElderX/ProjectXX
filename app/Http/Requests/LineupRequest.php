<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LineupRequest extends FormRequest
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


            'players'   => ['required', 'array','min:3'],
            'players.*' =>  ['nullable', 'numeric', Rule::exists('players', 'id')],     // each string must have min 3 chars,
            'positions'   => ['required', 'array','min:3'],
            'positions.*' => ['nullable','string' ]
        ];
    }

}
