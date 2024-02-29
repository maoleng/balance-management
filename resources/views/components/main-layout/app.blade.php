<div>
    <div class="appHeader">
        <div class="left">
            @if (! \Illuminate\Support\Facades\Route::is('index'))
            <a wire:navigate href="@yield('back')" class="headerButton goBack">
                <ion-icon name="chevron-back-outline" role="img" class="md hydrated" aria-label="chevron-back outline"></ion-icon>
            </a>
            @endif
        </div>
        <div class="pageTitle">
            @yield('title')
        </div>
        @yield('right')
    </div>
    @yield('content')
</div>
