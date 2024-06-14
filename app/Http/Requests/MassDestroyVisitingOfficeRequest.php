<?php

namespace App\Http\Requests;

use App\Models\VisitingOffice;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyVisitingOfficeRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('visiting_office_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:visiting_offices,id',
        ];
    }
}
