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
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalCenterTitle">Add Transaction</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="firstname" class="form-label">Amount</label>
                                        <input type="number" class="form-control" name="price" required="">
                                    </div>
                                </div>
                                <div class="row pt-3 pb-3">
                                    <div class="col-md-12">
                                        <label for="firstname" class="form-label">Type</label>
                                        <br>
                                        <ul class="nav nav-tabs tab-body-header rounded d-inline-flex" role="tablist">
                                            <li class="nav-item" role="presentation"><a data-type="1" class="btn-earn nav-link active" data-bs-toggle="tab" href="#btn-normal" role="tab" aria-selected="true">Earn</a></li>
                                            <li class="nav-item" role="presentation"><a data-type="0" class="btn-earn nav-link" data-bs-toggle="tab" href="#btn-group" role="tab" aria-selected="false" tabindex="-1">Spend</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="row pt-3 pb-3">
                                    <label for="firstname" class="form-label">Reason</label>
                                    <div class="dropdown">
                                        <button class="btn btn-outline-primary dropdown-toggle" type="button" id="sl-reason" data-bs-toggle="dropdown" aria-expanded="false">
                                            Choose reason
                                        </button>
                                        <ul class="dropdown-menu border-0 shadow p-3">
                                            @foreach($reasons as $reason)
                                                <li><a data-id="{{ $reason->id }}" class="sl-reason dropdown-item py-2 rounded" href="#">{{ $reason->name }}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="form-label">Or create new reason</label>

                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input name="new_reason" class="form-control" placeholder="Reason...">
                                            <label>Reason</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">

                                        <div class="form-floating">
                                            <input name="new_reason_label" class="form-control" placeholder="Label">
                                            <label>Label</label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <input id="i-reason" type="hidden" name="reason_id">
                            <input id="i-type" type="hidden" name="type" value="1">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button class="btn btn-primary">Create</button>
                            </div>
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
                        <th>Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($transactions as $transaction)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if ($transaction->type === 0)
                                        <span class="badge bg-danger">-</span>&nbsp; &nbsp;
                                    @else
                                        <span class="badge bg-secondary">+</span>&nbsp; &nbsp;
                                    @endif
                                    <span class="font-weight-bold {{ $transaction->type === 0 ? 'text-danger' : 'text-secondary' }} ">
                                        {{ $transaction->prettyPrice }} <small class="text-muted small">VND</small>
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
                                    <span>{{ $transaction->reason->label }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span>{{ $transaction->prettyCreatedAt }}</span>
                                </div>
                            </td>
                            <td>
                                <form action="{{ route('transaction.destroy', ['transaction' => $transaction]) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-info text-uppercase">Delete</button>
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
    <script src="assets/bundles/dataTables.bundle.js"></script>

    <script src="assets/js/template.js"></script>
    <script>

        $('.myProjectTable').DataTable({
            responsive: true
        });

        $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust()
                .responsive.recalc();
        });
    </script>

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
