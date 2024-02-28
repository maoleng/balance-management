@php use Illuminate\Support\Facades; @endphp
<div class="appBottomMenu">
    <a wire:navigate href="{{ route('index') }}" class="item {{ Route::is('index') ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="home-outline"></ion-icon>
            <strong>Tổng quan</strong>
        </div>
    </a>
    <a wire:navigate href="{{ route('bill.index') }}" class="item {{ Route::is('bill.*') ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="storefront-outline"></ion-icon>
            <strong>Hóa đơn</strong>
        </div>
    </a>
    <a wire:navigate href="{{ route('transaction.index') }}" class="item {{ Route::is('transaction.*') ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="cash-outline"></ion-icon>
            <strong>Giao dịch</strong>
        </div>
    </a>
    <a wire:navigate href="{{ route('statistic.index') }}" class="item {{ Route::is('statistic.*') ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="stats-chart-outline"></ion-icon>
            <strong>Thống kê</strong>
        </div>
    </a>
    <a wire:navigate href="{{ route('classify.index') }}" class="item {{ Route::is('classify.*') ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="settings-outline"></ion-icon>
            <strong>Phân loại</strong>
        </div>
    </a>
</div>
