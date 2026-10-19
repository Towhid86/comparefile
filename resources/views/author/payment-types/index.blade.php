@extends('layouts.author.master')

@section('title')
    {{ __('Payment Type')  }}
@endsection

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="table-header">
                <h4>{{__(' Payment Type')}}</h4>
                @can('payment-types-create')
                    <a href="#payment-type-view-modal" data-bs-toggle="modal" class="add-order-btn rounded-2 {{ Route::is('author.payment-types.create') ? 'active' : '' }}"><i class="fas fa-plus-circle"></i> {{ __('Add Payment Type') }}</a>
                @endcan
            </div>
            <div class="table-top-form daily-transaction-between-wrapper">
                <form class="searchForm" action="{{ route('author.payment-types.index') }}" method="get">
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
                        <th>{{__('Name')}}</th>
                        <th>{{__('Status')}}</th>
                        <th>{{__('Action')}}</th>
                    </tr>
                    </thead>
                    <tbody class="searchResults">
                    @include('author.payment-types.datas')
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $payment_types->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>

    {{-- create modal --}}
    @include('author.payment-types.create-modal')
    {{-- edit modal --}}
    @include('author.payment-types.edit-modal')

@endsection

@push('modal')
    @include('author.components.multi-delete-modal')
@endpush

@push('js')
    <script src="{{ asset('assets/js/custom/custom.js') }}"></script>
@endpush
