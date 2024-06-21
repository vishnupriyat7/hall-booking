<?php

namespace App\Http\Requests;

use App\Models\GroupPerson;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreGroupPersonRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('group_person_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'age' => [
                'string',
                'nullable',
            ],
        ];
    }
}
