@extends('theme.master')

@section('title') Dashboard @endsection

@section('body')
    <div class="body d-flex py-3">
        <div class="container-xxl">
{{--            <div class="row g-3 mb-3 row-cols-1 row-cols-md-2 row-cols-lg-4">--}}
{{--                <div class="col">--}}
{{--                    <div class="card">--}}
{{--                        <div class="card-body d-flex align-items-center">--}}
{{--                            <div class="flex-fill text-truncate">--}}
{{--                                <span class="text-uppercase">Cash</span>--}}
{{--                                <div class="d-flex flex-column">--}}
{{--                                    <div class="price-block">--}}
{{--                                        <h3 class="fw-bold color-price-up">--}}
{{--                                            50,000,000--}}
{{--                                            <small class="text-muted small">VND</small>--}}
{{--                                        </h3>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div id="sparkBalance1"></div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
            <div class="row g-3 mb-3 row-deck">
                <div class="col-xl-12 col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-header bg-primary border-bottom-0 py-3">
                            <h6 class="card-title mb-0 text-light">My Wallet</h6>
                        </div>

                        <div class="row card-body">
                            <div class="col-lg-7 row">
                                <div class="col-lg-1">
                                    <button id="btn-toggle_balance" class="btn btn-outline-primary">
                                        <i id="i-toggle_balance" style="vertical-align: middle;" class="icofont-eye-alt"></i>
                                    </button>
                                </div>
                                <div class="col-lg-5">
                                    <div>Balance</div>
                                    <h3>
                                        <span id="t-balance">*************</span>
                                    </h3>
                                </div>
                                <div class="col-lg-5">
                                    <div>Outstanding Credit</div>
                                    <h3>
                                        <span id="t-outstanding_credit">*************</span>
                                    </h3>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <table class="table table-hover table-bordered">
                                    <tr>
                                        <td style="width: 40%">
                                            <div class="mt-3 text-uppercase text-muted small">Cash</div>
                                            <h5><span id="t-cash_balance">*************</span></h5>
                                        </td>
                                        <td style="width: 60%">
                                            <div id="sparkBalance1"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 40%">
                                            <div class="mt-3 text-uppercase text-muted small">Crypto</div>
                                            <h5><span id="t-crypto_balance">*************</span></h5>
                                        </td>
                                        <td style="width: 60%">
                                            <div id="sparkBalance2"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 40%">
                                            <div class="mt-3 text-uppercase text-muted small">ONUS</div>
                                            <h5><span id="t-onus_balance">*************</span></h5>
                                        </td>
                                        <td style="width: 60%">
                                            <div id="sparkBalance3"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 40%">
                                            <div class="mt-3 text-uppercase text-muted small">ONUS Farming</div>
                                            <h5><span id="t-onus_farming_balance">*************</span></h5>
                                        </td>
                                        <td style="width: 60%">
                                            <div id="sparkBalance4"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 40%">
                                            <div class="mt-3 text-uppercase text-muted small">ONUS Future</div>
                                            <h5><span id="t-onus_future_balance">*************</span></h5>
                                        </td>
                                        <td style="width: 60%">
                                            <div id="sparkBalance5"></div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-lg-6">
                                <div id="chart"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-12">
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
    </div>
@endsection
@section('script')
    <script src="assets/bundles/libscripts.bundle.js"></script>
    <script src="assets/bundles/apexcharts.bundle.js"></script>
    <script src="assets/js/template.js"></script>
    <script>
        $(document).ready(function() {
            $('#btn-toggle_balance').on('click', function () {
                const cur = $('#i-toggle_balance').hasClass('icofont-eye-alt')
                if (cur === true) {
                    $('#i-toggle_balance').removeClass('icofont-eye-alt').addClass('icofont-eye-blocked')
                    $('#t-balance').html('{!! formatVND($balance) !!}')
                    $('#t-cash_balance').html('{!! formatVND($cash_balance) !!}')
                    $('#t-outstanding_credit').html('{!! formatVND($outstanding_credit) !!}')
                    $('#t-crypto_balance').html('{!! formatVND($crypto_balance) !!}')
                    $('#t-onus_balance').html('{!! formatVND($onus_balance) !!}')
                    $('#t-onus_farming_balance').html('{!! formatVND($onus_farming_balance) !!}')
                    $('#t-onus_future_balance').html('{!! formatVND($onus_future_balance) !!}')
                } else {
                    $('#i-toggle_balance').removeClass('icofont-eye-blocked').addClass('icofont-eye-alt')
                    $('#t-balance').html('*************')
                    $('#t-cash_balance').html('*************')
                    $('#t-outstanding_credit').html('*************')
                    $('#t-crypto_balance').html('*************')
                    $('#t-onus_balance').html('*************')
                    $('#t-onus_farming_balance').html('*************')
                    $('#t-onus_future_balance').html('*************')
                }
            })

            const sparkOption1 = getSparkOption([{{ implode(',', $cash_chart) }}])
            const spark1 = new ApexCharts(document.querySelector("#sparkBalance1"), sparkOption1)
            spark1.render()

            const sparkOption2 = getSparkOption([{{ implode(',', $crypto_chart) }}])
            const spark2 = new ApexCharts(document.querySelector("#sparkBalance2"), sparkOption2)
            spark2.render()

            const sparkOption3 = getSparkOption([{{ implode(',', $onus_chart) }}])
            const spark3 = new ApexCharts(document.querySelector("#sparkBalance3"), sparkOption3)
            spark3.render()

            const sparkOption4 = getSparkOption([{{ implode(',', $onus_farming_chart) }}])
            const spark4 = new ApexCharts(document.querySelector("#sparkBalance4"), sparkOption4)
            spark4.render()

            const sparkOption5 = getSparkOption([{{ implode(',', $onus_farming_chart) }}])
            const spark5 = new ApexCharts(document.querySelector("#sparkBalance5"), sparkOption5)
            spark5.render()

            const options = {
                series: [{{ "$cash_balance, $crypto_balance, $onus_balance, $onus_farming_balance, $onus_future_balance" }}],
                chart: {
                    type: 'donut',
                    height: 400,
                },
                responsive: [{
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }],
                labels: ['Cash', 'Crypto', 'ONUS', 'ONUS Farming', 'ONUS Future'],
                dataLabels: {
                    textAnchor: 'middle',
                    distributed: false,
                    offsetX: 0,
                    offsetY: 0,
                    style: {
                        fontSize: '16px',
                        fontFamily: 'Helvetica, Arial, sans-serif',
                        fontWeight: 600,
                        colors: ['white']
                    },
                    background: {
                        enabled: true,
                        foreColor: 'black',
                        padding: 5,
                        borderRadius: 2,
                        borderWidth: 1,
                        borderColor: '#fff',
                        opacity: 1,
                        dropShadow: {
                            enabled: true,
                            top: 1,
                            left: 1,
                            blur: 1,
                            color: '#000',
                            opacity: 1
                        }
                    },
                    dropShadow: {
                        enabled: false,
                    }
                }
            };

            const chart = new ApexCharts(document.querySelector("#chart"), options);
            chart.render();

            function getSparkOption(data)
            {
                return {
                    chart: {
                        id: 'spark1',
                        group: 'sparks',
                        type: 'line',
                        height: 80,
                        sparkline: {
                            enabled: true
                        },
                        dropShadow: {
                            enabled: true,
                            top: 1,
                            left: 1,
                            blur: 2,
                            opacity: 0.2,
                        },

                    },
                    series: [{
                        data: data
                    }],
                    stroke: {
                        curve: 'smooth'
                    },
                    markers: {
                        size: 0,
                    },
                    grid: {
                        padding: {
                            top: 20,
                            bottom: 10,
                        }
                    },
                    colors: ['#fff'],
                    tooltip: {
                        x: {
                            show: false
                        },
                        y: {
                            title: {
                                formatter: function formatter(val) {
                                    return '';
                                }
                            }
                        },
                        theme: 'dark',
                    },
                }
            }
        });
    </script>
@endsection
