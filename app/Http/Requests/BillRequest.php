<?php

namespace App\Http\Requests;

class BillRequest extends BaseRequest
{

    public function rules(): array
    {
        return [
            'id' => [
                'nullable',
            ],
            'name' => [
                'required',
            ],
            'price' => [
                'required',
            ],
            'pay_at' => [
                'required',
            ],
        ];
    }
}
