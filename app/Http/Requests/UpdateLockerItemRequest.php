<?php

namespace App\Http\Requests;

use App\Models\LockerItem;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateLockerItemRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('locker_item_edit');
    }

    public function rules()
    {
        return [
            'item_name' => [
                'string',
                'nullable',
            ],
            'item_count' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'locker_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
