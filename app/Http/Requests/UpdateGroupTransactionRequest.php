<?php

namespace App\Http\Requests;

use App\Models\Transaction;
use Illuminate\Validation\ValidationException;

class UpdateGroupTransactionRequest extends BaseRequest
{

    public function rules(): array
    {
        $transaction_id = $this->get('transaction_id');
        $transaction_ids = $this->get('transaction_ids');
        $reason_ids = $this->get('reason_ids');
        $prices = $this->get('prices');
        $quantities = $this->get('quantities');

        if (! isset($transaction_ids, $reason_ids, $prices, $quantities)) {
            return ['transaction_id' => ['required']];
        }

        $count = count($transaction_ids);
        if (count($reason_ids) !== $count || count($prices) !== $count || count($quantities) !== $count) {
            throw ValidationException::withMessages([
                'group_transaction' => 'Invalid format',
            ]);
        }

        $transactions = [];
        foreach ($transaction_ids as $i => $id) {
            $transactions[] = [
                'id' => $id,
                'reason_id' => $reason_ids[$i],
                'quantity' => $quantities[$i],
                'price' => $prices[$i],
                'transaction_id' => $transaction_id,
            ];
        }

        $this->merge([
            'transactions' => $transactions,
            'transaction' => Transaction::query()->find($transaction_id),
        ]);

        return [
            'reason_ids' => [
                'required',
            ],
            'prices' => [
                'required',
            ],
            'quantities' => [
                'required',
            ],
            'transaction_ids' => [
                'required',
            ],
            'transaction_id' => [
                'required',
            ],
        ];
    }

}
