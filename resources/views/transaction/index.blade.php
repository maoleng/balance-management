@extends('theme.master')

@section('title') Transaction @endsection

@section('body')
    <div class="body d-flex py-3">
        <div class="container-xxl">
            @if ($errors->any())
                {!! implode('', $errors->all('<h3>:message</h3>')) !!}
            @endif
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
                                        {!! formatVND($transaction->price) !!}
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
                                    <span>{{ $transaction->reason->label ?? null }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span>{{ $transaction->prettyCreatedAt }}</span>
                                </div>
                            </td>
                            <td class="dt-body-right sorting_1">
                                <div class="btn-group" role="group">
                                    @if ($transaction->reason->is_group)
                                        <a href="{{ $transaction }}" class="btn btn-outline-info text-uppercase">
                                            <i class="icofont-eye-alt text-nowrap"></i>
                                        </a>
                                    @endif
                                    <form action="{{ route('transaction.destroy', ['transaction' => $transaction]) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-secondary deleterow"><i class="icofont-ui-delete text-danger"></i></button>
                                    </form>
                                </div>
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
    <script src="assets/bundles/dataTables.bundle.js"></script>
    <script src="assets/js/template.js"></script>

    <script>
        $('.sl-reason').on('click', function () {
            $('#i-reason').val($(this).data('id'))
            $('#sl-reason').text($(this).text())
        })
        $('.btn-earn').on('click', function () {
            $('#i-type').val($(this).data('type'))
        })



    </script>
@endsection
