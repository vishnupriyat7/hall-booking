<?php

namespace App\Http\Requests;

use App\Models\GroupPerson;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateGroupPersonRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('group_person_edit');
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
