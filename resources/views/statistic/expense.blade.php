@extends('theme.master')

@section('title')
    Financial Management > Statistic
@endsection

@section('body')
    <div class="body d-flex py-3">
        <div class="container-xxl">
            <div class="card">
                <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom align-items-center flex-wrap">
                    <h6 class="mb-0 fw-bold">Statistic Expense By Category</h6>
                    <ul class="nav nav-tabs tab-body-header rounded d-inline-flex mt-2 mt-md-0" role="tablist">
                        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#stacked-bar" role="tab">Stacked Bar Chart</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tree-map" role="tab">Tree Map Chart</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#pie" role="tab">Pie Chart</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#polar-area" role="tab">Polar Area Chart</a></li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="mb-3 pb-3">
                            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                <input type="radio" class="btn-time btn-check" name="type" value="today" id="today" autocomplete="off" >
                                <label class="btn btn-outline-primary" for="today">Today</label>

                                <input type="radio" class="btn-time btn-check" name="type" value="this-week" id="this-week" autocomplete="off" >
                                <label class="btn btn-outline-primary" for="this-week">This week</label>

                                <input type="radio" class="btn-time btn-check" name="type" value="this-month" id="this-month" autocomplete="off" >
                                <label class="btn btn-outline-primary" for="this-month">This month</label>

                                <input type="radio" class="btn-time btn-check" name="type" value="this-year" id="this-year" autocomplete="off" >
                                <label class="btn btn-outline-primary" for="this-year">This year</label>

                                <input type="radio" class="btn-time btn-check" name="type" value="all" id="all" autocomplete="off" >
                                <label class="btn btn-outline-primary" for="all">All</label>
                            </div>
                        </div>
                        <div class="tab-pane fade show active" id="stacked-bar">
                            <div id="chart-stacked_bar"></div>
                        </div>
                        <div class="tab-pane fade" id="tree-map">
                            <div id="chart-tree_map"></div>
                        </div>
                        <div class="tab-pane fade" id="pie">
                            <div id="chart-pie"></div>
                        </div>
                        <div class="tab-pane fade" id="polar-area">

                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection

@section('script')
    <script src="{{ asset('assets/js/template.js') }}"></script>
    <script src="{{ asset('assets/bundles/apexcharts.bundle.js') }}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>
        $('input[name="daterange"]').daterangepicker({
            opens: 'left'
        }, function(start, end, label) {
            console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'))
        });

        const chartStackedBar = new ApexCharts(document.querySelector("#chart-stacked_bar"), getStackedBarOptions());
        chartStackedBar.render();

        const chartTreeMap = new ApexCharts(document.querySelector("#chart-tree_map"), getTreeMapOptions());
        chartTreeMap.render();

        const chartPie = new ApexCharts(document.querySelector("#chart-pie"), getPieOptions());
        chartPie.render();

        $('.btn-time').on('click', function () {
            $.ajax({
                url: `{{ route('statistic.index') }}?time=${$(this).val()}`,
            }).done(function(e) {
                chartStackedBar.updateOptions({
                    series: e['stacked-bar'].series,
                    xaxis: { categories: e['stacked-bar'].categories }
                })
                chartTreeMap.updateOptions({
                    series: e['tree-map'].series,
                    colors: e['tree-map'].colors,
                })
                chartPie.updateOptions({
                    series: e['pie'].series,
                    colors: e['pie'].colors,
                    labels: e['pie'].labels,
                    fill: {
                        image: {
                            src: e['pie'].images,
                        }
                    }
                })
            })
        })

        function getPieOptions()
        {
            return {
                series: [],
                labels: [],
                chart: {
                    height: 350,
                    type: 'pie',
                },
                colors: [],
                fill: {
                    type: 'image',
                    opacity: 0.85,
                    image: {
                        src: [],
                        width: 25,
                        imagedHeight: 25
                    },
                },
                stroke: {
                    width: 4
                },
                dataLabels: {
                    enabled: true,
                    style: {
                        colors: ['#111']
                    },
                    background: {
                        enabled: true,
                        foreColor: '#fff',
                        borderWidth: 0
                    }
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };
        }

        function getTreeMapOptions()
        {
            return {
                series: [],
                legend: {
                    show: false
                },
                chart: {
                    height: 350,
                    type: 'treemap'
                },
                title: {
                    text: 'Tree Map Chart',
                    align: 'center'
                },
                colors: [],
                plotOptions: {
                    treemap: {
                        distributed: true,
                        enableShades: false
                    }
                }
            };
        }

        function getStackedBarOptions()
        {
            return {
                series: [],
                chart: {
                    type: 'bar',
                    height: 350,
                    stacked: true,
                },
                plotOptions: {
                    bar: {
                        horizontal: true,
                        dataLabels: {
                            total: {
                                enabled: true,
                                offsetX: 0,
                                style: {
                                    fontSize: '13px',
                                    fontWeight: 900
                                }
                            }
                        }
                    },
                },
                stroke: {
                    width: 1,
                    colors: ['#fff']
                },
                title: {
                    text: 'Stacked Bar Chart',
                    align: 'center',
                },
                xaxis: {
                    categories: [],
                    labels: {
                        formatter: function (val) {
                            return val + "đ"
                        }
                    }
                },
                yaxis: {
                    title: {
                        text: undefined
                    },
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return val + "đ"
                        }
                    }
                },
                fill: {
                    opacity: 1
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'left',
                    offsetX: 40
                }
            };
        }

    </script>
@endsection
