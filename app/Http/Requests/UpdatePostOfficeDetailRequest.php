<?php

namespace App\Http\Requests;

use App\Models\PostOfficeDetail;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdatePostOfficeDetailRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('post_office_detail_edit');
    }

    public function rules()
    {
        return [
            'pincode' => [
                'string',
                'nullable',
            ],
            'epost_delivery_status' => [
                'string',
                'nullable',
            ],
            'default_post_flag' => [
                'string',
                'nullable',
            ],
            'post_office_name' => [
                'string',
                'nullable',
            ],
            'post_office_status' => [
                'string',
                'nullable',
            ],
            'district_name' => [
                'string',
                'nullable',
            ],
            'postal_circle' => [
                'string',
                'nullable',
            ],
        ];
    }
}
