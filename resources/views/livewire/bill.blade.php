@section('header')
    <div class="appHeader">
        <div class="left">
            <a wire:navigate href="{{ route('index') }}" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">
            Hóa đơn
        </div>
        <div class="right">
            <a id="btn-create" href="#" class="headerButton" data-bs-toggle="modal" data-bs-target="#modal-bill">
                <ion-icon name="add-outline"></ion-icon>
            </a>
        </div>
    </div>
@endsection

<div id="appCapsule">
    <div class="modal fade action-sheet" id="modal-bill" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm hóa đơn</h5>
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
                                <button id="btn-add" type="submit" class="btn btn-primary btn-block btn-lg" data-bs-dismiss="modal">Thêm</button>
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
                <a href="#" class="btn-edit_bill item" data-bill_id="{{ $bill->id }}">
                    <div>
                        {{ $bill->name }}
                        <footer>{!! $bill->payDateLeftTag !!}</footer>
                    </div>
                    <span class="text-muted">{!! formatVND($bill->price) !!}</span>
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
                                <button wire:click="destroy({{ $bill }})" class="btn btn-text-primary" data-bs-dismiss="modal">Xóa</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </ul>
</div>

@script
    <script>
        $('.btn-edit_bill').on('click', function (e) {
            $wire.$call('edit', $(this).data('bill_id')).then(function () {
                $('#modal-bill').modal('toggle')
            })
        })
        $('#i-price').on('input', function() {
            $(this).val($(this).val().replace(/\D/g,'').toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","))
        })
        $('#btn-add').on('click', function (e) {
            if ($('#i-name').val().trim() === '' || $('#i-price').val().trim() === '' || $('#i-pay_at').val().trim() === '') {
                e.preventDefault()
                showErrorDialog('Vui lòng điền đầy đủ thông tin')
            } else {
                showSuccessToast('Thêm mới hóa đơn thành công')
            }
        })
        $('#btn-create').on('click', function () {
            $wire.$call('resetForm')
        })
    </script>
@endscript
