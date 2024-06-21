<?php

namespace App\Http\Requests;

use App\Models\Country;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCountryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('country_edit');
    }

    public function rules()
    {
        return [
            'country_abbr' => [
                'string',
                'required',
            ],
            'country_name' => [
                'string',
                'required',
            ],
            'is_default_country' => [
                'required',
            ],
            'iso_3' => [
                'string',
                'nullable',
            ],
            'numcode' => [
                'string',
                'nullable',
            ],
            'default_country' => [
                'string',
                'nullable',
            ],
            'iso' => [
                'string',
                'nullable',
            ],
        ];
    }
}
