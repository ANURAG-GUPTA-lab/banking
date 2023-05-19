@extends('admin.layouts.app')
@section('panel')
    @if (@json_decode($general->system_info)->version > systemDetails()['version'])
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-header">
                        <h3 class="card-title"> @lang('New Version Available') <button class="btn btn--dark float-end">@lang('Version') {{ json_decode($general->system_info)->version }}</button> </h3>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-dark">@lang('What is the Update ?')</h5>
                        <p>
                            <pre class="f-size--24">{{ json_decode($general->system_info)->details }}</pre>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if (@json_decode($general->system_info)->message)
        <div class="row mb-3">
            @foreach (json_decode($general->system_info)->message as $msg)
                <div class="col-md-12">
                    <div class="alert border border--primary" role="alert">
                        <div class="alert__icon bg--primary"><i class="far fa-bell"></i></div>
                        <p class="alert__message">@php echo $msg; @endphp</p>
                        <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="row gy-4">
        <div class="col-xxl-3 col-sm-6">
            <x-widget style="2" bg="white" color="primary" icon="la la-users" title="Total Users" value="{{ $widget['total_users'] }}" link="{{ route('admin.users.all') }}" icon_style="solid" overlay_icon=0 />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-widget style=2 bg="white" color="success" icon="la la-user-check" title="Active Users" value="{{ $widget['verified_users'] }}" link="{{ route('admin.users.all') }}" icon_style="solid" overlay_icon=0 />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-widget style="2" bg="white" color="danger" icon="la la-envelope" title="Email Unverified Users" value="{{ $widget['email_unverified_users'] }}" link="{{ route('admin.users.email.unverified') }}" icon_style="solid" overlay_icon=0 />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-widget style="2" bg="white" color="danger" icon="la la-comment-slash" title="Mobile Unverified Users" value="{{ $widget['mobile_unverified_users'] }}" link="{{ route('admin.users.mobile.unverified') }}" icon_style="solid" overlay_icon=0 />
        </div>

        {{-- Deposit Widgets --}}

        <div class="col-xxl-3 col-sm-6">
            <x-widget style=2 bg="white" color="warning" icon="fas fa-spinner" title="Pending Deposits" value="{{ $widget['total_deposit_pending'] }}" link="{{ route('admin.deposit.pending') }}" icon_style="solid" overlay_icon=0 />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-widget style=2 bg="white" color="danger" icon="fas fa-ban" title="Rejected Deposits" value="{{ $widget['total_deposit_rejected'] }}" link="{{ route('admin.deposit.rejected') }}" icon_style="solid" overlay_icon=0 />
        </div>

        {{-- Withdraw Widgets --}}

        <div class="col-xxl-3 col-sm-6">
            <x-widget style=2 bg="white" color="6" icon="la la-sync" title="Pending Withdrawals" value="{{ $widget['total_withdraw_pending'] }}" link="{{ route('admin.withdraw.pending') }}" icon_style="solid" overlay_icon=0 />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-widget style=2 bg="white" color="danger" icon="las la-times-circle" title="Rejected Withdrawals" value="{{ $widget['total_withdraw_rejected'] }}" link="{{ route('admin.withdraw.rejected') }}" icon_style="solid" overlay_icon=0 />
        </div>

        {{-- Loan Widgets --}}

        <div class="col-xxl-3 col-sm-6">
            <x-widget style=2 bg="white" color="indigo" icon="las la-hand-holding-usd" title="Running Loan" value="{{ $widget['total_running_loan'] }}" link="{{ route('admin.loan.running') }}" icon_style="solid" overlay_icon=0 />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-widget style=2 bg="white" color="2" icon="las la-hand-holding-usd" title="Pending Loan" value="{{ $widget['total_pending_loan'] }}" link="{{ route('admin.loan.pending') }}" icon_style="solid" overlay_icon=0 />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-widget style=2 bg="white" color="5" icon="las la-hand-holding-usd" title="Due Loan" value="{{ $widget['total_due_loan'] }}" link="{{ route('admin.loan.due') }}" icon_style="solid" overlay_icon=0 />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-widget style=2 bg="white" color="success" icon="las la-hand-holding-usd" title="Paid Loan" value="{{ $widget['total_paid_loan'] }}" link="{{ route('admin.loan.paid') }}" icon_style="solid" overlay_icon=0 />
        </div>

        {{-- DPS Widgets --}}
        <div class="col-xxl-3 col-sm-6">
            <x-widget style=2 bg="white" color="info" icon="las la-coins" title="Total DPS" value="{{ $widget['total_dps'] }}" link="{{ route('admin.dps.index') }}" icon_style="solid" overlay_icon=0 />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-widget style=2 bg="white" color="warning" icon="las la-coins" title="Matured DPS" value="{{ $widget['total_matured_dps'] }}" link="{{ route('admin.dps.matured') }}" icon_style="solid" overlay_icon=0 />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-widget style=2 bg="white" color="danger" icon="las la-coins" title="Due DPS" value="{{ $widget['total_due_dps'] }}" link="{{ route('admin.dps.due') }}" icon_style="solid" overlay_icon=0 />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-widget style=2 bg="white" color="7" icon="las la-coins" title="Running DPS" value="{{ $widget['total_running_dps'] }}" link="{{ route('admin.dps.running') }}" icon_style="solid" overlay_icon=0 />
        </div>

        {{-- FDR Widgets --}}
        <div class="col-xxl-3 col-sm-6">
            <x-widget style=2 bg="white" color="18" icon="las la-store" title="Total FDR" value="{{ $widget['total_fdr'] }}" link="{{ route('admin.fdr.index') }}" icon_style="solid" overlay_icon=0 />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-widget style=2 bg="white" color="amber" icon="las la-store" title="Running FDR" value="{{ $widget['total_running_fdr'] }}" link="{{ route('admin.fdr.running') }}" icon_style="solid" overlay_icon=0 />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-widget style=2 bg="white" color="5" icon="las la-store" title="Due FDR" value="{{ $widget['total_due_fdr'] }}" link="{{ route('admin.fdr.due') }}" icon_style="solid" overlay_icon=0 />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-widget style=2 bg="white" color="green" icon="las la-store" title="Closed FDR" value="{{ $widget['total_closed_fdr'] }}" link="{{ route('admin.fdr.closed') }}" icon_style="solid" overlay_icon=0 />
        </div>
    </div>

    <div class="row gy-4 mt-2">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">@lang('Monthly Deposit & Withdraw Report') (@lang('Last 12 Month'))</h5>
                    <div id="monthly-dw-report"> </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">@lang('Transactions Report') (@lang('Last 30 Days'))</h5>
                    <div id="transaction-report"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row gy-4 mt-3">
        <div class="col-xl-4 col-lg-6">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <h5 class="card-title">@lang('Login By Browser') (@lang('Last 30 days'))</h5>
                    <canvas id="userBrowserChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">@lang('Login By OS') (@lang('Last 30 days'))</h5>
                    <canvas id="userOsChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">@lang('Login By Country') (@lang('Last 30 days'))</h5>
                    <canvas id="userCountryChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    @include('admin.partials.cron_instruction')

@endsection

@push('script-lib')
    <script src="{{ asset('assets/admin/js/vendor/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/vendor/chart.js.2.8.0.js') }}"></script>
    <script src="{{ asset('assets/admin/js/charts.js') }}"></script>
@endpush

@push('script')
    <script>
        "use strict";
        barChart(
            document.querySelector("#monthly-dw-report"),
            `{{ __($general->cur_text) }}`,
            [{
                    name: 'Deposited',
                    data: @json(@$chartData['deposits'])
                },
                {
                    name: 'Withdraw',
                    data: @json(@$chartData['withdrawals'])
                }
            ],
            @json($months)
        );

        lineChart(
            document.querySelector("#transaction-report"),
            [{
                    name: "Plus Transactions",
                    data: @json(@$chartData['plus_trx'])
                },
                {
                    name: "Minus Transactions",
                    data: @json(@$chartData['minus_trx'])
                }
            ],
            @json(@$chartData['trx_dates'])
        );

        piChart(
            document.getElementById('userBrowserChart'),
            @json(@$chartData['user_browser_counter']->keys()),
            @json(@$chartData['user_browser_counter']->flatten())
        );

        piChart(
            document.getElementById('userOsChart'),
            @json(@$chartData['user_os_counter']->keys()),
            @json(@$chartData['user_os_counter']->flatten())
        );

        piChart(
            document.getElementById('userCountryChart'),
            @json(@$chartData['user_country_counter']->keys()),
            @json(@$chartData['user_country_counter']->flatten())
        );
    </script>
@endpush
