@extends('theme.master')

@section('title') Crypto Market @endsection

@section('body')
    <div class="body d-flex py-3">
        <div class="container-xxl">

            <div class="row g-3 mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- TradingView Widget BEGIN -->
                            <div class="tradingview-widget-container">
                                <div id="tradingview_e05b7" style="height: 610px;"></div>
                            </div>
                            <!-- TradingView Widget END -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')


    <script src="assets/bundles/libscripts.bundle.js"></script>

    <script src="assets/bundles/dataTables.bundle.js"></script>
    <script  src="https://s3.tradingview.com/tv.js"></script>

    <script src="assets/js/template.js"></script>
    <script  src="assets/js/page/exchange.js"></script>

@endsection
