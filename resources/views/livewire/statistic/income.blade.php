@section('header')
    <div class="appHeader">
        <div class="left">
            <a wire:navigate href="{{ route('statistic.index') }}" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Thống kê thu nhập</div>
    </div>
@endsection
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
</div>
@assets
<script src="{{ asset('assets/js/plugins/apexcharts/apexcharts.min.js') }}" defer></script>
<script src="{{ asset('assets/js/chart.js') }}" defer></script>
@endassets

@script
<script>
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
            url: `{{ route('statistic.fetch') }}?time=${$(this).val()}&type=income`,
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
</script>
@endscript
