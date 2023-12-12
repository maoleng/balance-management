@php use App\Enums\ReasonType @endphp
@extends('theme.master')

@section('title')
    Transaction > ONUS
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
                                            <form action="{{ route('transaction.onus.store') }}" method="post" class="modal-content">
                                                @include('transaction.onus.form')
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
                        <th>Coin</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($transactions as $transaction)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if (in_array($transaction->reason->type, [ReasonType::ONUS_TO_CASH, ReasonType::ONUS_TO_ONUS_FUTURE], true))
                                        <span class="badge bg-danger">-</span>&nbsp; &nbsp;
                                    @elseif (in_array($transaction->reason->type, [ReasonType::ONUS_TO_ONUS_FARMING, ReasonType::ONUS_FARMING_TO_ONUS, ReasonType::FUTURE_REVENUE_ONUS], true))
                                        <span class="badge bg-buy">~</span>&nbsp; &nbsp;
                                    @else
                                        <span class="badge bg-secondary">+</span>&nbsp; &nbsp;
                                    @endif
                                    <span class="font-weight-bold @if ($transaction->reason->type === ReasonType::ONUS_TO_CASH) 'text-danger' @else 'text-secondary' @endif ">
                                        {!! formatVND($transaction->price) !!}
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span>{{ $transaction->reason->name }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span>{{ $transaction->coinName }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span>{{ $transaction->prettyCreatedAt }}</span>
                                </div>
                            </td>
                            <td class="dt-body-right sorting_1">
                                <form action="{{ route('transaction.onus.destroy', ['transaction' => $transaction]) }}" method="post">
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

@endsection

@section('script')
    <script src="{{ asset('assets/js/template.js') }}"></script>
    <script>
        $("input[type='radio'][name='type']").on('click', function () {
            const reasons = '{{ implode(',', [ReasonType::ONUS_TO_ONUS_FARMING, ReasonType::ONUS_FARMING_TO_ONUS, ReasonType::FARM_REVENUE_ONUS]) }}'.split(',')
            if (reasons.includes($(this).val())) {
                $('#div-coin').remove()
                $('.modal-body').append(`
                    <div id="div-coin" class="row pt-3 pb-3">
                        <div class="col-md-12">
                            <label for="firstname" class="form-label">Coin</label>
                            <input type="text" class="form-control" name="coin" required="">
                        </div>
                    </div>
                `)
            } else {
                $('#div-coin').remove()
            }
        })
    </script>

@endsection
