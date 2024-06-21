<?php

namespace App\Http\Requests;

use App\Models\LockerToken;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreLockerTokenRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('locker_token_create');
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
