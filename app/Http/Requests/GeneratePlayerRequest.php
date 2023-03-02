<?php

namespace App\Http\Requests;

use App\Models\Player;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\RequiredIf;

class GeneratePlayerRequest extends FormRequest
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
            'type'       => ['required', 'string', 'numeric', 'regex:/^([1-4])$/'],
            'quality'    => [ Rule::requiredIf(request()->type == 2),
                "string", 'numeric', 'regex:/^([1-9]|[1-8][0-9]|9[0-9]|100)$/'
            ],
            'country_id' => 'nullable|string|numeric|exists:countries,id',
            'club_id'    => 'nullable|string|numeric|exists:clubs,id',
            'age'        =>  ($this->type === '1') 
                ? ['nullable','string','numeric', 'regex:/^(1[4-9]|[2-4][0-9]|50)$/']
                : (($this->type === '2') 
                    ? ['nullable','string','numeric', 'regex:/^(1[4-9]|20)$/']  
                    : ['nullable','string','numeric', 'regex:/^(2[89]|[3-7][0-9]|80)$/']),
           
            'position'   => ['nullable', Rule::in(Player::PLAYER_POSITIONS)]
        ];
    }
}
