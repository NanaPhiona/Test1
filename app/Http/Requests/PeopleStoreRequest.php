<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PeopleStoreRequest extends FormRequest
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
            'name' => 'required',
            'other_names' => 'required',
            'age' => 'required|int:min:0',
            'address' => 'required',
            'phone_number' => 'required|phone:UG',
            'phone_number_2' => 'nullable|phone:UG',
            'disabilities' => 'required|array',
            'disabilities.*' => 'required|exists:disabilities,id',
            'district_of_origin' => 'required',
            'village' => 'required',
            'sub_county' => 'required',
            'education_level' => 'required|in:Formal Education,Informal Education,No Education',
            'is_formal_education' => [
                'required_if:education_level,Formal Education',
                'nullable',
                'in:Primary,Secondary -UCE,Secondary - UACE,Bachelor\'s Degree,Master\'s Degree,PHD'
            ],
            'informal_education' => 'required_if:education_level,Informal Education|nullable|string',
        ];
    }
    public function withValidator($validator)
    {
        $validator->sometimes('is_formal_education', 'required|string', function ($input) {
            return $input->education_level === 'Formal Education';
        });

        $validator->sometimes('informal_education', 'required|string', function ($input) {
            return $input->education_level === 'Informal Education';
        });
    }
}
