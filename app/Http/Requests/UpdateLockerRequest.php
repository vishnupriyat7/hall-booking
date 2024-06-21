<?php

namespace App\Http\Requests;

use App\Models\Locker;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateLockerRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('locker_edit');
    }

    public function rules()
    {
        return [
            'token' => [
                'string',
                'nullable',
            ],
        ];
    }
}
