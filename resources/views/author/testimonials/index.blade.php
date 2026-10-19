@extends('layouts.author.master')

@section('title')
    {{ __('Testimonials List') }}
@endsection

@section('main_content')
<div class="erp-table-section">
    <div class="container-fluid">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-header">
                    <h4>{{ __('Testimonials List') }}</h4>
                    <a href="{{ route('author.testimonials.create') }}" class="theme-btn print-btn text-light">
                        <i class="far fa-plus" aria-hidden="true"></i>
                        {{ __('Create New') }}
                    </a>
                </div>

                <div class="table-top-form daily-transaction-between-wrapper">
                    <form class="searchForm" action="{{ route('author.testimonials.filter') }}" method="POST">
                        <div class="grid-3">
                            <select class="form-control" name="per_page">
                                <option value="10">@lang('Per Page- 10')</option>
                                <option value="25">@lang('Per Page- 25')</option>
                                <option value="50">@lang('Per Page- 50')</option>
                                <option value="100">@lang('Per Page- 100')</option>
                            </select>
                            <div class="table-search">
                                <input class="form-control searchInput" type="text" name="search" placeholder="Search..." value="{{ request('search') }}">
                                {{-- <button type="submit"><i class="far fa-search" aria-hidden="true"></i></button> --}}
                                <button type="button" class="text-danger clearSearchInput d-none">
                                    <i class="far fa-times" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="table-top-btn-group">
                        <ul>
                            <li><a href="#"><img src="{{ asset('assets/img/icon/xl.svg') }}" alt=""></a></li>
                            <li><a href="#"><img src="{{ asset('assets/img/icon/csv.svg') }}" alt=""></a></li>
                            <li><a href="#"><img src="{{ asset('assets/img/icon/pdf.svg') }}" alt=""></a></li>
                            <li><a href="#"><img src="{{ asset('assets/img/icon/print.svg') }}" alt=""></a></li>
                        </ul>
                    </div>
                </div>

                <div class="responsive-table">
                    <table class="table" id="datatable">
                        <thead>
                            <tr>
                                @can('testimonials-delete')
                                <th width="10px">
                                    <div class="d-flex align-items-center gap-3">
                                        <input type="checkbox" class="selectAllCheckbox">
                                        <i class="fal fa-trash-alt delete-selected"></i>
                                    </div>
                                </th>
                                @endcan
                                <th>{{ __('SL') }}.</th>
                                <th>{{ __('Stars') }}</th>
                                <th>{{ __('Client Name') }}</th>
                                <th>{{ __('Work At') }}</th>
                                <th>{{ __('Client Image') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody class="searchResults">
                            @include('author.testimonials.datas')
                        </tbody>
                    </table>
                </div>
                <nav>
                    <ul class="pagination">
                        <li class="page-item">{{ $testimonials->links('pagination::bootstrap-5') }}</li>
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

@push('js')
    <script src="{{ asset('assets/js/custom/custom.js') }}"></script>
@endpush
