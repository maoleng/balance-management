<?php

namespace App\Livewire\Forms;

use App\Enums\ReasonType;
use App\Models\Reason;
use App\Models\Transaction;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CryptoTransactionForm extends Form
{

    public $price;
    public $quantity;
    public $type;
    public $name;

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

    public function store(): array
    {
        $this->validate();

        $data = $this->all();

        $reason_name = ReasonType::getDescription((int) $data['type']);

        $reason_id = Reason::query()->firstOrCreate(
            [
                'name' => $reason_name,
            ],
            [
                'name' => $reason_name,
                'type' => $data['type'],
            ]
        )->id;

        $transaction = Transaction::query()->create([
            'price' => $data['price'],
            'quantity' => $data['quantity'],
            'reason_id' => $reason_id,
            'external' => ['coin' => $data['name']],
            'created_at' => now(),
        ]);

        $this->reset();

        $transaction->load('reason')->appendCryptoData();

        return $transaction->toArray();
    }

}
