<?php

namespace App\Http\Requests;

use App\Models\LockerToken;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateLockerTokenRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('locker_token_edit');
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
