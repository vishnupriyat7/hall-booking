<?php

namespace App\Http\Requests;

use App\Models\RecommendingOfficeCategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreRecommendingOfficeCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('recommending_office_category_create');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'required',
                'unique:recommending_office_categories',
            ],
        ];
    }
}
