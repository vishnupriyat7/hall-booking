<?php

namespace App\Http\Requests;

use App\Models\VisitorPass;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateVisitorPassRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('visitor_pass_edit');
    }

    public function rules()
    {
        return [
            'person_id' => [
                'required',
                'integer',
            ],
            'pass_valid_from' => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'nullable',
            ],
            'pass_valid_upto' => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'nullable',
            ],
            'issued_date' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'number' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'date_of_visit' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'purpose' => [
                'required',
            ],
        ];
    }
}
