<?php

namespace App\Http\Requests;

use App\Models\GalleryPass;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreGalleryPassRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('gallery_pass_create');
    }

    public function rules()
    {
        return [
            'number' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'person_id' => [
                'required',
                'integer',
            ],
            'issued_date' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'date_of_visit' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'print_count' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'id_type' => [
                'string',
                'nullable',
            ],
            'id_detail' => [
                'string',
                'nullable',
            ],
            'country' => [
                'string',
                'nullable',
            ],
            'state' => [
                'string',
                'nullable',
            ],
            'district' => [
                'string',
                'nullable',
            ],
            'post_office' => [
                'string',
                'nullable',
            ],
            'pincode' => [
                'string',
                'nullable',
            ],
            'photo' => [
                'string',
                'nullable',
            ],
        ];
    }
}
