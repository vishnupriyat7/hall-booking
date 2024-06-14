<?php

namespace App\Http\Requests;

use App\Models\RecommendingOffice;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreRecommendingOfficeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('recommending_office_create');
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
