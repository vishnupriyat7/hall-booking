<?php

namespace App\Http\Requests;

use App\Models\IdType;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyIdTypeRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('id_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:id_types,id',
        ];
    }
}
