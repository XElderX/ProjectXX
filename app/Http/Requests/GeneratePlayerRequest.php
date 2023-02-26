<?php

namespace App\Http\Requests;

use App\Models\Player;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'country_id' => 'nullable|string|numeric|exists:countries,id',
            'club_id'    => 'nullable|string|numeric|exists:clubs,id',
            'age'        => ['nullable','string','numeric', 'regex:/^(1[4-9]|[2-4][0-9]|50)$/'],
            'position'   => ['nullable', Rule::in(Player::PLAYER_POSITIONS)]
        ];
    }
}
