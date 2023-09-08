@extends('theme.master')

@section('title') Dashboard @endsection

@section('body')
    <div class="body d-flex py-3">
        <div class="container-xxl">
            <div class="row g-3 mb-3 row-deck">
                <div class="col-xl-7 col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-header bg-primary border-bottom-0 py-3">
                            <h6 class="card-title mb-0 text-light">My Wallet</h6>
                        </div>
                        <div class="row card-body">
                            <div class="col-lg-7">
                                <div>Balance</div>
                                <h3>{!! formatVND($cash_balance + $stock_balance) !!}</h3>
                                <div class="mt-3 pt-3 text-uppercase text-muted border-top pt-2 small">Stock Market
                                </div>
                                <h5>{!! formatVND($stock_balance) !!} ({!! formatVND($stock_profit) !!})</h5>
                                <div class="mt-3 text-uppercase text-muted small">Cash, Credit, E-Wallet, ...</div>
                                <h5>{!! formatVND($cash_balance) !!}</h5>
                            </div>
                            <div class="col-lg-5">
                                <div id="apex-circle-gradientfuture"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-5 col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-header bg-primary border-bottom-0 py-3">
                            <h6 class="card-title mb-0 text-light">Earn / Spend</h6>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs tab-body-header rounded d-inline-flex" role="tablist">
                                <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#Today" role="tab">Today</a></li>
                                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#Week" role="tab">Week</a></li>
                                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#Month" role="tab">Month</a></li>
                                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#Year" role="tab">Year</a></li>
                                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#All" role="tab">All</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="Today">
                                    <div>Earn</div>
                                    <h3>{!! formatVND($overview->earn_today) !!}</h3>
                                    <div>Spend</div>
                                    <h3>{!! formatVND($overview->spend_today) !!}</h3>
                                </div>
                                <div class="tab-pane fade" id="Week">
                                    <div>Earn</div>
                                    <h3>{!! formatVND($overview->earn_week) !!}</h3>
                                    <div>Spend</div>
                                    <h3>{!! formatVND($overview->spend_week) !!}</h3>
                                </div>
                                <div class="tab-pane fade" id="Month">
                                    <div>Earn</div>
                                    <h3>{!! formatVND($overview->earn_month) !!}</h3>
                                    <div>Spend</div>
                                    <h3>{!! formatVND($overview->spend_month) !!}</h3>
                                </div>
                                <div class="tab-pane fade" id="Year">
                                    <div>Earn</div>
                                    <h3>{!! formatVND($overview->earn_year) !!}</h3>
                                    <div>Spend</div>
                                    <h3>{!! formatVND($overview->spend_year) !!}</h3>
                                </div>
                                <div class="tab-pane fade" id="All">
                                    <div>Earn</div>
                                    <h3>{!! formatVND($overview->total_earn) !!}</h3>
                                    <div>Spend</div>
                                    <h3>{!! formatVND($overview->total_spend) !!}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
{{--        <div class="row g-3 mb-3 row-deck">--}}
{{--            <div class="col-xl-12 col-lg-6 col-md-12">--}}
{{--                <div class="card mb-3">--}}
{{--                    <div class="card-header d-flex justify-content-between align-items-center bg-transparent border-bottom-0">--}}
{{--                        <h6 class="m-0 fw-bold">Money Spent By Time</h6>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <div id="apex-chart-line-column"></div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="row g-3 mb-3 row-deck">--}}
{{--            <div class="col-xl-8 col-lg-6 col-md-12">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header d-flex justify-content-between align-items-center bg-transparent border-bottom-0">--}}
{{--                        <h6 class="m-0 fw-bold">Spent In What ?</h6>--}}
{{--                    </div>--}}
{{--                    <div class=" row card-body">--}}
{{--                        <div class="col-lg-6">--}}
{{--                            <div>Today</div>--}}
{{--                            <h3>5,156,467,500 VND</h3>--}}
{{--                            <div class="mt-3 pt-3 text-uppercase text-muted border-top pt-2 small">This week</div>--}}
{{--                            <h5>3,456,748,000 VND</h5>--}}
{{--                            <div class="mt-3 text-uppercase text-muted small">This month</div>--}}
{{--                            <h5>2,156,748,000 VND</h5>--}}
{{--                        </div>--}}
{{--                        <div class="col-lg-6">--}}
{{--                            <div id="apex-simple-donutp2p"></div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>
@endsection
@section('script')
    <script src="assets/bundles/libscripts.bundle.js"></script>
    <script src="assets/bundles/apexcharts.bundle.js"></script>
    <script src="assets/js/template.js"></script>
    <script src="assets/js/page/widget.js"></script>
    <script src="assets/js/page/chart-apex.js"></script>
    <script>
        $(document).ready(function() {
            var options = {
                chart: {
                    height: 300,
                    type: 'radialBar',
                    toolbar: {
                        show: false
                    }
                },
                colors: ['var(--chart-color1)'],
                plotOptions: {
                    radialBar: {
                        startAngle: -135,
                        endAngle: 225,
                        hollow: {
                            margin: 0,
                            size: '70%',
                            background: '#fff',
                            image: undefined,
                            imageOffsetX: 0,
                            imageOffsetY: 0,
                            position: 'front',

                            dropShadow: {
                                enabled: true,
                                top: 3,
                                left: 0,
                                blur: 4,
                                opacity: 0.24
                            }
                        },
                        track: {
                            background: '#fff',
                            strokeWidth: '67%',
                            margin: 0, // margin is in pixels
                            dropShadow: {
                                enabled: true,
                                top: -3,
                                left: 0,
                                blur: 4,
                                opacity: 0.35
                            }
                        },

                        dataLabels: {
                            showOn: 'always',
                            name: {
                                offsetY: -10,
                                show: true,
                                color: '#888',
                                fontSize: '17px'
                            },
                            value: {
                                formatter: function(val) {
                                    return parseInt(val);
                                },
                                color: '#111',
                                fontSize: '36px',
                                show: true,
                            }
                        }
                    }
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'dark',
                        type: 'horizontal',
                        shadeIntensity: 0.5,
                        gradientToColors: ['var(--chart-color2)'],
                        inverseColors: true,
                        opacityFrom: 1,
                        opacityTo: 1,
                        stops: [0, 100]
                    }
                },
                series: [{{ $percent_stock_balance }}],
                stroke: {
                    lineCap: 'round'
                },
                labels: ['Stock/Balance'],
            }

            var chart = new ApexCharts(
                document.querySelector("#apex-circle-gradientfuture"),
                options
            );

            chart.render();
        });

        // $(document).ready(function() {
        //     var options = {
        //         chart: {
        //             height: 350,
        //             type: 'line',
        //             toolbar: {
        //                 show: false,
        //             },
        //         },
        //         colors: ['var(--chart-color1)', 'var(--chart-color2)'],
        //         series: [{
        //             name: 'Website Blog',
        //             type: 'column',
        //             data: [440, 505, 414, 671, 227, 413, 201, 352, 752, 320, 257, 160]
        //         }, {
        //             name: 'Social Media',
        //             type: 'line',
        //             data: [23, 42, 35, 27, 43, 22, 17, 31, 22, 22, 12, 16]
        //         }],
        //         stroke: {
        //             width: [0, 4]
        //         },
        //         // labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        //         labels: ['01 Jan 2001', '02 Jan 2001', '03 Jan 2001', '04 Jan 2001', '05 Jan 2001', '06 Jan 2001', '07 Jan 2001', '08 Jan 2001', '09 Jan 2001', '10 Jan 2001', '11 Jan 2001', '12 Jan 2001'],
        //         xaxis: {
        //             type: 'datetime'
        //         },
        //         yaxis: [{
        //             title: {
        //                 text: 'Website Blog',
        //             },
        //
        //         }, {
        //             opposite: true,
        //             title: {
        //                 text: 'Social Media'
        //             }
        //         }]
        //     }
        //     var chart = new ApexCharts(
        //         document.querySelector("#apex-chart-line-column"),
        //         options
        //     );
        //
        //     chart.render();
        // });

        // $(document).ready(function() {
        //     var options = {
        //         chart: {
        //             height: 250,
        //             type: 'donut',
        //         },
        //         dataLabels: {
        //             enabled: false,
        //         },
        //         legend: {
        //             position: 'right',
        //             horizontalAlign: 'center',
        //             show: true,
        //         },
        //         colors: ['var(--chart-color5)', 'var(--chart-color4)', 'var(--chart-color3)'],
        //         series: [44, 55, 41],
        //         labels: ['Buy', 'Sell', 'Transfer'],
        //         responsive: [{
        //             breakpoint: 480,
        //             options: {
        //                 chart: {
        //                     width: 200
        //                 },
        //                 legend: {
        //                     position: 'bottom'
        //                 }
        //             }
        //         }]
        //     }
        //
        //     var chart = new ApexCharts(
        //         document.querySelector("#apex-simple-donutp2p"),
        //         options
        //     );
        //
        //     chart.render();
        // });
    </script>
@endsection
