@php use App\Enums\ReasonLabel; @endphp
@extends('theme.master')

@section('title')
    Transaction
@endsection

@section('body')
    <div class="body d-flex py-3">
        <div class="container-xxl">
            {!! showMessage() !!}
            <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0 align-items-center flex-wrap">
                <button type="button" class="btn btn-outline-primary btn-lg" data-bs-toggle="modal" data-bs-target="#addCoinModal">Create Transaction</button>
                <div class="modal fade modal-sm" id="addCoinModal" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <form action="{{ route('transaction.store') }}" method="post" class="modal-content">
                            @include('transaction.form')
                        </form>
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
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($transactions as $transaction)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if ($transaction->type === 0)
                                        <span class="badge bg-danger">-</span>&nbsp; &nbsp;
                                    @elseif ($transaction->type === 1)
                                        <span class="badge bg-secondary">+</span>&nbsp; &nbsp;
                                    @else
                                        <span class="badge bg-careys-pink">@</span>&nbsp; &nbsp;
                                    @endif
                                    <span class="font-weight-bold @if ($transaction->type === 0) 'text-danger' @elseif ($transaction->type === 1) : 'text-secondary' @else 'bg-careys-pink' @endif ">
                                        @if ($transaction->reason?->is_group)
                                            {!! formatVND($transaction->totalPrice) !!}
                                        @else
                                            {!! formatVND($transaction->price) !!}
                                        @endif
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span>{{ $transaction->reason->name ?? null }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if ($transaction->reason?->is_group)
                                        <a href="{{ $transaction }}" data-bs-toggle="modal" data-bs-target="#m-{{ $transaction->id }}" class="btn btn-outline-info text-uppercase">
                                            <i class="icofont-eye-alt text-nowrap"></i>
                                        </a>
                                    @else
                                        {!! ReasonLabel::getBadge($transaction->reason?->label) !!}
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span>{{ $transaction->prettyCreatedAt }}</span>
                                </div>
                            </td>
                            <td class="dt-body-right sorting_1">
                                <form action="{{ route('transaction.destroy', ['transaction' => $transaction]) }}" method="post">
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
        @if ($transaction->reason?->is_group)
            <div class="modal fade" id="m-{{ $transaction->id }}" tabindex="-1" aria-labelledby="exampleModalLgLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-xl">
                    <form action="{{ route('transaction.update-group-transaction') }}" method="post" class="modal-content">
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
                                                    <input name="quantities[]" type="number" class="form-control" value="{{ $sub_transaction->quantity }}" required="">
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
        $('.sl-reason').on('click', function () {
            $('#i-reason').val($(this).data('id'))
            $('#sl-reason').text($(this).text())
        })
        $('.btn-earn').on('click', function () {
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
                            <input name="quantities[]" type="number" class="form-control" required="">
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
