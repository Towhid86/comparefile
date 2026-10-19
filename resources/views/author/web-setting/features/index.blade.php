@extends('layouts.author.master')

@section('title')
    {{ __('Features List') }}
@endsection

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="table-header">
                        <h4>{{ __('Features List') }}</h4>
                        <a href="{{ route('author.features.create') }}" class="theme-btn print-btn text-light">
                            <i class="far fa-plus" aria-hidden="true"></i>
                            {{ __('Create New') }}
                        </a>
                    </div>

                    <div class="table-top-form daily-transaction-between-wrapper">
                        <form class="searchForm" action="{{ route('author.features.baariFilter') }}" method="POST">
                            <div class="grid-3">
                                <div class="gpt-up-down-arrow position-relative">

                                    <select class="form-control" name="per_page">
                                        <option value="10">@lang('Result- 10')</option>
                                        <option value="25">@lang('Result- 25')</option>
                                        <option value="50">@lang('Result- 50')</option>
                                        <option value="100">@lang('Result- 100')</option>
                                    </select>
                                    <span></span>
                                </div>

                                <div class="gpt-up-down-arrow position-relative">
                                    <select class="form-control" name="status">
                                        <option value="">{{ __('All') }}</option>
                                        <option value="1">{{ __('Active Shop') }}</option>
                                        <option value="0">{{ __('Inactive Shop') }}</option>
                                    </select>
                                    <span></span>
                                </div>

                                <div class="table-search position-relative">
                                    <input class="form-control searchInput" type="text" name="search"
                                        placeholder="Search..." value="{{ request('search') }}">
                                    <span class="position-absolute">
                                        <img src="{{ asset('assets/images/search.svg') }}" alt="">
                                    </span>
                                </div>
                            </div>
                        </form>
                        <div class="table-top-btn-group">
                            <ul>
                                <li><a href="#"><img src="{{ asset('assets/img/icon/xl.svg') }}" alt=""></a>
                                </li>
                                <li><a href="#"><img src="{{ asset('assets/img/icon/csv.svg') }}" alt=""></a>
                                </li>
                                <li><a href="#"><img src="{{ asset('assets/img/icon/pdf.svg') }}" alt=""></a>
                                </li>
                                <li><a href="#"><img src="{{ asset('assets/img/icon/print.svg') }}" alt=""></a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="responsive-table">
                        <table class="table" id="datatable">
                            <thead>
                                <tr>
                                    @can('features-delete')
                                        <th width="10px">
                                            <div class="d-flex align-items-center gap-3">
                                                <input type="checkbox" class="selectAllCheckbox">
                                                <i class="fal fa-trash-alt delete-selected"></i>
                                            </div>
                                        </th>
                                    @endcan
                                    <th>{{ __('SL') }}.</th>
                                    <th>{{ __('Image') }}</th>
                                    <th>{{ __('Title') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody class="searchResults">
                                @include('author.web-setting.features.datas')
                            </tbody>
                        </table>
                    </div>
                    <nav>
                        <ul class="pagination">
                            <li class="page-item">{{ $features->links('pagination::bootstrap-5') }}</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('modal')
    @include('author.components.multi-delete-modal')
@endpush
