@extends('components.main-layout.app')

@section('title') <img src="assets/img/logo.png" alt="logo" class="logo"> @endsection
@section('right')
    <div class="right">
        <a wire:navigate href="{{ route('me') }}" class="headerButton">
            <img src="{{ asset('assets/img/avatar.jpg') }}" alt="image" class="imaged w32">
        </a>
    </div>
@endsection

@section('content')
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
                    <div class="stat-box" data-bs-toggle="modal" data-bs-target="#cryptoModal">
                        <div class="title">Tiền điện tử</div>
                        <div id="t-crypto_balance" class="value text-warning">**********</div>
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
                        <div class="title">Dư nợ MoMo</div>
                        <div id="t-outstanding_credit" class="value text-primary">**********</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="stat-box">
                        <div class="title">Dư nợ VIB</div>
                        <div id="t-outstanding_vib" class="value text-primary">**********</div>
                    </div>
                </div>
{{--                <div class="col-6">--}}
{{--                    <div class="stat-box">--}}
{{--                        <div class="title">Đánh bạc</div>--}}
{{--                        <div id="t-onus_future_balance" class="value text-danger">**********</div>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>
        </div>

        <div class="section mt-4">
            <div class="section-heading">
                <h2 class="title">Phân bổ tài sản</h2>
            </div>
            <div class="card">
                <div class="card-body">
                    <div id="chart"></div>
                </div>
            </div>
        </div>

        <div class="section mt-4 mb-3">
            <div class="section-heading">
                <h2 class="title">Thu/Chi</h2>
            </div>
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs capsuled" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#t" role="tab">
                                T
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#w" role="tab">
                                W
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#m" role="tab">
                                M
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#lm" role="tab">
                                LM
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#y" role="tab">
                                Y
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content mt-1">
                        <div class="tab-pane fade show active" id="t" role="tabpanel">
                            <div class="row mt-2">
                                <div class="col-6">
                                    <div class="title">Thu</div>
                                    <h2 class="text-success">{!! formatVND($this->overview->earn_today) !!}</h2>
                                </div>
                                <div class="col-6">
                                    <div class="title">Chi</div>
                                    <h2 class="text-danger">{!! formatVND($this->overview->spend_today) !!}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="w" role="tabpanel">
                            <div class="row mt-2">
                                <div class="col-6">
                                    <div class="title">Thu</div>
                                    <h2 class="text-success">{!! formatVND($this->overview->earn_week) !!}</h2>
                                </div>
                                <div class="col-6">
                                    <div class="title">Chi</div>
                                    <h2 class="text-danger">{!! formatVND($this->overview->spend_week) !!}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="m" role="tabpanel">
                            <div class="row mt-2">
                                <div class="col-6">
                                    <div class="title">Thu</div>
                                    <h2 class="text-success">{!! formatVND($this->overview->earn_month) !!}</h2>
                                </div>
                                <div class="col-6">
                                    <div class="title">Chi</div>
                                    <h2 class="text-danger">{!! formatVND($this->overview->spend_month) !!}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="lm" role="tabpanel">
                            <div class="row mt-2">
                                <div class="col-6">
                                    <div class="title">Thu</div>
                                    <h2 class="text-success">{!! formatVND($this->overview->last_month_earn) !!}</h2>
                                </div>
                                <div class="col-6">
                                    <div class="title">Chi</div>
                                    <h2 class="text-danger">{!! formatVND($this->overview->last_month_spend) !!}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="y" role="tabpanel">
                            <div class="row mt-2">
                                <div class="col-6">
                                    <div class="title">Thu</div>
                                    <h2 class="text-success">{!! formatVND($this->overview->earn_year) !!}</h2>
                                </div>
                                <div class="col-6">
                                    <div class="title">Chi</div>
                                    <h2 class="text-danger">{!! formatVND($this->overview->spend_year) !!}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="cryptoModal" data-bs-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Danh mục đầu tư</h3>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table" style="font-size: 16px">
                            <thead>
                            <tr>
                                <th scope="col" class="text-center">Xu</th>
                                <th scope="col">Lúc Mua</th>
                                <th scope="col" class="text-end">Lợi Nhuận</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($crypto_coins as $coin)
                                <tr class="align-middle">
                                    <td class="text-center">
                                        <img src="{{ $coin['img'] }}" class="imaged w36">
                                    </td>
                                    <td class="price">
                                        {!! formatVND($coin['price']) !!}
                                        <br>
                                        {{ $coin['quantity'].' '.$coin['name'] }}
                                    </td>
                                    <td class="text-end text-{{ $coin['color'] }}">
                                        {!! formatVND($coin['profit'], $coin['color']) !!}
                                        <br>
                                        {{ $coin['percent'] }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-inline">
                        <a href="#" class="btn btn-primary" data-bs-dismiss="modal">ĐÓNG</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@assets
    <script src="{{ asset('assets/js/plugins/apexcharts/apexcharts.min.js') }}" defer></script>
@endassets
@script
    <script>
        $('#btn-toggle_show').on('click', function () {
            const iconToggle = $(this).find('ion-icon')
            if (iconToggle.attr('name') === 'eye-outline') {
                iconToggle.attr('name', 'eye-off-outline')
                $('#t-balance').html('{!! formatVND($balance) !!}')
                $('#t-cash_balance').html('{!! formatVND($cash_balance) !!}')
                $('#t-outstanding_credit').html('{!! formatVND($outstanding_credit) !!}')
                $('#t-outstanding_vib').html('{!! formatVND($outstanding_vib) !!}')
                $('#t-crypto_balance').html('{!! formatVND($crypto_balance) !!}')
                $('#t-onus_balance').html('{!! formatVND($onus_balance) !!}')
                $('#t-onus_farming_balance').html('{!! formatVND($onus_farming_balance) !!}')
                $('#t-onus_future_balance').html('{!! formatVND($onus_future_balance) !!}')
            } else {
                iconToggle.attr('name', 'eye-outline')
                $('#t-balance').html('**********')
                $('#t-cash_balance').html('**********')
                $('#t-outstanding_credit').html('**********')
                $('#t-outstanding_vib').html('**********')
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
@endscript
