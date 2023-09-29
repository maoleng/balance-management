<?php

namespace App\Http\Requests;

class ONUSTransactionRequest extends BaseRequest
{

    public function rules(): array
    {
        return [
            'price' => [
                'required',
                'numeric',
            ],
            'type' => [
                'required',
            ],
        ];
    }

}
