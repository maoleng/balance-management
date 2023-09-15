<?php

namespace App\Http\Requests;

class ReasonRequest extends BaseRequest
{

    public function rules(): array
    {
        return [
            'name' => [
                'required',
            ],
            'type' => [
                'required',
            ],
            'label' => [
                'nullable',
            ],
            'is_group' => [
                'required',
            ],
            'category_id' => [
                'nullable',
            ],
        ];
    }

}
