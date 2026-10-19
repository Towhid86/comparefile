@extends('layouts.author.master')

@section('title')
    {{__('Dashboard') }}
@endsection

@section('main_content')
    <div class="container-fluid">
        <div class="gpt-dashboard-card counter-grid-6 mt-30 mb-30">
            <div class="couter-box">
                <div class="icons">
                    <img src="{{ asset('assets/img/icon/couter-icon-01.svg') }}" alt="">
                </div>
                <div class="content-side">
                    <h5 id="dashboard_app_new_user">1000</h5>
                    <p>New Registration</p>
                </div>
            </div>
            <div class="couter-box">
                <div class="icons">
                    <img src="{{ asset('assets/img/icon/couter-icon-01.svg') }}" alt="">
                </div>
                <div class="content-side">
                    <h5 id="dashboard_app_expired_shop">1000</h5>
                    <p>Expired shop</p>
                </div>
            </div>
            <div class="couter-box">
                <div class="icons">
                    <img src="{{ asset('assets/img/icon/couter-icon-01.svg') }}" alt="">
                </div>
                <div class="content-side">
                    <h5 id="dashboard_app_expired_shop">1000</h5>
                    <p>Free Plan</p>
                </div>
            </div>
            <div class="couter-box">
                <div class="icons">
                    <img src="{{ asset('assets/img/icon/couter-icon-01.svg') }}" alt="">
                </div>
                <div class="content-side">
                    <h5 id="dashboard_app_user">1000</h5>
                    <p>Monthly Plan</p>
                </div>
            </div>
            <div class="couter-box">
                <div class="icons">
                    <img src="{{ asset('assets/img/icon/couter-icon-01.svg') }}" alt="">
                </div>
                <div class="content-side">
                    <h5 id="dashboard_app_user">1000</h5>
                    <p>1 Year Plan</p>
                </div>
            </div>
            <div class="couter-box">
                <div class="icons">
                    <img src="{{ asset('assets/img/icon/couter-icon-01.svg') }}" alt="">
                </div>
                <div class="content-side">
                    <h5 id="dashboard_app_user">1000</h5>
                    <p>Lifetime Plan</p>
                </div>
            </div>
        </div>

        <div class="row gpt-dashboard-chart">
            <div class="row gpt-dashboard-chart">
                <div class="row gpt-dashboard-chart">
            <div class="col-lg-6 mb-30">
                <div class="card new-card">
                    <div class="card-header">
                        <h4>Enrollment Overview</h4>
                        <div class="gpt-up-down-arrow position-relative">
                            <select class="form-control generates-statistics">
                                @for ($i = date('Y'); $i >= 2022; $i--)
                                    <option @selected($i == date('Y')) value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            <span></span>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="content">
                            <canvas id="monthly-statistics" class="chart-css"></canvas>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-30">
                <div class="card new-card">
                    <div class="card-header">
                        <h4>Line Overview</h4>
                        <div class="gpt-up-down-arrow position-relative">
                            <select class="form-control generates-statistics overview-year">
                                @for ($i = date('Y'); $i >= 2022; $i--)
                                    <option @selected($i == date('Y')) value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            <span></span>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="content">
                            <canvas id="combinedLineChartOnly" class="chart-css"></canvas>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-30">
                <div class="card new-card">
                    <div class="card-header">
                        <h4>Line Overview</h4>
                        <div class="gpt-up-down-arrow position-relative">
                            <select class="form-control generates-statistics overview-year">
                                @for ($i = date('Y'); $i >= 2022; $i--)
                                    <option @selected($i == date('Y')) value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            <span></span>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="content">
                            <canvas id="combinedLineChartOnly1" class="chart-css"></canvas>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-30">
                <div class="card new-card">
                    <div class="card-header">
                        <h4>Enrollment Overview</h4>
                        <div class="gpt-up-down-arrow position-relative">
                            <select class="form-control generates-statistics">
                                @for ($i = date('Y'); $i >= 2022; $i--)
                                    <option @selected($i == date('Y')) value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            <span></span>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="content">
                            <canvas id="combinedChart" class="chart-css"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-30">
                <div class="card new-card">
                    <div class="card-header">
                        <h4>Combined Overview</h4>
                        <div class="gpt-up-down-arrow position-relative">
                            <select class="form-control generates-statistics">
                                @for ($i = date('Y'); $i >= 2022; $i--)
                                    <option @selected($i == date('Y')) value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            <span></span>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="content">
                            <canvas id="combinedLineChart" class="chart-css"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-30">
                <div class="card new-card">
                    <div class="card-header">
                        <h4>Combined Overview</h4>
                        <div class="gpt-up-down-arrow position-relative">
                            <select class="form-control generates-statistics">
                                @for ($i = date('Y'); $i >= 2022; $i--)
                                    <option @selected($i == date('Y')) value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            <span></span>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="content">
                            <canvas id="combinedBarChart" class="chart-css"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-30">
                <div class="card new-card">
                    <div class="card-header">
                        <h4>Combined Overview</h4>
                        <div class="gpt-up-down-arrow position-relative">
                            <select class="form-control generates-statistics">
                                @for ($i = date('Y'); $i >= 2022; $i--)
                                    <option @selected($i == date('Y')) value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            <span></span>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="content">
                            <canvas id="optimizedBarChart" class="chart-css"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-30">
                <div class="card new-card">
                    <div class="card-header">
                        <h4>Task Chart Overview</h4>
                    </div>
                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                        <canvas id="drawTaskChart" class="chart-canvas"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-30">
                <div class="card new-card">
                    <div class="card-header">
                        <h4>Enrollment Chart Overview</h4>
                    </div>
                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                        <canvas id="drawEnrollmentChart" class="chart-canvas"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-30">
                <div class="card new-card">
                    <div class="card-header">
                        <h4>Overall Chart Overview</h4>
                    </div>
                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                        <canvas id="drawOverallChart" class="chart-canvas"></canvas>
                    </div>
                </div>
            </div>
                <div class="col-xxl-6 mb-30">
                    <div class="card new-card">
                        {{-- <div class="card-body ShareProfit-body">
                            <canvas id="ShareProfit" class="chart-css"></canvas>
                        </div> --}}
                        <div class="card-body">
                            <div class="four-card-content">
                                <div class="row">
                                    <div class="col-sm-6 mb-4">
                                        <div class="four-card p-2">
                                            <h6>Total New Users </h6>
                                            <div class="d-flex align-items-center flex-wrap gap-1">
                                                <h4>500</h4>
                                                <div class="d-flex align-items-center gap-1">
                                                    <img src="{{ asset('assets/images/icons/arrow-up.svg')}}" alt="icon">
                                                    <span class="text-green-sm">80%</span>
                                                    <span>This Month</span>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="time d-flex align-items-center gap-2">
                                                <p>Last Month:</p>
                                                <h6>50</h6>
                                            </div>
                                            <div class="time d-flex align-items-center gap-2">
                                                <p>Current Year:</p>
                                                <h6>20,000</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 mb-4">
                                        <div class="four-card p-2">
                                            <h6>Total New Subscribe </h6>
                                            <div class="d-flex align-items-center flex-wrap gap-1">
                                                <h4>300</h4>
                                                <div class="d-flex align-items-center gap-1">
                                                    <img src="{{ asset('assets/images/icons/arrow-up.svg')}}" alt="icon">
                                                    <span class="text-green-sm">80%</span>
                                                    <span>This Month</span>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="d-flex align-items-center gap-2">
                                                <p>Last Month:</p>
                                                <h6>250</h6>
                                            </div>
                                            <div class="d-flex align-items-center gap-2">
                                                <p>Current Year:</p>
                                                <h6>15,000</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 mb-4 mb-sm-0">
                                        <div class="four-card p-2">
                                            <h6>Total Income</h6>
                                            <div class="d-flex align-items-center flex-wrap gap-1">
                                                <h4>$2,50,000</h4>
                                                <div class="d-flex align-items-center gap-1">
                                                    <img src="{{ asset('assets/images/icons/arrow-down.svg')}}" alt="icon">
                                                    <span class="text-orange">60%</span>
                                                    <span>This Month</span>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="d-flex align-items-center gap-2">
                                                <p>Last Month:</p>
                                                <h6>$3,00,000</h6>
                                            </div>
                                            <div class="d-flex align-items-center gap-2">
                                                <p>Current Year:</p>
                                                <h6>$500.5k</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="four-card p-2">
                                            <h6>Total Expense </h6>
                                            <div class="d-flex align-items-center flex-wrap gap-1">
                                                <h4>$50,000</h4>
                                                <div class="d-flex align-items-center gap-1">
                                                    <img src="{{ asset('assets/images/icons/arrow-down.svg')}}" alt="icon">
                                                    <span class="text-orange">80%</span>
                                                    <span>This Month</span>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="d-flex align-items-center gap-2">
                                                <p>Last Month:</p>
                                                <h6>$45,000</h6>
                                            </div>
                                            <div class="d-flex align-items-center gap-2">
                                                <p>Current Year:</p>
                                                <h6>$250.0k</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-7 mb-30">
                    <div class="card new-card">
                        <div class="card-header">
                            <h4>New Register </h4>
                            <div class="gpt-up-down-arrow position-relative">
                                <select class="form-control generates-statistics">
                                    <option value="">Monthly</option>
                                    <option value="">a</option>
                                    <option value="">b</option>
                                    <option value="">c</option>
                                </select>
                                <span></span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive border-1 rounded-3 rounded-image">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Date & Time</th>
                                        <th>Shop Name</th>
                                        <th>Category</th>
                                        <th>Phone</th>
                                        <th>Package</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>20 Jun 2023 - 10:30 PM</td>
                                            <td>Fashion store</td>
                                            <td>Fashion</td>
                                            <td>011 555 71370</td>
                                            <td class="text-blue">Free</td>
                                        </tr>
                                        <tr>
                                            <td>20 Jun 2023 - 10:30 PM</td>
                                            <td>Fashion store</td>
                                            <td>Fashion</td>
                                            <td>011 555 71370</td>
                                            <td class="text-orange">Monthly</td>
                                        </tr>
                                        <tr>
                                            <td>20 Jun 2023 - 10:30 PM</td>
                                            <td>Fashion store</td>
                                            <td>Fashion</td>
                                            <td>011 555 71370</td>
                                            <td class="text-violet">1 Year</td>
                                        </tr>
                                        <tr>
                                            <td>20 Jun 2023 - 10:30 PM</td>
                                            <td>Fashion store</td>
                                            <td>Fashion</td>
                                            <td>011 555 71370</td>
                                            <td class="text-green">5 Year</td>
                                        </tr>
                                        <tr>
                                            <td>20 Jun 2023 - 10:30 PM</td>
                                            <td>Fashion store</td>
                                            <td>Fashion</td>
                                            <td>011 555 71370</td>
                                            <td class="text-violet">Lifetime</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="view-all d-flex justify-content-end">
                                    <p>Showing 5 results | <a href="">View All <img src="{{ asset('assets/images/icons/arrow-right.svg') }}" alt=""></a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-5 mb-30">
                    <div class="card new-card">
                        <div class="card-header">
                            <h4>Subscription Plan</h4>
                            <div class="gpt-up-down-arrow position-relative">
                                <select class="form-control generates-statistics">
                                    <option value="">Monthly</option>
                                    <option value="">a</option>
                                    <option value="">b</option>
                                    <option value="">c</option>
                                </select>
                                <span></span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="content">
                                Graph
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-7 mb-30">
                    <div class="card new-card">
                        <div class="card-header">
                            <h4>Upcoming Expired Shop</h4>
                            <div class="gpt-up-down-arrow position-relative">
                                <select class="form-control generates-statistics">
                                    <option value="">Monthly</option>
                                    <option value="">a</option>
                                    <option value="">b</option>
                                    <option value="">c</option>
                                </select>
                                <span></span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive border-1 rounded-3 rounded-image">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Shop Name</th>
                                        <th>Category</th>
                                        <th>Phone</th>
                                        <th>Package</th>
                                        <th>Expired Date</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Fashion store</td>
                                            <td>Fashion</td>
                                            <td>011 555 71370</td>
                                            <td class="text-violet">1 Year</td>
                                            <td>20 Jun 2023</td>
                                        </tr>
                                        <tr>
                                            <td>Fashion store</td>
                                            <td>Fashion</td>
                                            <td>011 555 71370</td>
                                            <td class="text-orange">Monthly</td>
                                            <td>20 Jun 2023</td>
                                        </tr>
                                        <tr>
                                            <td>Fashion store</td>
                                            <td>Fashion</td>
                                            <td>011 555 71370</td>
                                            <td class="text-violet">1 Year</td>
                                            <td>20 Jun 2023</td>
                                        </tr>
                                        <tr>
                                            <td>Fashion store</td>
                                            <td>Fashion</td>
                                            <td>011 555 71370</td>
                                            <td class="text-green">3 Year</td>
                                            <td>20 Jun 2023</td>
                                        </tr>
                                        <tr>
                                            <td>Fashion store</td>
                                            <td>Fashion</td>
                                            <td>011 555 71370</td>
                                            <td class="text-orange">Monthly</td>
                                            <td>20 Jun 2023</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="view-all d-flex justify-content-end">
                                <p>Showing 5 results | <a href="">View All <img src="{{ asset('assets/images/icons/arrow-right.svg') }}" alt=""></a></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-5 mb-30">
                    <div class="card new-card">
                        <div class="card-header">
                            <h4>Use Device</h4>
                            <div class="gpt-up-down-arrow position-relative">
                                <select class="form-control generates-statistics">
                                    <option value="">Monthly</option>
                                    <option value="">a</option>
                                    <option value="">b</option>
                                    <option value="">c</option>
                                </select>
                                <span></span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="content">
                                Graph
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-7 mb-30">
                    <div class="card new-card feedback">
                        <div class="card-header">
                            <h4>Feedback</h4>
                            <div class="gpt-up-down-arrow position-relative">
                                <select class="form-control generates-statistics">
                                    <option value="">Monthly</option>
                                    <option value="">a</option>
                                    <option value="">b</option>
                                    <option value="">c</option>
                                </select>
                                <span></span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive border-1 rounded-3 rounded-image">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Date & Time</th>
                                            <th>Shop Name</th>
                                            <th>Category</th>
                                            <th>Description</th>
                                            <th>Assigned  Task</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>20 Jun 2023 - 10:30 PM</td>
                                            <td>Fashion store</td>
                                            <td>Fashion</td>
                                            <td>Please help me ....</td>
                                            <td>
                                                <div>
                                                    <strong>Shakil Mia</strong>
                                                    <br>
                                                    <span>Duration: 1 Hours</span>
                                                </div>
                                            </td>
                                            <td class="text-orange">Pending</td>
                                        </tr>
                                        <tr>
                                            <td>20 Jun 2023 - 10:30 PM</td>
                                            <td>Fashion store</td>
                                            <td>Fashion</td>
                                            <td>Please help me ....</td>
                                            <td>
                                                <div>
                                                    <strong>Shakil Mia</strong>
                                                    <br>
                                                    <span>Duration: 1 Hours</span>
                                                </div>
                                            </td>
                                            <td class="text-orange">Pending</td>
                                        </tr>
                                        <tr>
                                            <td>20 Jun 2023 - 10:30 PM</td>
                                            <td>Fashion store</td>
                                            <td>Fashion</td>
                                            <td>Please help me ....</td>
                                            <td>
                                                <div>
                                                    <strong>Shakil Mia</strong>
                                                    <br>
                                                    <span>Duration: 1 Hours</span>
                                                </div>
                                            </td>
                                            <td class="text-green">Complete</td>
                                        </tr>
                                        <tr>
                                            <td>20 Jun 2023 - 10:30 PM</td>
                                            <td>Fashion store</td>
                                            <td>Fashion</td>
                                            <td>Please help me ....</td>
                                            <td>
                                                <div>
                                                    <strong>Shakil Mia</strong>
                                                    <br>
                                                    <span>Duration: 1 Hours</span>
                                                </div>
                                            </td>
                                            <td class="text-green">Complete</td>
                                        </tr>
                                        <tr>
                                            <td>20 Jun 2023 - 10:30 PM</td>
                                            <td>Fashion store</td>
                                            <td>Fashion</td>
                                            <td>Please help me ....</td>
                                            <td>
                                                <div>
                                                    <strong>Shakil Mia</strong>
                                                    <br>
                                                    <span>Duration: 1 Hours</span>
                                                </div>
                                            </td>
                                            <td class="text-green">Complete</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="view-all d-flex justify-content-end">
                                <p>Showing 5 results | <a href="">View All <img src="{{ asset('assets/images/icons/arrow-right.svg') }}" alt=""></a></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-5 mb-30">
                    <div class="card new-card">
                        <div class="card-header">
                            <h4>Top Five Country</h4>
                            <div class="gpt-up-down-arrow position-relative">
                                <select class="form-control generates-statistics">
                                    <option value="">Monthly</option>
                                    <option value="">a</option>
                                    <option value="">b</option>
                                    <option value="">c</option>
                                </select>
                                <span></span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive border-1 rounded-3 rounded-image">
                                <div class="content top-five-country">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h6>Bangladesh</h6>
                                        <div class="d-flex align-items-center gap-2">
                                            <p>5,000</p>
                                            <p class="text-green">60%</p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h6>United Sated</h6>
                                        <div class="d-flex align-items-center gap-2">
                                            <p>5,000</p>
                                            <p class="text-green">60%</p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h6>indian</h6>
                                        <div class="d-flex align-items-center gap-2">
                                            <p>5,000</p>
                                            <p class="text-green">60%</p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h6>Canada</h6>
                                        <div class="d-flex align-items-center gap-2">
                                            <p>5,000</p>
                                            <p class="text-green">60%</p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h6>Turkey</h6>
                                        <div class="d-flex align-items-center gap-2">
                                            <p>5,000</p>
                                            <p class="text-green">60%</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-7 mb-30">
                    <div class="card new-card">
                        <div class="card-header">
                            <h4>New Registered Users </h4>
                            <div class="gpt-up-down-arrow position-relative">
                                <select class="form-control generates-statistics">
                                    <option value="">Monthly</option>
                                    <option value="">a</option>
                                    <option value="">b</option>
                                    <option value="">c</option>
                                </select>
                                <span></span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="content">
                                Graph
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-5 mb-30">
                    <div class="card new-card notice">
                        <div class="card-header">
                            <h4>Notice</h4>
                            <div class="gpt-up-down-arrow position-relative">
                                <select class="form-control generates-statistics">
                                    <option value="">Monthly</option>
                                    <option value="">a</option>
                                    <option value="">b</option>
                                    <option value="">c</option>
                                </select>
                                <span></span>
                            </div>
                        </div>
                        <div class="card-body content-body">
                            <div class="content notice-content">
                                <div>
                                    <h6>Awards Conference</h6>
                                    <p>Today, 10:30 PM - 02:30 AM</p>
                                </div>
                                <div>
                                    <h6>Awards Conference</h6>
                                    <p>Today, 10:30 PM - 02:30 AM</p>
                                </div>
                                <div>
                                    <h6>Awards Conference</h6>
                                    <p>Today, 10:30 PM - 02:30 AM</p>
                                </div>
                                <div>
                                    <h6>Awards Conference</h6>
                                    <p>Today, 10:30 PM - 02:30 AM</p>
                                </div>
                                <div>
                                    <h6>Awards Conference</h6>
                                    <p>Today, 10:30 PM - 02:30 AM</p>
                                </div>
                                <div>
                                    <h6>Awards Conference</h6>
                                    <p>Today, 10:30 PM - 02:30 AM</p>
                                </div>
                                <div>
                                    <h6>Awards Conference</h6>
                                    <p>Today, 10:30 PM - 02:30 AM</p>
                                </div>
                                <div>
                                    <h6>Awards Conference</h6>
                                    <p>Today, 10:30 PM - 02:30 AM</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-xxl-5 mb-30">
                    <div class="card new-card">
                        <div class="card-header">
                            <h4>New Register </h4>
                            <div class="gpt-up-down-arrow position-relative">
                                <select class="form-control generates-statistics">
                                    @for ($i = date('Y'); $i >= 2022; $i--)
                                        <option @selected($i == date('Y')) value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                                <span></span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive border-1 rounded-3 rounded-image">
                                hi
                            </div>
                        </div>
                    </div>
                </div> --}}

            </div>
        </div>
    </div>

    <input type="hidden" value="{{ route('author.dashboard.data') }}" id="get-dashboard">
    <input type="hidden" value="{{ route('author.dashboard.user-overview') }}" id="get-user-overview">
    <input type="hidden" value="{{ route('author.dashboard.generates') }}" id="yearly-generates-url">

@endsection

@push('js')
    <script src="{{ asset('assets/js/chart.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/dashboard.js') }}"></script>
@endpush
