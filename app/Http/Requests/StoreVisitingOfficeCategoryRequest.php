<?php

namespace App\Http\Requests;

use App\Models\VisitingOfficeCategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreVisitingOfficeCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('visiting_office_category_create');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'required',
                'unique:visiting_office_categories',
            ],
        ];
    }
}
