<?php

namespace App\Livewire;

use App\Http\Requests\Bill\StoreRequest;
use App\Http\Requests\BillRequest;
use App\Livewire\Forms\BillForm;
use App\Models\Bill;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Livewire\Component;

class BillComponent extends Component
{

    public function render(Request $request)
    {
        return view('livewire.bill');
    }

    public function list()
    {
        return Bill::query()->orderByRaw('CASE WHEN pay_at < NOW() THEN 1 ELSE 0 END, pay_at ASC')->get()->map(function($bill) {
            return [
                'id' => $bill->id,
                'name' => $bill->name,
                'price' => $bill->price,
                'formattedPrice' => formatVND($bill->price),
                'pay_at' => $bill->pay_at->format('Y-m-d'),
                'payDateLeftTag' => $bill->payDateLeftTag,
            ];
        });
    }

    public function save(BillRequest $request): void
    {
        $data = $request->validated();
        $data['price'] = str_replace(',', '', $data['price']);
        $data['id']
            ? Bill::query()->where('id', $data['id'])->update($data)
            : Bill::query()->create($data);
    }

    public function destroy(Request $request): void
    {
        Bill::query()->where('id', $request->get('id'))->delete();
    }

}
