<?php

namespace App\Http\Requests;

use App\Models\Club;
use App\Models\Country;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PlayerStoreRequest extends FormRequest
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

            'first_name'  => ['required', 'string', 'min:3', 'max:45'],
            'last_name'   => ['required', 'string', 'min:3', 'max:45'],
            'value'       => ['nullable', 'integer'],
            'salary'      => ['nullable', 'integer'],
            'height'      => ['required', 'integer'],
            'weight'      => ['required', 'integer'],
            'age'         => ['required', 'integer'],
            'potential'   => ['nullable', 'integer'],
            'bookings'    => ['nullable', 'integer'],
            'injury_days' => ['nullable', 'integer'],
            'fatigue'     => ['nullable', 'integer'],
            'position'    => ['nullable'],
    
            'gk'      => ['required', 'numeric', 'regex:/^\d+(\.\d{1,3})?$/', 'min:0', 'max:26'],//0
            'def'     => ['required', 'numeric', 'regex:/^\d+(\.\d{1,3})?$/', 'min:0', 'max:26'],//1
            'pm'      => ['required', 'numeric', 'regex:/^\d+(\.\d{1,3})?$/', 'min:0', 'max:26'],//2
            'pace'    => ['required', 'numeric', 'regex:/^\d+(\.\d{1,3})?$/', 'min:0', 'max:26'],//3
            'tech'    => ['required', 'numeric', 'regex:/^\d+(\.\d{1,3})?$/', 'min:0', 'max:26'],//4
            'pass'    => ['required', 'numeric', 'regex:/^\d+(\.\d{1,3})?$/', 'min:0', 'max:26'],//5
            'heading' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,3})?$/', 'min:0', 'max:26'],//6
            'str'     => ['required', 'numeric', 'regex:/^\d+(\.\d{1,3})?$/', 'min:0', 'max:26'],//7
            
            'stamina'    => ['required', 'numeric', 'regex:/^\d+(\.\d{1,3})?$/', 'min:0', 'max:26'],//8
            'exp'        => ['required', 'numeric', 'regex:/^\d+(\.\d{1,3})?$/', 'min:0', 'max:11'],
            'lead'       => ['required', 'numeric', 'regex:/^\d+(\.\d{1,3})?$/', 'min:0', 'max:10'],
            'form'       => ['required', 'numeric', 'regex:/^\d+(\.\d{1,3})?$/', 'min:0', 'max:10'],
            'club_id'    => ['nullable', 'integer', Rule::exists(Club::TABLE_NAME, 'id')],
            'country_id' => ['required', 'integer', Rule::exists(Country::TABLE_NAME, 'id')],

        ];
    }
}
