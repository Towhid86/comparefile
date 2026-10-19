@extends('layouts.author.master')

@section('title')
    {{__ ('Country List') }}
@endsection

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="table-header">
                        <h4>{{__('Country List')}}</h4>
                        @can('countries-create')
                            <a href="" class="add-order-btn rounded-2" data-bs-toggle="modal" data-bs-target="#country-modal"><i class="fas fa-plus-circle"></i> {{__('Add Country')}} </a>
                        @endcan
                    </div>


                    <div class="table-top-form daily-transaction-between-wrapper">
                        <form class="searchForm" action="{{-- {{ route('author.countries.baariFilter') }} --}}" method="POST">
                            <div class="grid-3">
                                <select class="form-control" name="per_page">
                                    <option value="10">@lang('Result- 10')</option>
                                    <option value="25">@lang('Result- 25')</option>
                                    <option value="50">@lang('Result- 50')</option>
                                    <option value="100">@lang('Result- 100')</option>
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
                        <table class="table" id="erp-table">
                            <thead>
                            <tr>
                                <th>{{ __('SL') }}.</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Nick Name') }}</th>
                                <th>{{ __('Alpha 2') }}</th>
                                <th>{{ __('Alpha 3') }}</th>
                                <th>{{ __('Phone Code') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Default') }}</th>
                                <th class="print-d-none">{{ __('Action') }}</th>
                            </tr>
                            </thead>
                            <tbody class="searchResults">
                                @include('author.countries.datas')
                            </tbody>
                        </table>
                    </div>
                    <div>
                        {{ $countries->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('modal')
    @include('author.countries.modal')
@endpush

@push('js')
    <script src="{{ asset('assets/js/custom/custom.js') }}"></script>
@endpush


