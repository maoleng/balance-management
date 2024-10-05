<?php

namespace App\Livewire\Forms;

use App\Enums\ReasonType;
use App\Models\Reason;
use App\Models\Transaction;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ONUSTransactionForm extends Form
{

    public $price;
    public $type;

    public function rules()
    {
        return [
            'price' => [
                'required',
            ],
            'type' => [
                'required',
            ],
        ];
    }

    public function store(): array
    {
        $this->validate();

        $data = $this->all();

        $reason_id = Reason::query()->firstOrCreate(
            [
                'type' => $data['type'],
            ],
            [
                'name' => ReasonType::getDescription((int) $data['type']),
                'type' => $data['type'],
            ]
        )->id;

        $transaction = Transaction::query()->create([
            'price' => str_replace(',', '', $data['price']),
            'reason_id' => $reason_id,
            'created_at' => now(),
        ]);

        $this->reset();

        $transaction->load('reason')->appendONUSData();

        return $transaction->toArray();
    }

}
