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
                    </div>
                </div>
            </div>
            <div class="card mt-5">
                <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom align-items-center flex-wrap">
                    <h6 class="mb-0 fw-bold">Statistic Expense By Reason</h6>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="mb-3 pb-3">
                            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                <input type="radio" class="btn-time-reason btn-check" name="type-reason" value="today" id="today-reason" autocomplete="off" >
                                <label class="btn btn-outline-primary" for="today-reason">Today</label>

                                <input type="radio" class="btn-time-reason btn-check" name="type-reason" value="this-week" id="this-week-reason" autocomplete="off" >
                                <label class="btn btn-outline-primary" for="this-week-reason">This week</label>

                                <input type="radio" class="btn-time-reason btn-check" name="type-reason" value="this-month" id="this-month-reason" autocomplete="off" >
                                <label class="btn btn-outline-primary" for="this-month-reason">This month</label>

                                <input type="radio" class="btn-time-reason btn-check" name="type-reason" value="this-year" id="this-year-reason" autocomplete="off" >
                                <label class="btn btn-outline-primary" for="this-year-reason">This year</label>

                                <input type="radio" class="btn-time-reason btn-check" name="type-reason" value="all" id="all-reason" autocomplete="off" >
                                <label class="btn btn-outline-primary" for="all-reason">All</label>
                            </div>
                        </div>
                        <div class="tab-pane fade show active" id="stacked-bar">
                            <div id="chart-tree_map-reason"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-5">
                <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom align-items-center flex-wrap">
                    <h6 class="mb-0 fw-bold">Stacked Expense By Label</h6>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="mb-3 pb-3">
                            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                <input type="radio" class="btn-time-label btn-check" name="type-label" value="today" id="today-label" autocomplete="off" >
                                <label class="btn btn-outline-primary" for="today-label">Today</label>

                                <input type="radio" class="btn-time-label btn-check" name="type-label" value="this-week" id="this-week-label" autocomplete="off" >
                                <label class="btn btn-outline-primary" for="this-week-label">This week</label>

                                <input type="radio" class="btn-time-label btn-check" name="type-label" value="this-month" id="this-month-label" autocomplete="off" >
                                <label class="btn btn-outline-primary" for="this-month-label">This month</label>

                                <input type="radio" class="btn-time-label btn-check" name="type-label" value="this-year" id="this-year-label" autocomplete="off" >
                                <label class="btn btn-outline-primary" for="this-year-label">This year</label>

                                <input type="radio" class="btn-time-label btn-check" name="type-label" value="all" id="all-label" autocomplete="off" >
                                <label class="btn btn-outline-primary" for="all-label">All</label>
                            </div>
                        </div>
                        <div class="tab-pane fade show active" id="stacked-bar">
                            <div id="chart-stacked_area"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/template.js') }}"></script>
    <script src="{{ asset('assets/bundles/apexcharts.bundle.js') }}"></script>
    <script src="{{ asset('assets/custom/script/chart.js') }}"></script>

    <script>
        const chartStackedBar = new ApexCharts(document.querySelector("#chart-stacked_bar"), getStackedBarOptions());
        chartStackedBar.render();

        const chartTreeMap = new ApexCharts(document.querySelector("#chart-tree_map"), getTreeMapOptions());
        chartTreeMap.render();

        const chartPie = new ApexCharts(document.querySelector("#chart-pie"), getPieOptions());
        chartPie.render();

        const chartTreeMapReason = new ApexCharts(document.querySelector("#chart-tree_map-reason"), getTreeMapOptions());
        chartTreeMapReason.render();

        const options = {
            chart: {
                height: 300,
                type: 'area',
                stacked: true,
                toolbar: {
                    show: false,
                },
                events: {
                    selection: function(chart, e) {
                        console.log(new Date(e.xaxis.min) )
                    }
                },
            },
            colors: ['blue', 'yellow', 'red'],
            dataLabels: {
                enabled: false
            },

            series: [],

            fill: {
                type: 'gradient',
                gradient: {
                    opacityFrom: 0.6,
                    opacityTo: 0.8,
                }
            },

            legend: {
                position: 'top',
                horizontalAlign: 'right',
                show: true,
            },
            xaxis: {
                type: 'datetime',
            },
            grid: {
                yaxis: {
                    lines: {
                        show: false,
                    }
                },
                padding: {
                    top: 20,
                    right: 0,
                    bottom: 0,
                    left: 0
                },
            },
            stroke: {
                show: true,
                curve: 'smooth',
                width: 2,
            },
        }

        const chartStackedAreaLabel = new ApexCharts(document.querySelector("#chart-stacked_area"), options);
        chartStackedAreaLabel.render();


        $('.btn-time-label').on('click', function () {
            $.ajax({
                url: `{{ route('statistic.index') }}?time=${$(this).val()}&type=expense-label`,
            }).done(function(e) {
                chartStackedAreaLabel.updateOptions({
                    series: e['stacked-area'],
                })
            })
        })

        $('.btn-time-reason').on('click', function () {
            $.ajax({
                url: `{{ route('statistic.index') }}?time=${$(this).val()}&type=expense-reason`,
            }).done(function(e) {
                chartTreeMapReason.updateOptions({
                    series: e['tree-map'].series,
                    colors: e['tree-map'].colors,
                })
            })
        })

        $('.btn-time').on('click', function () {
            $.ajax({
                url: `{{ route('statistic.index') }}?time=${$(this).val()}&type=expense-category`,
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

    </script>
@endsection
