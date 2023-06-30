@extends('theme.master')

@section('title') Invest @endsection

@section('body')

    <div class="body d-flex py-3">
        <div class="container-xxl">
        <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0 align-items-center flex-wrap">
            <button type="button" class="btn btn-outline-primary btn-lg" data-bs-toggle="modal" data-bs-target="#addCoinModal">Add more coin</button>
            <div class="modal fade" id="addCoinModal" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle">Add Coin's Notification</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="firstname" class="form-label">Coin</label>
                                    <input type="text" class="form-control" id="firstname" required="">
                                </div>
                                <div class="col-md-6">
                                    <label for="firstname" class="form-label">Amount</label>
                                    <input type="text" class="form-control" id="firstname" required="">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="firstname" class="form-label">Balance</label>
                                <input type="text" class="form-control" id="firstname" required="">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table id="p2pone" class="priceTable table table-hover custom-table table-bordered align-middle mb-0" style="width:100%">
                <thead>
                <tr>
                    <th>Coin</th>
                    <th>Amount</th>
                    <th>Balance</th>
                    <th>Revenue</th>
                    <th>Profit</th>
                    <th>Notify</th>
                    <th>Edit</th>
                    <th>Withdraw</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($notify_coins as $notify_coin)
                        <tr>
                            <td>
                                <img src="assets/images/coin/{{ $notify_coin->coin }}.png" alt="" class="img-fluid avatar mx-1">
                                {{ $notify_coin->coin }}
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span>{{ $notify_coin->prettyCoinAmount }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span>{{ $notify_coin->prettyBalance }} <small class="text-muted small">VND</small></span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span>160,034 <small class="text-muted small">VND</small></span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">

                                    <h5><span class="badge bg-secondary">+50%</span></h5>
                                </div>
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary" @if ($notify_coin->isNotify) disabled @endif>ON</button>
                            </td>
                            <td>
                                <button type="button" class="btn btn-light-success text-uppercase" data-bs-toggle="modal" data-bs-target="#exampleModalCenter">Edit</button>
                                <div class="modal fade" id="exampleModalCenter" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalCenterTitle">Edit investment</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="firstname" class="form-label">Amount</label>
                                                        <input type="text" class="form-control" id="firstname" required="">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="firstname" class="form-label">Balance</label>
                                                        <input type="text" class="form-control" id="firstname" required="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <button type="button" class="btn btn-outline-info text-uppercase">Withdraw</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    </div>
@endsection


@section('script')
    <script src="{{ asset('assets/bundles/dataTables.bundle.js') }}"></script>

    <script src="{{ asset('assets/js/template.js') }}"></script>
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
@endsection
