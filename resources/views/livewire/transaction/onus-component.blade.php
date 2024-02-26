@php use App\Enums\ReasonType; @endphp
@php use App\Enums\ReasonLabel; @endphp
@section('header')
    <div class="appHeader">
        <div class="left">
            <a wire:navigate href="{{ route('transaction.index') }}" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Giao dịch tiền tiết kiệm</div>
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
                                    @foreach (ReasonType::getFundExchangeReasonTypes() as $name => $value)
                                        <div class="form-check">
                                            <input wire:model="form.type" type="radio" class="i-reason form-check-input" name="type" value="{{ $value }}" id="r-f-{{ $name }}" autocomplete="off">
                                            <label class="form-check-label" for="r-f-{{ $name }}">{{ ReasonType::getDescription($value) }}</label>
                                        </div>
                                    @endforeach
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
                            <div id="d-coin"></div>
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
                    <a href="app-transaction-detail.html" class="item">
                        <div class="detail">
                            <div>


                                <strong>{{ $transaction['reason']['name'] }}</strong>
                            </div>
                        </div>
                        <div class="right">
                            @if (in_array($transaction['reason']['type'], [ReasonType::ONUS_TO_CASH, ReasonType::ONUS_TO_ONUS_FUTURE], true))
                                <div class="price text-danger">
                                    - {!! formatVND($transaction['price'], 'danger') !!}
                                </div>
                            @elseif (in_array($transaction['reason']['type'], [ReasonType::ONUS_TO_ONUS_FARMING, ReasonType::ONUS_FARMING_TO_ONUS, ReasonType::FUTURE_REVENUE_ONUS], true))
                                <div class="price text-info">
                                    {!! formatVND($transaction['price'], 'info') !!}
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
            if ($('#i-price').val().trim() === '' || $('.i-reason:checked').length === 0) {
                e.preventDefault()
                showErrorDialog('Vui lòng điền đầy đủ thông tin')
            } else {
                showSuccessToast('Thêm mới giao dịch thành công')
            }
        })
        $('.i-reason').on('click', function () {
            const reasons = '{{ implode(',', [ReasonType::ONUS_TO_ONUS_FARMING, ReasonType::ONUS_FARMING_TO_ONUS, ReasonType::FARM_REVENUE_ONUS]) }}'.split(',')
            if (reasons.includes($(this).val())) {
                $('#d-coin').empty()
                $('#d-coin').append(`
                    <div class="form-group basic animated pb-3">
                        <div class="input-wrapper">
                            <label class="label" for="i-coin">Mã tiền</label>
                            <input required wire:model="form.coin" type="text" class="form-control" id="i-coin" placeholder="Mã tiền">
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>
                `)
            } else {
                $('#d-coin').empty()
            }
        })
    </script>

@endpush
