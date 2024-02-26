<?php

namespace App\Livewire\Transaction;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class IndexComponent extends Component
{

    public function render(): View
    {
        return view('livewire.transaction.index');
    }

}
