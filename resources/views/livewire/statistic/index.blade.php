@extends('components.main-layout.app')

@section('title') Thống kê @endsection
@section('back') {{ route('index') }} @endsection

@section('content')
    <div id="appCapsule">
        <div class="section mt-2">
            <a wire:navigate href="{{ route('statistic.index', ['p' => 'expense']) }}" class="card bg-dark text-white">
                <img src="https://assets.bonappetit.com/photos/57c59e676a6acdf3485df97b/master/pass/Winter_2016-Latte_Macchiato_+_Brownie.jpg" alt="image">
                <div class="card-img-overlay">
                    <h2 class="card-title">Chi tiêu</h2>
                </div>
            </a>
        </div>
        <div class="section mt-2">
            <a wire:navigate href="{{ route('statistic.index', ['p' => 'income']) }}" class="card bg-dark text-white">
                <img src="https://www.colliers.com/-/media/images/colliers/asia/philippines/colliers-review/collierreview_hero_image_01312022_v2/hero_image_tondominium/hero_image_021522/hero_image_colliersviewpoint_022222.ashx?bid=0f5b3ed2a8de41f89e1a8d557e48f9f8" class="card-img overlay-img" alt="image">
                <div class="card-img-overlay">
                    <h2 class="card-title">Thu nhập</h2>
                </div>
            </a>
        </div>
    </div>
@endsection
