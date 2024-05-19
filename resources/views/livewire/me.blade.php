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
                <a href="#" class="item" data-bs-toggle="modal" data-bs-target="#DialogForm">
                    <div class="in">
                        <div>Cài đặt số dư</div>
                    </div>
                </a>
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
                            <button type="button" class="btn btn-text-secondary" data-bs-dismiss="modal">Hủy</button>
                            <button wire:click="saveInitAmount" onclick="showSuccessDialog('Cài đặt số dư thành công')" type="button" class="btn btn-text-primary" data-bs-dismiss="modal">LƯU</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
