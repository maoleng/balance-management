@php use App\Enums\ReasonType; @endphp
@php use App\Enums\ReasonLabel; @endphp
@section('bg-class') bg-white @endsection
@section('header')
    <div class="appHeader">
        <div class="left">
            <a wire:navigate href="{{ route("transaction.$page") }}" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">
            Chi tiết giao dịch
        </div>
        <div class="right">
            <a href="#" class="headerButton" data-bs-toggle="modal" data-bs-target="#DialogBasic">
                <ion-icon name="trash-outline"></ion-icon>
            </a>
        </div>
    </div>
@endsection
<div id="appCapsule">
    <div class="modal fade dialogbox" id="DialogBasic" data-bs-backdrop="static" tabindex="-1" role="dialog">
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
                        <button wire:click="destroy({{ $transaction }}, 'transaction.{{ $page }}')" class="btn btn-text-primary" data-bs-dismiss="modal">Xóa</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($page === 'cash')
        <div class="section mt-2 mb-2">
            <div class="listed-detail mt-3">
                <div class="icon-wrapper">
                    <div class="iconbox">
                        <img src="{{ getFullPath($transaction['reason']['image']) }}" alt="avatar" class="imaged w100 rounded">
                    </div>
                </div>
                <h3 class="text-center mt-2">{{ $transaction->reason->name }}</h3>
                <h2 class="text-center text-secondary mt-2">{!! formatVND($transaction['price']) !!}</h2>
            </div>

            <ul class="listview flush transparent simple-listview no-space mt-3">
                <li>
                    <strong>Trạng thái</strong>
                    <span class="text-success">Thành công</span>
                </li>
                @if ($transaction->reason->type === ReasonType::EARN)
                    <li>
                        <strong>Loại</strong>
                        <span class="text-success">{{ ReasonType::getDescription($transaction->reason->type) }}</span>
                    </li>
                @else
                    <li>
                        <strong>Loại</strong>
                        <span>{{ $transaction->reason->category?->name }}</span>
                    </li>
                    <li>
                        <strong>Nhãn</strong>
                        <span>{{ $transaction->reason->label === null ? 'Chưa phân loại' : ReasonLabel::getDescription($transaction->reason->label) }}</span>
                    </li>
                    <li>
                        <strong>Phương thức</strong>
                        <span>{{ $transaction->isCredit ? 'Tín dụng' : 'Tiền mặt' }}</span>
                    </li>
                @endif
                <li>
                    <strong>Thời gian</strong>
                    <span>{{ $transaction->prettyCreatedAtWithTime }}</span>
                </li>
            </ul>
        </div>
    @endif

    @if ($page === 'crypto')
        <div class="section mt-2 mb-2">
            <div class="listed-detail mt-3">
                <div class="icon-wrapper">
                    <div class="iconbox">
                        <img src="{{ $transaction->coinLogo }}" alt="avatar" class="imaged w100 rounded">
                    </div>
                </div>
                <h3 class="text-center mt-2">{{ $transaction->reason->name }}</h3>
                <h2 class="text-center text-secondary mt-2">{!! formatVND($transaction->price) !!}</h2>
            </div>

            <ul class="listview flush transparent simple-listview no-space mt-3">
                <li>
                    <strong>Số lượng</strong>
                    <span>{!! formatCoin($transaction->quantity, $transaction->coinName) !!}</span>
                </li>
                <li>
                    <strong>Thời gian</strong>
                    <span>{{ $transaction->prettyCreatedAtWithTime }}</span>
                </li>
            </ul>
        </div>
    @endif
</div>
