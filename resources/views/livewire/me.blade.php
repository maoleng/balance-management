@section('header')
    <div class="appHeader">
        <div class="left">
            <a wire:navigate href="{{ route('index') }}" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">
            Cài đặt
        </div>
    </div>
@endsection
<div id="appCapsule">
    <div class="section mt-3 text-center">
        <div class="avatar-section">
            <a href="#">
                <img src="{{ asset('assets/img/avatar.jpg') }}" alt="avatar" class="imaged w100 rounded">
            </a>
        </div>
    </div>
    <div class="listview-title mt-1">Giao diện</div>
    <ul class="listview image-listview text inset no-line">
        <li>
            <div class="item">
                <div class="in">
                    <div>Tối</div>
                    <div class="form-check form-switch  ms-2">
                        <input wire:click="toggleDarkMode" class="form-check-input dark-mode-switch" type="checkbox" id="darkmodeSwitch">
                        <label class="form-check-label" for="darkmodeSwitch"></label>
                    </div>
                </div>
            </div>
        </li>
        <li>
            <a href="{{ route('me') }}" class="item">
                <div class="in">
                    <div>Tải lại trang</div>
                </div>
            </a>
        </li>
    </ul>
    <div class="listview-title mt-1">Bảo mật</div>
    <ul class="listview image-listview text mb-2 inset">
        <li>
            <a href="#" class="item">
                <div class="in">
                    <div>Đăng xuất</div>
                </div>
            </a>
        </li>
    </ul>
</div>
