<?php

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class MeComponent extends Component
{

    public function render(): View
    {
        return view('livewire.me');
    }

    public function toggleDarkMode(): void
    {
        $dark_mode = Cache::get('dark-mode') === 'dark-mode' ? '' : 'dark-mode';
        Cache::forever('dark-mode', $dark_mode);
    }

}
