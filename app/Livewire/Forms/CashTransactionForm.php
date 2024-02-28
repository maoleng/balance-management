<?php

namespace App\Livewire\Forms;

use App\Enums\ReasonType;
use App\Models\Reason;
use App\Models\Transaction;
use http\Exception\RuntimeException;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CashTransactionForm extends Form
{

    public $price;
    public $type;
    public $reason;
    public $is_credit = false;

    public function rules()
    {
        return [
            'price' => [
                'required',
            ],
            'type' => [
                'nullable',
            ],
            'reason' => [
                'required',
            ],
            'is_credit' => [
                'nullable',
            ],
        ];
    }

    public function store(): array
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
                'type' => $data['type'],
            ]
        )->id;

        $transaction = Transaction::query()->create([
            'price' => str_replace(',', '', $data['price']),
            'reason_id' => $reason_id,
            'external' => $data['is_credit'] ? ['is_credit' => true] : null,
            'created_at' => now(),
        ]);

        $this->reset();

        $transaction->load(['reason', 'transactions.reason'])->appendCashData();

        return $transaction->toArray();
    }

}
