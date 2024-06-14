<?php

namespace App\Http\Requests;

use App\Models\VisitingOffice;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreVisitingOfficeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('visiting_office_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'nullable',
            ],
        ];
    }
}
