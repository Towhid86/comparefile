@extends('layouts.author.master')

@section('title')
    {{ __('Reports')  }}
@endsection

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="table-header">
                <h4>{{__('Reports')}}</h4>
            </div>
            <div class="table-top-form daily-transaction-between-wrapper">
                <form class="searchForm" action="{{ route('author.users.index') }}" method="get">
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

                        <select class="form-control" name="status">
                            <option value="10">{{ __('All') }}</option>
                            <option value="1">{{ __('Active User') }}</option>
                            <option value="1">{{ __('Deactive User') }}</option>
                        </select>
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
                        <th>{{__('Date')}}</th>
                        <th>{{__('Invoice')}}</th>
                        <th>{{__('Customer Name')}} </th>
                        <th>{{__('Business Name')}}</th>
                        <th>{{__('Status')}}</th>
                        <th>{{__('Amount')}}</th>
                        <th>{{__('Action')}}</th>
                    </tr>
                    </thead>
                    <tbody class="searchResults">
                    <tr>
                        <td class="w-60 checkbox">
                            <input type="checkbox" name="ids[]" class="checkbox-item" value="" data-url="">
                            <i class=""></i>
                        </td>
                        <td>01</td>
                        <td>26 Jan 2023</td>
                        <td>#236142</td>
                        <td>Shaidul Islma</td>
                        <td>Shairdul Store</td>
                        <td><span class="sale-due">Sale Due</span></td>
                        <td>$5,000.00</td>
                        <td class="print-d-none">
                            <div class="dropdown table-action">
                                <button type="button" data-bs-toggle="dropdown">
                                    <i class="far fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="#view-modal" class="view-btn" data-bs-toggle="modal">
                                            <i class="fal fa-eye"></i>
                                            {{ __('View') }}
                                        </a>
                                    </li>
                                    @can('users-delete')
                                        <li>
                                            <a href="" class="confirm-action" data-method="DELETE">
                                                <i class="fal fa-trash-alt"></i>
                                                {{ __('Delete') }}
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="w-60 checkbox">
                            <input type="checkbox" name="ids[]" class="checkbox-item" value="" data-url="">
                            <i class=""></i>
                        </td>
                        <td>02</td>
                        <td>26 Jan 2023</td>
                        <td>#236142</td>
                        <td>Jacob Jones</td>
                        <td>Tibba Store</td>
                        <td><span class="receive-text">Receive</span></td>
                        <td>$5,000.00</td>
                        <td class="print-d-none">
                            <div class="dropdown table-action">
                                <button type="button" data-bs-toggle="dropdown">
                                    <i class="far fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="#view-modal" class="view-btn" data-bs-toggle="modal">
                                            <i class="fal fa-eye"></i>
                                            {{ __('View Report') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#view-modal" class="view-btn" data-bs-toggle="modal">
                                            <i class="fal fa-eye"></i>
                                            {{ __('Download Report') }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{--                {{ $users->links('vendor.pagination.bootstrap-5') }}--}}
            </div>
        </div>
    </div>

    <div class="modal fade" id="view-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">{{ __('User View') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="personal-info">
                        <div class="row align-items-center mt-3">
                            <div class="col-md-4"><p>{{ __('Business Category') }}</p></div>
                            <div class="col-1">
                                <p>:</p>
                            </div>
                            <div class="col-md-7"><p id="user_view_business_category"></p></div>
                        </div>
                        <div class="row align-items-center mt-3">
                            <div class="col-md-5"><p>{{ __('Shop Name') }}</p></div>
                            <div class="col-md-7"><p id="user_view_business_name"></p></div>
                        </div>
                        <div class="row align-items-center mt-3">
                            <div class="col-md-4"><p>{{ __('Image') }}</p></div>
                            <div class="col-1">
                                <p>:</p>
                            </div>
                            <div class="col-md-7 d-flex align-items-center gap-2">
                                <div class="table-user-icon"><img src="" alt="" id="user_view_image"></div>
                            </div>
                        </div>
                        <div class="row align-items-center mt-3">
                            <div class="col-md-4"><p>{{ __('Name') }}</p></div>
                            <div class="col-1">
                                <p>:</p>
                            </div>
                            <div class="col-md-7"><p id="user_view_name"></p></div>
                        </div>
                        <div class="row align-items-center mt-3">
                            <div class="col-md-4"><p>{{ __('Role') }}</p></div>
                            <div class="col-1">
                                <p>:</p>
                            </div>
                            <div class="col-md-7"><p id="user_view_role"></p></div>
                        </div>
                        <div class="row align-items-center mt-3">
                            <div class="col-md-4"><p>{{ __('Email') }}</p></div>
                            <div class="col-1">
                                <p>:</p>
                            </div>
                            <div class="col-md-7"><p id="user_view_email"></p></div>
                        </div>
                        <div class="row align-items-center mt-3">
                            <div class="col-md-4"><p>{{ __('Phone') }}</p></div>
                            <div class="col-1">
                                <p>:</p>
                            </div>
                            <div class="col-md-7"><p id="user_view_phone"></p></div>
                        </div>
                        <div class="row align-items-center mt-3">
                            <div class="col-md-4"><p>{{ __('Address') }}</p></div>
                            <div class="col-1">
                                <p>:</p>
                            </div>
                            <div class="col-md-7"><p id="user_view_address"></p></div>
                        </div>
                        <div class="row align-items-center mt-3">
                            <div class="col-md-4"><p>{{ __('Country') }}</p></div>
                            <div class="col-1">
                                <p>:</p>
                            </div>
                            <div class="col-md-7"><p id="user_view_country_id"></p></div>
                        </div>
                        <div class="row align-items-center mt-3">
                            <div class="col-md-4"><p>{{ __('Status') }}</p></div>
                            <div class="col-1">
                                <p>:</p>
                            </div>
                            <div class="col-md-7"><p id="user_view_status"></p></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('modal')
    @include('author.components.multi-delete-modal')
@endpush

