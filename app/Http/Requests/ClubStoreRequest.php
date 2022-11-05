<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClubStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return  true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'club_name' => [
                'required',
                'string',
                'min:3',
                'max:30',
                Rule::unique('clubs')->ignore($this->id)
            ],
            'club_rating_points' => [
                'integer', 
                'max:20000',
            ],
            'club_rank' => [
                'nullable',
                'integer',
                'min:1',
                'max:2000'
                ],
            'supporters' => [
                'integer',
                'min:0',
                'max:100005'
                ],
            'supporters_mood' => [
                'required',
                'string'
                ],
            'budget' => [
                'integer',
                'min:-10000000',
                'max:1000000000'
                ],
            'country_id'=> [
                'required',
                'integer'
                ],
            'town_id' => [
                'nullable',
                'integer'
                ],
            'user_id' => [
                'nullable',
                'integer'],
        ];
    }
}
