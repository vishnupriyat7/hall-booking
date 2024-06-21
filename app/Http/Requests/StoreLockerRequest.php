<?php

namespace App\Http\Requests;

use App\Models\Locker;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreLockerRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('locker_create');
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
