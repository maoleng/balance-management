<?php

namespace App\Livewire;

use App\Livewire\Forms\BillForm;
use App\Models\Bill;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class BillComponent extends Component
{

    public BillForm $form;

    public Collection $bills;

    public function render(): View
    {
        return view('livewire.bill');
    }

    public function mount(): void
    {
        $this->loadBills();
    }

    private function loadBills(): void
    {
        $this->bills = Bill::query()->orderByRaw('CASE WHEN pay_at < NOW() THEN 1 ELSE 0 END, pay_at ASC')->get();
    }

    public function store(): void
    {
        $this->form->save();
        $this->loadBills();
    }

    public function edit($bill_id = null): void
    {
        $bill = $this->bills->where('id', $bill_id)->first();
        $this->form->edit($bill);

        $this->dispatch('openModal');
    }

    public function destroy(Bill $bill): void
    {
        $bill->delete();
        $this->loadBills();
    }

}
