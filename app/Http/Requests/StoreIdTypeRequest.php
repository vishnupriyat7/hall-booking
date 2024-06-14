<?php

namespace App\Http\Requests;

use App\Models\IdType;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreIdTypeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('id_type_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'unique:id_types',
            ],
            'min_length' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'max_length' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'regex' => [
                'string',
                'nullable',
            ],
            'name_mal' => [
                'string',
                'nullable',
            ],
        ];
    }
}
