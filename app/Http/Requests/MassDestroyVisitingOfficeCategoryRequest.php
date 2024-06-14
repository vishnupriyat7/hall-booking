<?php

namespace App\Http\Requests;

use App\Models\VisitingOfficeCategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyVisitingOfficeCategoryRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('visiting_office_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:visiting_office_categories,id',
        ];
    }
}
