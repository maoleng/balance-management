@extends('components.main-layout.app')

@section('title') Thống kê chi tiêu @endsection
@section('back') {{ route('statistic.index') }} @endsection

@section('content')
    <div id="appCapsule">
        <div class="section mt-2 mb-3">
            <div class="section-title">Theo danh mục</div>
            <div class="card">
                <div class="card-body">
                    <div class="btn-group" role="group">
                        <input type="radio" class="btn-check" name="chart" value="stacked-bar" id="stacked-bar" checked>
                        <label class="btn btn-outline-secondary" for="stacked-bar">Cột chồng</label>

                        <input type="radio" class="btn-check" name="chart" value="tree-map" id="tree-map">
                        <label class="btn btn-outline-secondary" for="tree-map">Cây</label>

                        <input type="radio" class="btn-check" name="chart" value="pie" id="pie">
                        <label class="btn btn-outline-secondary" for="pie">Tròn</label>
                    </div>
                    <div class="mt-1"></div>
                    <div class="btn-group" role="group">
                        <input type="radio" class="btn-time btn-check" name="type" value="today" id="today" autocomplete="off" >
                        <label class="btn btn-outline-primary" for="today">Hôm nay</label>

                        <input type="radio" class="btn-time btn-check" name="type" value="this-week" id="this-week" autocomplete="off" >
                        <label class="btn btn-outline-primary" for="this-week">Tuần này</label>

                        <input type="radio" class="btn-time btn-check" name="type" value="this-month" id="this-month" autocomplete="off" >
                        <label class="btn btn-outline-primary" for="this-month">Tháng này</label>
                    </div>
                    <div class="btn-group" role="group">
                        <input type="radio" class="btn-time btn-check" name="type" value="this-year" id="this-year" autocomplete="off" >
                        <label class="btn btn-outline-primary" for="this-year">Năm này</label>

                        <input type="radio" class="btn-time btn-check" name="type" value="all" id="all" autocomplete="off" >
                        <label class="btn btn-outline-primary" for="all">Tất cả</label>
                    </div>
                    <div id="chart-stacked_bar"></div>
                    <div id="chart-tree_map"></div>
                    <div id="chart-pie"></div>
                </div>
            </div>
        </div>
        <div class="section mt-2 mb-3">
            <div class="section-title">Theo lí do</div>
            <div class="card">
                <div class="card-body">
                    <div class="btn-group" role="group">
                        <input type="radio" class="btn-time-reason btn-check" name="type-reason" value="today" id="today-reason" autocomplete="off" >
                        <label class="btn btn-outline-primary" for="today-reason">Hôm nay</label>

                        <input type="radio" class="btn-time-reason btn-check" name="type-reason" value="this-week" id="this-week-reason" autocomplete="off" >
                        <label class="btn btn-outline-primary" for="this-week-reason">Tuần này</label>

                        <input type="radio" class="btn-time-reason btn-check" name="type-reason" value="this-month" id="this-month-reason" autocomplete="off" >
                        <label class="btn btn-outline-primary" for="this-month-reason">Tháng này</label>
                    </div>
                    <div class="btn-group" role="group">
                        <input type="radio" class="btn-time-reason btn-check" name="type-reason" value="this-year" id="this-year-reason" autocomplete="off" >
                        <label class="btn btn-outline-primary" for="this-year-reason">Năm này</label>

                        <input type="radio" class="btn-time-reason btn-check" name="type-reason" value="all" id="all-reason" autocomplete="off" >
                        <label class="btn btn-outline-primary" for="all-reason">Tất cả</label>
                    </div>
                    <div id="chart-tree_map-reason"></div>
                </div>
            </div>
        </div>
        <div class="section mt-2 mb-3">
            <div class="section-title">Theo nhãn</div>
            <div class="card">
                <div class="card-body">
                    <div class="btn-group" role="group">
                        <input type="radio" class="btn-time-label btn-check" name="type-label" value="today" id="today-label" autocomplete="off" >
                        <label class="btn btn-outline-primary" for="today-label">Hôm nay</label>

                        <input type="radio" class="btn-time-label btn-check" name="type-label" value="this-week" id="this-week-label" autocomplete="off" >
                        <label class="btn btn-outline-primary" for="this-week-label">Tuần này</label>

                        <input type="radio" class="btn-time-label btn-check" name="type-label" value="this-month" id="this-month-label" autocomplete="off" >
                        <label class="btn btn-outline-primary" for="this-month-label">Tháng này</label>
                    </div>
                    <div class="btn-group" role="group">
                        <input type="radio" class="btn-time-label btn-check" name="type-label" value="this-year" id="this-year-label" autocomplete="off" >
                        <label class="btn btn-outline-primary" for="this-year-label">Năm này</label>

                        <input type="radio" class="btn-time-label btn-check" name="type-label" value="all" id="all-label" autocomplete="off" >
                        <label class="btn btn-outline-primary" for="all-label">Tất cả</label>
                    </div>
                    <div id="chart-stacked_area"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@assets
<script src="{{ asset('assets/js/plugins/apexcharts/apexcharts.min.js') }}" defer></script>
<script src="{{ asset('assets/js/chart.js') }}" defer></script>
@endassets

@script
<script>
    statisticCategory()
    statisticReason()
    statisticLabel()

    function statisticLabel()
    {
        const chartStackedAreaLabel = new ApexCharts(document.querySelector("#chart-stacked_area"), getStackedAreaOptions());
        chartStackedAreaLabel.render();

        $('.btn-time-label').on('click', function () {
            $.ajax({
                url: `{{ route('statistic.fetch') }}?time=${$(this).val()}&type=expense-label`,
            }).done(function(e) {
                chartStackedAreaLabel.updateOptions({
                    series: e['stacked-area'],
                })
            })
        })
    }

    function statisticReason()
    {
        const chartTreeMapReason = new ApexCharts(document.querySelector("#chart-tree_map-reason"), getTreeMapOptions());
        chartTreeMapReason.render();

        $('.btn-time-reason').on('click', function () {
            $.ajax({
                url: `{{ route('statistic.fetch') }}?time=${$(this).val()}&type=expense-reason`,
            }).done(function(e) {
                chartTreeMapReason.updateOptions({
                    series: e['tree-map'].series,
                    colors: e['tree-map'].colors,
                })
            })
        })
    }

    function statisticCategory()
    {
        $('#chart-tree_map').attr('hidden', true)
        $('#chart-pie').attr('hidden', true)

        const chartStackedBar = new ApexCharts(document.querySelector("#chart-stacked_bar"), getStackedBarOptions());
        chartStackedBar.render();

        const chartTreeMap = new ApexCharts(document.querySelector("#chart-tree_map"), getTreeMapOptions());
        chartTreeMap.render();

        const chartPie = new ApexCharts(document.querySelector("#chart-pie"), getPieOptions());
        chartPie.render();

        $('.btn-time').on('click', function () {
            $.ajax({
                url: `{{ route('statistic.fetch') }}?time=${$(this).val()}&type=expense-category`,
            }).done(function(e) {
                const chart = $('input[name="chart"]:checked').val()
                $('#chart-stacked_bar').attr('hidden', true)
                $('#chart-tree_map').attr('hidden', true)
                $('#chart-pie').attr('hidden', true)
                if (chart === 'stacked-bar') {
                    $('#chart-stacked_bar').removeAttr('hidden')
                    chartStackedBar.updateOptions({
                        series: e[chart].series,
                        xaxis: { categories: e[chart].categories }
                    })
                } else if (chart === 'tree-map') {
                    $('#chart-tree_map').removeAttr('hidden')
                    chartTreeMap.updateOptions({
                        series: e[chart].series,
                        colors: e[chart].colors,
                    })
                } else {
                    $('#chart-pie').removeAttr('hidden')
                    chartPie.updateOptions({
                        series: e[chart].series,
                        colors: e[chart].colors,
                        labels: e[chart].labels,
                        fill: {
                            image: {
                                src: e[chart].images,
                            }
                        }
                    })
                }
            })
        })
    }
</script>
@endscript
