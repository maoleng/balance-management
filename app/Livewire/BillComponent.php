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

    public function edit(Bill $bill): void
    {
        $this->form->edit($bill);
    }

    public function resetForm()
    {
        $this->edit(new Bill);
    }

}
