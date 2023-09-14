<?php

namespace App\Http\Requests;

class TransactionRequest extends BaseRequest
{

    public function rules(): array
    {
        return [
            'price' => [
                'required',
                'numeric',
            ],
            'type' => [
                'nullable',
            ],
            'reason' => [
                'nullable',
                $this->type === null ? 'nullable' : 'required_without:type',
            ],
        ];
    }

}
