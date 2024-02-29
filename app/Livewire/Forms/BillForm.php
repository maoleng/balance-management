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

    public function save(): void
    {
        $this->validate();

        $data = $this->all();
        $data['price'] = str_replace(',', '', $data['price']);
        $data['id']
            ? Bill::query()->where('id', $data['id'])->update($data)
            : Bill::query()->create($data);

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
