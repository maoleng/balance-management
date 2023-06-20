@extends('theme.master')

@section('body')

    <div class="body d-flex py-3">
        <div class="container-xxl">

            <div class="row g-3 row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-2 row-cols-xl-4 mb-3">
                <div class="col">
                    <div class="card">
                        <div class="card-body d-flex align-items-center">
                            <div class="flex-fill text-truncate">
                                <span class="text-muted small text-uppercase">Top gainer (24h)</span>
                                <span class="h6 mt-3 mb-1 fw-bold d-block">DF/USDT</span>
                                <div class="d-flex justify-content-between">
                                    <div class="price-block">
                                        <span class="fs-6 fw-bold color-price-up">0.3165</span>
                                        <span class="small text-muted px-2">$0</span>
                                    </div>
                                    <div class="price-report">
                                        <span class="small text-success">+59.10% <i class="fa fa-level-up"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-body d-flex align-items-center">
                            <div class="flex-fill text-truncate">
                                <span class="text-muted small text-uppercase">Top loser (24h)</span>
                                <span class="h6 mt-3 mb-1 fw-bold d-block">XTZDOWN/USDT</span>
                                <div class="d-flex justify-content-between">
                                    <div class="price-block">
                                        <span class="fs-6 fw-bold color-price-down">2.831</span>
                                        <span class="small text-muted px-2">$3</span>
                                    </div>
                                    <div class="price-report">
                                        <span class="small text-danger">-40.87% <i class="fa fa-level-down"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-body d-flex align-items-center">
                            <div class="flex-fill text-truncate">
                                <span class="text-muted small text-uppercase">Highlight</span>
                                <span class="h6 mt-3 mb-1 fw-bold d-block">USDT/BIDR</span>
                                <div class="d-flex justify-content-between">
                                    <div class="price-block">
                                        <span class="fs-6 fw-bold">14,339</span>
                                        <span class="small text-muted px-2">$1</span>
                                    </div>
                                    <div class="price-report">
                                        <span class="small text-danger">-0.44% <i class="fa fa-level-down"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-body d-flex align-items-center">
                            <div class="flex-fill text-truncate">
                                <span class="text-muted small text-uppercase">GRT/USDT</span>
                                <span class="h6 mt-3 mb-1 fw-bold d-block">DOT/USDT</span>
                                <div class="d-flex justify-content-between">
                                    <div class="price-block">
                                        <span class="fs-6 fw-bold color-price-up">30.90</span>
                                        <span class="small text-muted px-2">$31</span>
                                    </div>
                                    <div class="price-report">
                                        <span class="small text-success">+3.66% <i class="fa fa-level-up"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- Row End -->


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
@endsection
