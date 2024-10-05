@extends('components.main-layout.app')

@section('title') Cài đặt @endsection
@section('back') {{ route('index') }} @endsection

@section('content')
    <div id="appCapsule">
        <div class="section mt-3 text-center">
            <div class="avatar-section">
                <a href="#">
                    <img src="{{ asset('assets/img/avatar.jpg') }}" alt="avatar" class="imaged w100 rounded">
                </a>
            </div>
        </div>
        <div class="listview-title mt-1">Cấu hình</div>
        <ul class="listview image-listview text inset no-line">
            <li>
                <a href="#" class="item" data-bs-toggle="modal" data-bs-target="#DialogForm">
                    <div class="in">
                        <div>Cài đặt số dư</div>
                    </div>
                </a>
            </li>
            <li>
                <a href="#" class="item" data-bs-toggle="modal" data-bs-target="#screenModeModal">
                    <div class="in">
                        <div>Giao diện</div>
                    </div>
                </a>
            </li>
        </ul>
        <div class="listview-title mt-1">Bảo mật</div>
        <ul class="listview image-listview text mb-2 inset">
            <li>
                <a href="{{ route('me') }}" class="item">
                    <div class="in">
                        <div>Tải lại trang</div>
                    </div>
                </a>
            </li>
            <li>
                <a href="#" class="item">
                    <div class="in">
                        <div>Đăng xuất</div>
                    </div>
                </a>
            </li>
        </ul>
    </div>

    <div class="modal fade dialogbox" id="DialogForm" data-bs-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Số dư hiện tại</h5>
                </div>
                <form>
                    <div class="modal-body text-start mb-2">
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="i-amount">Nhập số dư</label>
                                <input wire:model="init" type="number" class="form-control" id="i-amount">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-inline">
                            <button type="button" class="btn btn-text-secondary" data-bs-dismiss="modal">HỦY</button>
                            <button wire:click="saveInitAmount" onclick="showSuccessDialog('Cài đặt số dư thành công')" type="button" class="btn btn-text-primary" data-bs-dismiss="modal">LƯU</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade dialogbox" id="screenModeModal" data-bs-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form>
                    <div class="modal-body text-start mb-2">
                        <div class="form-group basic">
                            <div class="input-wrapper d-flex justify-content-center">
                                <div class="input-list pt-1">
                                    <div class="btn-group" role="group">
                                        <input type="radio" class="btn-check" name="type" value="auto" id="type_auto" autocomplete="off" wire:model="selectedType">
                                        <label class="btn btn-outline-primary" for="type_auto">Tự động</label>
                                        <input type="radio" class="btn-check" name="type" value="dark-mode" id="type_dark" autocomplete="off" wire:model="selectedType">
                                        <label class="btn btn-outline-primary" for="type_dark">Tối</label>
                                        <input type="radio" class="btn-check" name="type" value="light-mode" id="type_light" autocomplete="off" wire:model="selectedType">
                                        <label class="btn btn-outline-primary" for="type_light">Sáng</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-inline">
                            <button type="button" class="btn btn-text-secondary" data-bs-dismiss="modal">HỦY</button>
                            <button wire:click="toggleDarkMode" onclick="showSuccessDialog('Cài đặt màn hình thành công')" id="btn-save_screen" type="button" class="btn btn-text-primary" data-bs-dismiss="modal">LƯU</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@script
<script>
    $('#btn-save_screen').on('click', function () {
        const type = $('input[name="type"]:checked').val()
        if (type === 'dark-mode') {
            $('body').addClass('dark-mode')
        } else if (type === 'light-mode') {
            $('body').removeClass('dark-mode')
        } else {
            if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                $('body').addClass('dark-mode')
            } else {
                $('body').removeClass('dark-mode')
            }
        }
    })
</script>
@endscript
