<?php

namespace App\Http\Requests;

use App\Models\Session;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateSessionRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('session_edit');
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
