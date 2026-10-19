@extends('layouts.author.master')

@section('title')
    {{ __('Language')  }}
@endsection

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="table-header">
                <h4>{{__('Language List')}}</h4>
                @can('languages-create')
                    <a href="{{ route('author.languages.create') }}"
                       class="add-order-btn rounded-2 {{ Route::is('author.languages.create') ? 'active' : '' }}" data-bs-toggle="modal" data-bs-target="#language-modal"><i
                            class="fas fa-plus-circle"></i> {{ __('Add Language') }}</a>
                @endcan
            </div>

            <div class="table-top-form daily-transaction-between-wrapper">
                <form class="searchForm" action="{{ route('author.languages.index') }}" method="get">
                    <div class="grid-3">
                        <select class="form-control" name="per_page">
                            <option value="30">@lang('Per Page- 10')</option>
                            <option value="25">@lang('Per Page- 25')</option>
                            <option value="50">@lang('Per Page- 50')</option>
                            <option value="100">@lang('Per Page- 100')</option>
                        </select>
                        <div class="table-search">
                            <input class="form-control searchInput" type="text" placeholder="Search..."
                                   value="{{ request('search') }}">
                            <button type="submit"><i class="far fa-search" aria-hidden="true"></i></button>
                            <button type="button" class="text-danger clearSearchInput d-none"><i class="far fa-times"
                                                                                                 aria-hidden="true"></i>
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
            <div class="responsive-table rounded-image">
                <table class="table" id="erp-table">
                    <thead>
                    <tr>
                        <th class="w-60">
                            <div class="d-flex align-items-center gap-3">
                                <input type="checkbox" class="selectAllCheckbox">
                                <i class="fal fa-trash-alt delete-selected"></i>
                            </div>
                        </th>
                        <th>{{__('SL.')}}</th>
                        <th>{{__('Flag')}}</th>
                        <th>{{__('Name')}}</th>
                        <th>{{__('Short Name')}}</th>
                        <th>{{__('Direction')}}</th>
                        <th>{{__('default')}}</th>
                        <th>{{__('Status')}}</th>
                        <th>{{__('Action')}}</th>
                    </tr>
                    </thead>
                    <tbody class="searchResults">
                    @include('author.settings.languages.datas')
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $languages ->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>

@endsection
@push('modal')
    @include('author.settings.languages.modal')
    @include('author.components.multi-delete-modal')
@endpush

@push('js')
    <script src="{{ asset('assets/js/custom/custom.js') }}"></script>
@endpush
