@php use App\Enums\ReasonLabel @endphp
@php use App\Enums\ReasonType @endphp
@extends('theme.master')

@section('title')
    Transaction > Cash
@endsection

@section('body')
    <div class="body d-flex py-3">
        <div class="container-xxl">
            {!! showMessage() !!}
            <div class="col-12">
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-xxl-9 col-lg-8 col-md-8">
                                <div class="form-floating">
                                    <button type="button" class="btn btn-outline-primary btn-lg" data-bs-toggle="modal" data-bs-target="#createTransactionModal">Create Transaction</button>
                                    <div class="modal fade modal-sm" id="createTransactionModal" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <form action="{{ route('transaction.cash.store') }}" method="post" class="modal-content">
                                                @include('transaction.cash.form')
                                            </form>
                                        </div>
                                    </div>
                                    <button type="button" class="ms-3 btn btn-outline-primary btn-lg" data-bs-toggle="modal" data-bs-target="#creditSettlement">Credit Settlement</button>
                                    <div class="modal fade modal-sm" id="creditSettlement" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <form action="{{ route('transaction.cash.store', ['type' => ReasonType::CREDIT_SETTLEMENT, 'is_credit' => false]) }}" method="post" class="modal-content">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalCenterTitle">Add Transaction</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="row pt-3 pb-3">
                                                            <div class="col-md-12">
                                                                <label for="firstname" class="form-label">Amount</label>
                                                                <input type="number" class="form-control" name="price" required="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button class="btn btn-primary">Create</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-3 col-sm-6">
                                <div class="p-3">
                                    <div class="pb-3 text-muted text-uppercase"><i class="fa fa-circle me-2 text-danger"></i>Created At</div>
                                    <ul class="nav nav-tabs tab-body-header rounded d-inline-flex" role="tablist">
                                        <li class="nav-item" role="presentation"><a class="active nav-link" data-bs-toggle="tab" href="#btn-normal" role="tab" aria-selected="true">Today</a></li>
                                        <li class="nav-item" role="presentation"><a class="nav-link" data-bs-toggle="tab" href="#btn-group" role="tab" aria-selected="false" tabindex="-1">Custom</a></li>
                                    </ul>
                                    <input class="mt-3 form-control" type="date">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="p-3">
                                    <div class="pb-3 text-muted text-uppercase"></div>
                                    <div class="pt-4 text-muted text-uppercase">
                                        <button type="button" class="btn btn-lg btn-primary">Search</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <table id="p2pone" class="priceTable table table-hover custom-table table-bordered align-middle mb-0" style="width:100%">
                    <thead>
                    <tr>
                        <th>Amount</th>
                        <th>Reason</th>
                        <th>Label</th>
                        <th>Method</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($transactions as $transaction)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if (in_array($transaction->reason->type, [ReasonType::SPEND, ReasonType::GROUP, ReasonType::CREDIT_SETTLEMENT], true))
                                        <span class="badge bg-danger">-</span>&nbsp; &nbsp;
                                    @elseif ($transaction->reason->type === ReasonType::EARN)
                                        <span class="badge bg-secondary">+</span>&nbsp; &nbsp;
                                    @endif
                                    <span class="font-weight-bold @if ($transaction->reason->type === 0) 'text-danger' @else 'text-secondary' @endif ">
                                        @if ($transaction->reason?->type === ReasonType::GROUP)
                                            {!! formatVND($transaction->totalPrice) !!}
                                        @else
                                            {!! formatVND($transaction->price) !!}
                                        @endif
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ getFullPath($transaction->reason->image) }}" alt="" class="img-fluid avatar lg mx-1">
                                    <span>{{ $transaction->reason->name ?? null }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if ($transaction->reason?->type === ReasonType::GROUP)
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#m-{{ $transaction->id }}" class="btn btn-outline-info text-uppercase">
                                            <i class="icofont-eye-alt text-nowrap"></i>
                                        </a>
                                    @else
                                        {!! ReasonLabel::getBadge($transaction->reason?->label) !!}
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <h5 class="ps-1">
                                        @if ($transaction->isCredit) <span class="badge bg-sell">Credit</span> @else <span class="badge bg-buy">Cash</span> @endif
                                    </h5>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span>{{ $transaction->prettyCreatedAt }}</span>
                                </div>
                            </td>
                            <td class="dt-body-right sorting_1">
                                <form action="{{ route('transaction.cash.destroy', ['transaction' => $transaction]) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-secondary deleterow"><i class="icofont-ui-delete text-danger"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="pt-5">
                    {{ $transactions->links('vendor.pagination.paginator') }}
                </div>
            </div>
        </div>
    </div>

    @foreach($transactions as $transaction)
        @if ($transaction->reason?->type === ReasonType::GROUP)
            <div class="modal fade" id="m-{{ $transaction->id }}" tabindex="-1" aria-labelledby="exampleModalLgLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-xl">
                    <form action="{{ route('transaction.cash.update-group-transaction') }}" method="post" class="modal-content">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="transaction_id" value="{{ $transaction->id }}">
                        <div class="modal-header">
                            <h5 class="modal-title h4" id="exampleModalLgLabel">{{ $transaction->reason->name }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <table id="p2pone" class="priceTable table table-hover custom-table table-bordered align-middle mb-0" style="width:100%">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Total</th>
                                    <th>Label</th>
                                    <th>Delete</th>
                                </tr>
                                </thead>
                                <tbody class="tbody-group_transaction">
                                    @foreach ($transaction->transactions as $sub_transaction)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <select name="reason_ids[]" class="form-select">
                                                        @foreach($reasons as $reason)
                                                            <option {{ $sub_transaction->reason->id === $reason->id ? 'selected' : '' }} value="{{ $reason->id }}">{{ $reason->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <input name="quantities[]" class="form-control" value="{{ $sub_transaction->quantity }}" required="">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <input name="prices[]" type="number" class="form-control" value="{{ $sub_transaction->price }}" required="">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="font-weight-bold text-secondary">
                                                        {!! formatVND($sub_transaction->price * $sub_transaction->quantity) !!}
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="font-weight-bold text-secondary">
                                                        {!! ReasonLabel::getBadge($sub_transaction->reason?->label) !!}
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <input type="hidden" name="transaction_ids[]" value="{{ $sub_transaction->id }}">
                                                    <button type="button" class="btn-delete_transaction btn btn-outline-secondary deleterow"><i class="icofont-ui-delete text-danger"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex align-items-center p-3">
                            <button type="button" data-id="{{ $transaction->id }}" class="btn-add_transaction btn btn-outline-light">Add</button>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    @endforeach

@endsection

@section('script')
    <script src="{{ asset('assets/js/template.js') }}"></script>

    <script>
        $("#i-reason").on("input", function () {
            const searchText = $(this).val().toLowerCase();
            $(".a-reason").each(function () {
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
            $(".a-reason").each(function() {
                const type = $(this).data('type')
                const typeBtn = $(`a[data-type="${type}"].btn-type`)
                const reasonText = $(this).text().trim();
                if (reasonText === reason) {
                    typeBtn.addClass('active')
                    $('#i-type').val(type)
                    return false;
                } else {
                    typeBtn.removeClass('active')
                    $('#i-type').val('')
                }
            });
        })

        $('.btn-type').on('click', function () {
            $('#i-type').val($(this).data('type'))
        })
        $('.btn-add_transaction').on('click', function () {
            $(this).closest('div').prev().find('.tbody-group_transaction').append(`
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <select name="reason_ids[]" class="form-select">
                                @foreach($reasons as $reason)
                                    <option data-label="{{ $reason->label }}" value="{{ $reason->id }}">{{ $reason->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <input name="quantities[]" class="form-control" required="">
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <input name="prices[]" type="number" class="form-control" required="">
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <span class="font-weight-bold text-secondary"></span>
                        </div>
                    </td>
                    <td>
                        <div class="div-label d-flex align-items-center"></div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <input type="hidden" name="transaction_ids[]">
                            <button class="btn-delete_transaction btn btn-outline-secondary deleterow"><i class="icofont-ui-delete text-danger"></i></button>
                        </div>
                    </td>
                </tr>
            `)
        })
        $('.tbody-group_transaction').on('click', function (e) {
            if (e.target && e.target.classList.contains('btn-delete_transaction')) {
                const row = e.target.closest('tr');
                row.remove();
            }
        })
    </script>
@endsection
