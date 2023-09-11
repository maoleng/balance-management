<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;

class ReasonRequest extends BaseRequest
{

    public function rules(): array
    {
        return [
            'name' => [
                'required',
            ],
            'label' => [
                'nullable',
            ],
            'is_group' => [
                'required',
            ],
        ];
    }

}
