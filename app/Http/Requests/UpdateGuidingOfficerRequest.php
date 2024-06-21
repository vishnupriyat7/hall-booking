<?php

namespace App\Http\Requests;

use App\Models\GuidingOfficer;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateGuidingOfficerRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('guiding_officer_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'nullable',
            ],
            'pen' => [
                'string',
                'required',
                'unique:guiding_officers,pen,' . request()->route('guiding_officer')->id,
            ],
        ];
    }
}
