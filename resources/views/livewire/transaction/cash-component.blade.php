@php use App\Enums\ReasonType; @endphp
@php use App\Enums\ReasonLabel; @endphp
@section('header')
    <div class="appHeader">
        <div class="left">
            <a wire:navigate href="{{ route('transaction.index') }}" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Giao dịch tiền mặt</div>
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
                            <div class="pb-3">
                                @foreach($this->reasons->whereIn('type', ReasonType::getCashReasonTypes()) as $reason)
                                    <span data-type="{{ $reason->type }}" class="s-reason badge badge-{{ $reason->type === ReasonType::EARN ? 'primary' : 'danger' }}">
                                        {{ $reason->name }}
                                    </span>
                                @endforeach
                                <span data-type="{{ ReasonType::GROUP }}" class="s-reason badge badge-warning">{{ ReasonType::getDescription(ReasonType::GROUP) }}</span>
                                <span data-type="{{ ReasonType::CREDIT_SETTLEMENT }}" class="s-reason badge badge-info">{{ ReasonType::getDescription(ReasonType::CREDIT_SETTLEMENT) }}</span>
                            </div>
                            <div class="form-group basic animated">
                                <div class="input-wrapper">
                                    <label class="label" for="i-reason">Lí do</label>
                                    <input required wire:model="form.reason" type="text" class="form-control" id="i-reason" placeholder="Lí do">
                                    <i class="clear-input">
                                        <ion-icon name="close-circle"></ion-icon>
                                    </i>
                                </div>
                            </div>
                            <div class="form-group basic animated">
                                <div class="input-wrapper">
                                    <label class="label" for="i-price">Số tiền</label>
                                    <input required wire:model="form.price" type="number" class="form-control" id="i-price" placeholder="Số tiền">
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
                                <label class="label" for="userid2">Trả sau</label>
                                <div class="form-check form-switch">
                                    <input wire:model="form.is_credit" class="form-check-input" type="checkbox" id="is_credit">
                                    <label class="form-check-label" for="is_credit"></label>
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
                                <strong>{{ $transaction['reason']['shortName'] }}</strong>
                                @if($transaction['isCredit'])
                                    <span class="badge badge-danger">Tín dụng</span>
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

            if ($('#i-price').val() == null || $('#i-reason').val() == null || $('input[type="radio"][name="type"]:checked').length === 0) {
                e.preventDefault()
                showErrorDialog('Vui lòng điền đầy đủ thông tin')
            } else {
                showSuccessToast('Thêm mới giao dịch thành công')
            }
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
@endpush
