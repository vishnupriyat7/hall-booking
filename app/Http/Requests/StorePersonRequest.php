<?php

namespace App\Http\Requests;

use App\Models\Person;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StorePersonRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('person_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'gender' => [
                'required',
            ],
            'dob' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'age' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'mobile' => [
                'string',
                'min:10',
                'nullable',
            ],
            'id_detail' => [
                'string',
                'nullable',
            ],
            'recommended_by_detail' => [
                'string',
                'nullable',
            ],
            'country' => [
                'string',
                'nullable',
            ],
            'state' => [
                'string',
                'nullable',
            ],
            'post_office' => [
                'string',
                'nullable',
            ],
            'pincode' => [
                'string',
                'nullable',
            ],
        ];
    }
}
