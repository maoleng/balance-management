<?php

namespace App\Http\Requests;

use App\Enums\ReasonType;

class CryptoTransactionRequest extends BaseRequest
{

    public function rules(): array
    {
        return [
            'price' => [
                'required',
                'numeric',
            ],
            'quantity' => [
                'required',
                'numeric',
            ],
            'type' => [
                'required',
            ],
            'name' => [
                'required',
            ],
        ];
    }

}
