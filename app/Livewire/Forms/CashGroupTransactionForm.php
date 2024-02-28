<?php

namespace App\Livewire\Forms;

use App\Enums\ReasonType;
use App\Models\Reason;
use App\Models\Transaction;
use http\Exception\RuntimeException;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CashGroupTransactionForm extends Form
{

    public $price;
    public $quantity;
    public $reason;

    public function rules(): array
    {
        return [
            'price' => [
                'required',
            ],
            'quantity' => [
                'required',
                'numeric',
            ],
            'reason' => [
                'required',
            ],
        ];
    }

    public function store($transaction): Transaction
    {
        $this->validate();

        $data = $this->all();

        $name = $data['reason'];
        $reason_id = Reason::query()->firstOrCreate(
            [
                'name' => $name,
            ],
            [
                'name' => $name,
                'type' => ReasonType::SPEND,
            ]
        )->id;

        $transaction = Transaction::query()->create([
            'price' => str_replace(',', '', $data['price']),
            'quantity' => $data['quantity'],
            'reason_id' => $reason_id,
            'external' => $transaction->is_credit ? ['is_credit' => true] : null,
            'transaction_id' => $transaction->id,
            'created_at' => $transaction->created_at,
        ]);

        $this->reset();

        return $transaction;
    }

}
