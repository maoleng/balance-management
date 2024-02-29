@extends('components.main-layout.app')

@section('title') Hóa đơn @endsection
@section('back') {{ route('index') }} @endsection
@section('right')
    <div class="right">
        <a id="btn-create" wire:click="edit" data-bs-toggle="modal" data-bs-target="#modal-bill" href="#" class="headerButton">
            <ion-icon name="add-outline" role="img" class="md hydrated" aria-label="add outline"></ion-icon>
        </a>
    </div>
@endsection

@section('content')
    <div id="appCapsule">
        <div class="modal fade action-sheet" id="modal-bill" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Cài đặt hóa đơn</h5>
                    </div>
                    <div class="modal-body">
                        <div class="action-sheet-content">
                            <form wire:submit="store">
                                <div class="form-group basic animated pt-2">
                                    <div class="input-wrapper">
                                        <label class="label" for="i-name">Tên</label>
                                        <input required wire:model="form.name" type="text" class="form-control" id="i-name" placeholder="Tên">
                                        <i class="clear-input">
                                            <ion-icon name="close-circle"></ion-icon>
                                        </i>
                                    </div>
                                </div>
                                <div class="form-group basic animated">
                                    <div class="input-wrapper">
                                        <label class="label" for="i-price">Số tiền</label>
                                        <input required wire:model="form.price" type="tel" class="form-control" id="i-price" placeholder="Số tiền">
                                        <i class="clear-input">
                                            <ion-icon name="close-circle"></ion-icon>
                                        </i>
                                    </div>
                                </div>
                                <div class="form-group basic animated pb-3">
                                    <div class="input-wrapper">
                                        <label class="label" for="i-pay_at">Trả vào lúc</label>
                                        <input required wire:model="form.pay_at" type="date" class="form-control" id="i-pay_at">
                                        <i class="clear-input">
                                            <ion-icon name="close-circle"></ion-icon>
                                        </i>
                                    </div>
                                </div>
                                <input type="hidden" wire:model="id">
                                <div class="form-group basic">
                                    <button id="btn-add" type="submit" class="btn btn-primary btn-block btn-lg" data-bs-dismiss="modal">Lưu</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="listview-title mt-2">Danh sách các hóa đơn</div>
        <ul class="listview simple-listview">
            @foreach($this->bills as $bill)
                <li>
                    <a wire:click="edit({{ $bill->id }})" href="#" class="item">
                        <div>
                            {{ $bill->name }}
                        </div>
                        <span class="text-secondary">{!! formatVND($bill->price) !!}</span>
                        <footer>{!! $bill->payDateLeftTag !!}</footer>
                    </a>
                    <button data-bs-toggle="modal" data-bs-target="#modal-delete-{{ $bill->id }}" type="button" class="btn btn-icon btn-outline-danger me-1">
                        <ion-icon name="trash-outline" role="img" class="md hydrated" aria-label="trash outline"></ion-icon>
                    </button>
                </li>

                <div class="modal fade dialogbox" id="modal-delete-{{ $bill->id }}" data-bs-backdrop="static" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Xóa</h5>
                            </div>
                            <div class="modal-body">
                                Bạn chắc chứ?
                            </div>
                            <div class="modal-footer">
                                <div class="btn-inline">
                                    <a href="#" class="btn btn-text-secondary" data-bs-dismiss="modal">Hủy</a>
                                    <button wire:click="destroy({{ $bill->id }})" class="btn btn-text-primary" data-bs-dismiss="modal">Xóa</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </ul>
    </div>
@endsection

@script
    <script>
        Livewire.on('openModal', () => {
            $('#modal-bill').modal('toggle');
        })
        $('#i-price').on('input', function() {
            $(this).val($(this).val().replace(/\D/g,'').toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","))
        })
        $('#btn-add').on('click', function (e) {
            if ($('#i-name').val().trim() === '' || $('#i-price').val().trim() === '' || $('#i-pay_at').val().trim() === '') {
                e.preventDefault()
                showErrorDialog('Vui lòng điền đầy đủ thông tin')
            } else {
                showSuccessToast('Cập nhật hóa đơn thành công')
            }
        })

    </script>
@endscript
