<?php

namespace App\Http\Requests;

use App\Models\RecommendingOffice;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateRecommendingOfficeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('recommending_office_edit');
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
