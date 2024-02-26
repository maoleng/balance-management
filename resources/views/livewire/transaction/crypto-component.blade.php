@php use App\Enums\ReasonType; @endphp
@php use App\Enums\ReasonLabel; @endphp
@section('header')
    <div class="appHeader">
        <div class="left">
            <a wire:navigate href="{{ route('transaction.index') }}" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Giao dịch tiền điện tử</div>
        <div class="right">
            <a href="#" class="headerButton" data-bs-toggle="modal" data-bs-target="#modal-create">
                <ion-icon name="add-outline"></ion-icon>
            </a>
        </div>
    </div>
@endsection
<div id="appCapsule">
    <div class="modal fade action-sheet" id="modal-create" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm giao dịch</h5>
                </div>
                <div class="modal-body">
                    <div class="action-sheet-content">
                        <form wire:submit="store">
                            <div class="pt-2">
                                <label class="label" for="userid2">Lí do</label>
                                <div class="input-list">
                                    <div class="form-check">
                                        <input wire:model="form.type" type="radio" class="i-type form-check-input" name="type" value="{{ ReasonType::BUY_CRYPTO }}" id="r-buy" autocomplete="off">
                                        <label class="form-check-label" for="r-buy">{{ ReasonType::getDescription(ReasonType::BUY_CRYPTO) }}</label>
                                    </div>
                                    <div class="form-check">
                                        <input wire:model="form.type" type="radio" class="i-type form-check-input" name="type" value="{{ ReasonType::SELL_CRYPTO }}" id="r-sell" autocomplete="off">
                                        <label class="form-check-label" for="r-sell">{{ ReasonType::getDescription(ReasonType::SELL_CRYPTO) }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group basic animated pb-3">
                                <div class="input-wrapper">
                                    <label class="label" for="i-name">Mã tiền</label>
                                    <input required wire:model="form.name" type="text" class="form-control" id="i-name" placeholder="Mã tiền">
                                    <i class="clear-input">
                                        <ion-icon name="close-circle"></ion-icon>
                                    </i>
                                </div>
                            </div>
                            <div class="form-group basic animated pb-3">
                                <div class="input-wrapper">
                                    <label class="label" for="i-quantity">Số lượng</label>
                                    <input required wire:model="form.quantity" type="number" class="form-control" id="i-quantity" placeholder="Số lượng">
                                    <i class="clear-input">
                                        <ion-icon name="close-circle"></ion-icon>
                                    </i>
                                </div>
                            </div>
                            <div class="form-group basic animated pb-3">
                                <div class="input-wrapper">
                                    <label class="label" for="i-price">Số tiền</label>
                                    <input required wire:model="form.price" type="number" class="form-control" id="i-price" placeholder="Số tiền">
                                    <i class="clear-input">
                                        <ion-icon name="close-circle"></ion-icon>
                                    </i>
                                </div>
                            </div>
                            <div class="form-group basic">
                                <button id="btn-add" type="submit" class="btn btn-primary btn-block btn-lg" data-bs-dismiss="modal">Thêm</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach($this->gr_transactions as $date => $transactions)
        <div class="section mt-2">
            <div class="section-title">{{ $date }}</div>
            <div class="transactions">
                @foreach($transactions as $transaction)
                    <a wire:navigate href="{{ route('transaction.crypto', ['transaction' => $transaction['id']]) }}" class="item">
                        <div class="detail">
                            <img src="{{ $transaction['coinLogo'] }}" alt="img" class="image-block imaged w48">
                            <div>
                                <strong>{{ "{$transaction['reason']['name']} {$transaction['coinName']}" }}</strong>
                            </div>
                        </div>
                        <div class="right">
                            @if ($transaction['reason']['type'] === ReasonType::SELL_CRYPTO)
                                <div class="price text-danger">
                                    - {!! formatVND($transaction['price'], 'danger') !!}
                                </div>
                            @else
                                <div class="price text-secondary">
                                    + {!! formatVND($transaction['price']) !!}
                                </div>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endforeach

    <div class="section mt-2 mb-2">
        <button wire:click="loadMore" id="btn-load" data-p="1" class="btn btn-primary btn-block btn-lg">Tải thêm</button>
    </div>

</div>
@push('script')
    <script>
        $('#btn-load').on('click', function () {
            $(this).data("p", parseInt($(this).data("p")) + 1);
        })
        $('#btn-add').on('click', function (e) {
            if ($('#i-price').val().trim() === '' ||
                $('#i-quantity').val().trim() === '' ||
                $('#i-name').val().trim() === '' ||
                $('.i-type:checked').length === 0
            ) {
                e.preventDefault()
                showErrorDialog('Vui lòng điền đầy đủ thông tin')
            } else {
                showSuccessToast('Thêm mới giao dịch thành công')
            }
        })
    </script>

@endpush
