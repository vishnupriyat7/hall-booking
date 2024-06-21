<?php

namespace App\Http\Requests;

use App\Models\District;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateDistrictRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('district_edit');
    }

    public function rules()
    {
        return [
            'district_abbr' => [
                'string',
                'nullable',
            ],
            'district_name' => [
                'string',
                'nullable',
            ],
            'pin_code' => [
                'string',
                'nullable',
            ],
        ];
    }
}
