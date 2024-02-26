@section('header')
    <div class="appHeader bg-primary text-light">
        <div class="pageTitle">
            <img src="assets/img/logo.png" alt="logo" class="logo">
        </div>
        <div class="right">
            <a wire:navigate href="{{ route('me') }}" class="headerButton">
                <img src="{{ authed()->avatar }}" alt="image" class="imaged w32">
            </a>
        </div>
    </div>
@endsection
<div id="appCapsule">
    <div class="section wallet-card-section pt-1">
        <div class="wallet-card">
            <div class="balance">
                <div class="left">
                    <span class="title">Tổng số dư</span>
                    <h1 id="t-balance" class="total">**********</h1>
                </div>
                <div class="right">
                    <button id="btn-toggle_show" type="button" class="btn btn-icon btn-outline-primary me-1">
                        <ion-icon id="" name="eye-outline" role="img" class="md hydrated" aria-label="newspaper outline"></ion-icon>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="section">
        <div class="row mt-2">
            <div class="col-6">
                <div class="stat-box">
                    <div class="title">Tiền mặt</div>
                    <div id="t-cash_balance" class="value text-success">**********</div>
                </div>
            </div>
            <div class="col-6">
                <div class="stat-box">
                    <div class="title">Dư nợ tín dụng</div>
                    <div id="t-outstanding_credit" class="value text-primary">**********</div>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-6">
                <div class="stat-box">
                    <div class="title">Tiết kiệm</div>
                    <div id="t-onus_balance" class="value text-secondary">**********</div>
                </div>
            </div>
            <div class="col-6">
                <div class="stat-box">
                    <div class="title">Tiết kiệm dài hạn</div>
                    <div id="t-onus_farming_balance" class="value text-info">**********</div>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-6">
                <div class="stat-box">
                    <div class="title">Tiền điện tử</div>
                    <div id="t-crypto_balance" class="value text-warning">**********</div>
                </div>
            </div>
            <div class="col-6">
                <div class="stat-box">
                    <div class="title">Đánh bạc</div>
                    <div id="t-onus_future_balance" class="value text-danger">**********</div>
                </div>
            </div>
        </div>
    </div>

    <div class="section mt-2 mb-3">
        <div class="section-title">Phân bổ tài sản</div>
        <div class="card">
            <div class="card-body">
                <div id="chart"></div>
            </div>
        </div>
    </div>
</div>
@push('script')
    <script src="{{ asset('assets/js/plugins/apexcharts/apexcharts.min.js') }}"></script>
    <script>
        $('#btn-toggle_show').on('click', function () {
            const iconToggle = $(this).find('ion-icon')
            if (iconToggle.attr('name') === 'eye-outline') {
                iconToggle.attr('name', 'eye-off-outline')
                $('#t-balance').html('{!! formatVND($balance) !!}')
                $('#t-cash_balance').html('{!! formatVND($cash_balance) !!}')
                $('#t-outstanding_credit').html('{!! formatVND($outstanding_credit) !!}')
                $('#t-crypto_balance').html('{!! formatVND($crypto_balance) !!}')
                $('#t-onus_balance').html('{!! formatVND($onus_balance) !!}')
                $('#t-onus_farming_balance').html('{!! formatVND($onus_farming_balance) !!}')
                $('#t-onus_future_balance').html('{!! formatVND($onus_future_balance) !!}')
            } else {
                iconToggle.attr('name', 'eye-outline')
                $('#t-balance').html('**********')
                $('#t-cash_balance').html('**********')
                $('#t-outstanding_credit').html('**********')
                $('#t-crypto_balance').html('**********')
                $('#t-onus_balance').html('**********')
                $('#t-onus_farming_balance').html('**********')
                $('#t-onus_future_balance').html('**********')
            }
        })
        var options = {
            series: [{{ "$cash_balance, $onus_balance, $onus_farming_balance, $crypto_balance, $onus_future_balance" }}],
            chart: {
                type: 'donut',
            },
            legend: {
                show: false
            },
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
            },
            labels: ['Tiền mặt', 'Tiết kiệm', 'Tiết kiệm dài hạn', 'Tiền điện tử', 'Đánh bạc'],
            colors: ['#28a745', '#6c757d', '#17a2b8', '#ffc107', '#dc3545'],
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    </script>
@endpush
