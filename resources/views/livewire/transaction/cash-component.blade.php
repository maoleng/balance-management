@php use App\Enums\ReasonType; @endphp
@php use App\Enums\ReasonLabel; @endphp
@extends('components.main-layout.app')

@section('title') Giao dịch tiền mặt @endsection
@section('back') {{ route('transaction.index') }} @endsection
@section('right')
    <div class="right">
        <a href="#" class="headerButton" data-bs-toggle="modal" data-bs-target="#modal-create">
            <ion-icon name="add-outline"></ion-icon>
        </a>
    </div>
@endsection

@section('content')
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

                                <div class="form-group basic animated pb-3">
                                    <div class="input-wrapper">
                                        <label class="label" for="i-reason">Lí do</label>
                                        <input required wire:model="form.reason" type="text" class="form-control" id="i-reason" placeholder="Lí do">
                                        <i class="clear-input">
                                            <ion-icon name="close-circle"></ion-icon>
                                        </i>
                                    </div>
                                </div>
                                <div>
                                    @foreach($this->reasons->whereIn('type', ReasonType::getCashReasonTypes()) as $reason)
                                        <div data-type="{{ $reason->type }}" class="s-reason chip {{ $reason->image ? 'chip-media' : '' }} chip-outline chip-{{ $reason->type === ReasonType::EARN ? 'primary' : 'danger' }} ms-05 mb-05">
                                            @if ($reason->image)
                                                <img src="{{ getFullPath($reason->image) }}" alt="avatar">
                                            @endif
                                            <span class="chip-label">{{ $reason->name }}</span>
                                        </div>
                                    @endforeach
                                    <span data-type="{{ ReasonType::GROUP }}" class="s-reason badge badge-warning">{{ ReasonType::getDescription(ReasonType::GROUP) }}</span>
                                    <span data-type="{{ ReasonType::CREDIT_SETTLEMENT }}" class="s-reason badge badge-info">{{ ReasonType::getDescription(ReasonType::CREDIT_SETTLEMENT) }}</span>
                                    <span data-type="{{ ReasonType::VIB_SETTLEMENT }}" class="s-reason badge badge-info">{{ ReasonType::getDescription(ReasonType::VIB_SETTLEMENT) }}</span>
                                    <span data-type="{{ ReasonType::LIO_SETTLEMENT }}" class="s-reason badge badge-info">{{ ReasonType::getDescription(ReasonType::LIO_SETTLEMENT) }}</span>
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
                                <div class="pt-2">
                                    <label class="label" for="userid2">Loại</label>
                                    <div class="input-list">
                                        <div class="form-check">
                                            <input wire:model="form.type" class="form-check-input" type="radio" value="0" name="type" id="i-type_0">
                                            <label class="form-check-label" for="i-type_0">Chi phí</label>
                                        </div>
                                        <div class="form-check">
                                            <input wire:model="form.type" class="form-check-input" type="radio" value="1" name="type" id="i-type_1">
                                            <label class="form-check-label" for="i-type_1">Thu nhập</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="pb-3 pt-2">
                                    <label class="label" for="userid2">Nguồn tiền</label>
                                    <div class="input-list">
                                        <div class="form-check">
                                            <input wire:model="form.money_source" class="form-check-input" type="radio" value="0" name="money_source" id="i-source_0">
                                            <label class="form-check-label" for="i-source_0">Tiền mặt</label>
                                        </div>
                                        <div class="form-check">
                                            <input wire:model="form.money_source" class="form-check-input" type="radio" value="1" name="money_source" id="i-source_1">
                                            <label class="form-check-label" for="i-source_1">Ví trả sau MoMo</label>
                                        </div>
                                        <div class="form-check">
                                            <input wire:model="form.money_source" class="form-check-input" type="radio" value="2" name="money_source" id="i-source_2">
                                            <label class="form-check-label" for="i-source_2">Thẻ tín dụng VIB</label>
                                        </div>
                                        <div class="form-check">
                                            <input wire:model="form.money_source" class="form-check-input" type="radio" value="3" name="money_source" id="i-source_3">
                                            <label class="form-check-label" for="i-source_3">Thẻ tín dụng LIO</label>
                                        </div>
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
                        <a wire:navigate href="{{ route('transaction.cash', ['transaction' =>  $transaction['id']]) }}" class="item">
                            <div class="detail">
                                <img src="{{ getFullPath($transaction['reason']['image']) }}" alt="img" class="image-block imaged w48">
                                <div>
                                    <strong>{{ $transaction['reason']['name'] }}</strong>
                                    @if($transaction['isCredit'])
                                        <span class="badge badge-danger">Ví trả sau MoMo</span>
                                    @elseif($transaction['isVIB'])
                                        <span class="badge badge-danger">Thẻ tín dụng VIB</span>
                                    @elseif($transaction['isLIO'])
                                        <span class="badge badge-danger">Thẻ tín dụng LIO</span>
                                    @else
                                        <span class="badge badge-secondary">Tiền mặt</span>
                                    @endif
                                    @if ($transaction['reason']['type'] === ReasonType::SPEND)
                                        {!! ReasonLabel::getBadge($transaction['reason']['label']) !!}
                                    @endif
                                </div>
                            </div>
                            <div class="right">
                                <div class="price {{ $transaction['reason']['type'] === ReasonType::EARN ? 'text-secondary' : 'text-danger' }}">
                                    @if ($transaction['reason']['type'] === ReasonType::EARN)
                                        + {!! formatVND($transaction['price']) !!}
                                    @elseif ($transaction['reason']['type'] === ReasonType::GROUP)
                                        - {!! formatVND($transaction['totalPrice'], 'danger') !!}
                                    @else
                                        - {!! formatVND($transaction['price'], 'danger') !!}
                                    @endif
                                </div>
                                <div class="text-end text-white">
                                    {{ $transaction['prettyCreatedTime'] }}
                                </div>
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
@endsection

@script
    <script>
        $('#i-price').on('input', function() {
            $(this).val($(this).val().replace(/\D/g,'').toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","))
        })
        $('#btn-load').on('click', function () {
            $(this).data("p", parseInt($(this).data("p")) + 1);
        })
        $('#btn-add').on('click', function (e) {

            if ($('#i-price').val() == null || $('#i-reason').val() == null || $('input[type="radio"][name="type"]:checked').length === 0) {
                e.preventDefault()
                showErrorDialog('Vui lòng điền đầy đủ thông tin')
            } else {
                showSuccessToast('Thêm mới giao dịch thành công')
            }
        })
        $(".s-reason").on('click', function () {
            typeCharacter($('#i-reason'), $(this).find('span').text())
        })
        $("#i-reason").on("input", function () {
            const searchText = $(this).val().toLowerCase();
            $(".s-reason").each(function () {
                const reasonName = $(this).text().toLowerCase();
                if (reasonName.includes(searchText)) {
                    $(this).removeAttr("hidden");
                } else {
                    $(this).attr("hidden", "true");
                }
            });
        });
        $('#i-reason').on('input', function () {
            const reason = $(this).val()
            $(".s-reason").each(function() {
                const type = $(this).data('type')
                const typeBtn = $(`#i-type_${type}`)
                const reasonText = $(this).text().trim();
                if (reasonText === reason) {
                    typeBtn.prop('checked', true)
                    return false
                } else {
                    typeBtn.prop('checked', false)
                }
            });
        })
    </script>
@endscript
