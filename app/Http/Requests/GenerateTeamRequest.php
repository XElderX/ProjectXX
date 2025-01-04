<?php

namespace App\Http\Requests;

use App\Models\Player;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\RequiredIf;

class GenerateTeamRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'user_id'    => 'nullable|string|numeric|exists:users,id',
            'title'      => ['required', 'string', 'min:2', 'max:25'],
            'country_id' => 'required|string|numeric|exists:countries,id',
            'town_id'    => 'nullable|string|numeric|exists:towns,id',
        ];
    }
}
