@extends('theme.master')

@section('title')
    Financial Management > Statistic
@endsection

@section('body')
    <div class="body d-flex py-3">
        <div class="container-xxl">
            <div class="card">
                <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom align-items-center flex-wrap">
                    <h6 class="mb-0 fw-bold">Statistic Income By Reason</h6>
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

        $('.btn-time').on('click', function () {
            $.ajax({
                url: `{{ route('statistic.index') }}?time=${$(this).val()}&type=income`,
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
