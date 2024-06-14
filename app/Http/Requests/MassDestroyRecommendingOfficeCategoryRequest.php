<?php

namespace App\Http\Requests;

use App\Models\RecommendingOfficeCategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyRecommendingOfficeCategoryRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('recommending_office_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:recommending_office_categories,id',
        ];
    }
}
