<?php

namespace App\Livewire\Forms;

use App\Models\Bill;
use Livewire\Form;

class BillForm extends Form
{

    public $id;
    public $name;
    public $price;
    public $pay_at;

    public function rules(): array
    {
        return [
            'id' => [
                'nullable',
            ],

        ];
    }

    public function save(): void
    {
        $this->validate();

        $data = $this->all();


        $this->reset();
    }

    public function edit(Bill $bill = null): void
    {
        $this->id = $bill?->id;
        $this->name = $bill?->name;
        $this->price = $bill?->price;
        $this->pay_at = $bill?->pay_at?->format('Y-m-d');
    }

}
