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
                                    <label class="label" for="i-price">Tên</label>
                                    <input required wire:model="form.name" type="tel" class="form-control" id="i-price" placeholder="Tên">
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
    <div class="section mt-3 text-center">
        <div class="row">
            @foreach($this->bills as $bill)
                <div class="col-6 mb-2">
                    <div class="bill-box">
                        <div wire:click="edit({{ $bill }})" data-bs-toggle="modal" data-bs-target="#modal-bill" class="img-wrapper">
                            <img src="{{ getFullPath($bill->image) }}" alt="img" class="image-block imaged w-75">
                        </div>
                        <div class="price">{!! formatVND($bill->price) !!}</div>
                        <h5 class="text-muted">{{ $bill->name }}</h5>
                        {!! $bill->payDateLeftTag !!}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@script
    <script>
        $('#btn-create').on('click', function () {
            $wire.$call('resetForm')
        })
    </script>
@endscript
