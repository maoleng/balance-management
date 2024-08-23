@php use App\Enums\ReasonType; @endphp
@php use App\Enums\ReasonLabel; @endphp
@extends('components.main-layout.app')
@section('bg-class') bg-white @endsection

@section('title') Chi tiết giao dịch @endsection
@section('back') {{ route("transaction.$page") }} @endsection
@section('right')
    <div class="right">
        <a href="#" class="headerButton" data-bs-toggle="modal" data-bs-target="#DialogBasic">
            <ion-icon name="trash-outline"></ion-icon>
        </a>
    </div>
@endsection

@section('content')
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
                    <h2 class="text-center text-secondary mt-2">
                        {!! formatVND($transaction->reason->type === ReasonType::GROUP ? $transaction->totalPrice : $transaction->price) !!}
                    </h2>
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
                            <span>
                                @if($transaction->isCredit)
                                    Ví trả sau MoMo
                                @elseif($transaction->isVIB)
                                    Thẻ tín dụng VIB
                                @else
                                    Tiền mặt
                                @endif
                        </li>
                    @endif
                    <li class="li-created_at">
                        <strong>Thời gian</strong>
                        <span>{{ $transaction->prettyCreatedAtWithTime }}</span>
                    </li>
                </ul>

                <div class="modal fade dialogbox" id="modal-edit_time" data-bs-backdrop="static" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Chỉnh sửa giờ</h5>
                            </div>
                            <form>
                                <div class="modal-body text-start mb-2">
                                    <div class="form-group basic">
                                        <div class="input-wrapper">
                                            <label class="label" for="i-date">Ngày</label>
                                            <input wire:model="date" type="date" class="form-control" id="i-date">
                                            <i class="clear-input">
                                                <ion-icon name="close-circle"></ion-icon>
                                            </i>
                                        </div>
                                    </div>
                                    <div class="form-group basic">
                                        <div class="input-wrapper">
                                            <label class="label" for="i-time">Giờ</label>
                                            <input wire:model="time" type="time" class="form-control" id="i-time">
                                            <i class="clear-input">
                                                <ion-icon name="close-circle"></ion-icon>
                                            </i>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="btn-inline">
                                        <button type="button" class="btn btn-text-secondary" data-bs-dismiss="modal">Hủy</button>
                                        <button wire:click="updateTime" onclick="showSuccessDialog('Chỉnh sửa giờ thành công')" type="button" class="btn btn-text-primary" data-bs-dismiss="modal">LƯU</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @if ($transaction->reason->type === ReasonType::GROUP)
                <div class="section mt-5 mb-2">
                    <div class="section-title">Chi tiết
                        <a href="#" class="ps-1" data-bs-toggle="modal" data-bs-target="#dialog-add">
                            Thêm
                        </a>
                    </div>
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th scope="col">Tên</th>
                                    <th scope="col">SL</th>
                                    <th scope="col" class="text-end">Đơn giá</th>
                                    <th scope="col" class="text-end">Tổng</th>
                                    <th scope="col" >Xóa</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($transactions as $transaction)
                                    <tr>
                                        <th scope="row">{{ $transaction->reason->name }}</th>
                                        <td class="text-center">{{ $transaction->quantity }}</td>
                                        <td class="text-end">{!! formatVND($transaction->price) !!}</td>
                                        <td class="text-end">{!! formatVND($transaction->price * $transaction->quantity) !!}</td>
                                        <td>
                                            <button data-bs-toggle="modal" data-bs-target="#modal-delete-{{ $transaction->id }}" type="button" class="btn btn-icon btn-danger">
                                                <ion-icon name="trash-outline" role="img" class="md hydrated" aria-label="trash outline"></ion-icon>
                                            </button>
                                        </td>
                                    </tr>

                                    <div class="modal fade dialogbox" id="modal-delete-{{ $transaction->id }}" data-bs-backdrop="static" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Xóa {{ $transaction->reason->name }}</h5>
                                                </div>
                                                <div class="modal-body">
                                                    Bạn chắc chứ?
                                                </div>
                                                <div class="modal-footer">
                                                    <div class="btn-inline">
                                                        <a href="#" class="btn btn-text-secondary" data-bs-dismiss="modal">Hủy</a>
                                                        <button wire:click="destroyGroup({{ $transaction->id }})" class="btn btn-text-primary" data-bs-dismiss="modal">Xóa</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal fade action-sheet" id="dialog-add" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Thêm sản phẩm</h5>
                            </div>
                            <div class="modal-body">
                                <div class="action-sheet-content">
                                    <form wire:submit="storeGroup">
                                        <div class="form-group basic animated pb-3">
                                            <div class="input-wrapper">
                                                <label class="label" for="i-reason">Lí do</label>
                                                <input required wire:model="group_form.reason" type="text" class="form-control" id="i-reason" placeholder="Lí do">
                                                <i class="clear-input">
                                                    <ion-icon name="close-circle"></ion-icon>
                                                </i>
                                            </div>
                                        </div>
                                        <div>
                                            @foreach($this->reasons->whereIn('type', ReasonType::getCashReasonTypes()) as $reason)
                                                <div data-type="{{ $reason->type }}" class="s-reason chip {{ $reason->image ? 'chip-media' : '' }} chip-outline chip-info ms-05 mb-05">
                                                    @if ($reason->image)
                                                        <img src="{{ getFullPath($reason->image) }}" alt="avatar">
                                                    @endif
                                                    <span class="chip-label">{{ $reason->name }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="form-group basic animated">
                                            <div class="input-wrapper">
                                                <label class="label" for="i-quantity">Số lượng</label>
                                                <input required wire:model="group_form.quantity" type="number" class="form-control" id="i-quantity" placeholder="Số lượng">
                                                <i class="clear-input">
                                                    <ion-icon name="close-circle"></ion-icon>
                                                </i>
                                            </div>
                                        </div>
                                        <div class="form-group basic animated">
                                            <div class="input-wrapper">
                                                <label class="label" for="i-price">Số tiền</label>
                                                <input required wire:model="group_form.price" type="tel" class="form-control" id="i-price" placeholder="Số tiền">
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
            @endif
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

        @if ($page === 'onus')
            <div class="section mt-2 mb-2">
                <div class="listed-detail mt-3">
                    <div class="icon-wrapper">
                        <div class="iconbox">
                            @if ($type = ReasonType::classifyONUSType($transaction->reason->type))
                                <ion-icon name="arrow-down-outline"></ion-icon>
                            @elseif ($type === false)
                                <ion-icon name="arrow-up-outline"></ion-icon>
                            @else
                                <ion-icon name="infinite-outline"></ion-icon>
                            @endif
                        </div>
                    </div>
                    <h3 class="text-center mt-2">{{ $transaction->reason->name }}</h3>
                    <h2 class="text-center text-secondary mt-2">{!! formatVND($transaction->price) !!}</h2>
                </div>

                <ul class="listview flush transparent simple-listview no-space mt-3">
                    @if ($transaction->coinName)
                        <li>
                            <strong>Mã tiền</strong>
                            <span>{{ $transaction->coinName }}</span>
                        </li>
                    @endif
                    <li>
                        <strong>Thời gian</strong>
                        <span>{{ $transaction->prettyCreatedAtWithTime }}</span>
                    </li>
                </ul>
            </div>
        @endif

    </div>
@endsection

@if (in_array($transaction->reason->type, [ReasonType::EARN, ReasonType::SPEND, ReasonType::GROUP])) @script
    <script>
        $('.li-created_at').on('click', function () {
            $('#i-date').val('{{ $transaction->created_at->format('Y-m-d') }}')
            $('#i-time').val('{{ $transaction->created_at->format('H:i') }}')
            $('#modal-edit_time').modal('toggle');
        })
    </script>
@endscript @endif

@if ($transaction->reason->type === ReasonType::GROUP) @script
    <script>
        $('#i-price').on('input', function() {
            $(this).val($(this).val().replace(/\D/g,'').toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","))
        })
        $('#btn-add').on('click', function (e) {
            if ($('#i-price').val().trim() === '' || $('#i-reason').val().trim() === '' || $('#i-quantity').val().trim() === '') {
                e.preventDefault()
                showErrorDialog('Vui lòng điền đầy đủ thông tin')
            } else {
                showSuccessToast('Thêm mới sản phẩm thành công')
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
            $(".s-reason").each(function () {
                const type = $(this).data('type')
                const typeBtn = $(`#i-type_${type}`)
                const reasonText = $(this).text().trim();
                if (reasonText === reason) {
                    typeBtn.prop('checked', true)
                    return false
                } else {
                    typeBtn.prop('checked', false)
                }
            })
        })
    </script>
@endscript @endif
