@extends('layouts.author.master')

@section('title')
    {{ __('Blogs') }}
@endsection

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="table-header">
                        <h4 class="mt-2">{{ __('Blog List') }}</h4>
                        <a href="{{ route('author.blogs.create') }}" class="theme-btn print-btn text-light">
                            <i class="far fa-plus" aria-hidden="true"></i>
                            {{ __('Create New') }}
                        </a>
                    </div>

                    <div class="table-top-form daily-transaction-between-wrapper">
                        <form class="searchForm" action="{{ route('author.blogs.baariFilter') }}" method="POST">
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
                        <table class="table" id="datatable">
                            <thead>
                                <tr>
                                    @can('blogs-delete')
                                        <th class="w-60">
                                            <div class="d-flex align-items-center gap-3" >
                                                <input type="checkbox" class="selectAllCheckbox">
                                                <i class="fal fa-trash-alt delete-selected"></i>
                                            </div>
                                        </th>
                                    @endcan
                                    <th>{{ __('SL') }}.</th>
                                    <th>{{ __('Image') }}</th>
                                    <th>{{ __('Title') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th class="print-d-none">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody class="searchResults">
                                @include('author.web-setting.blogs.datas')
                            </tbody>
                        </table>
                    </div>
                    <nav>
                        <ul class="pagination">
                            <li class="page-item">{{ $blogs->links('pagination::bootstrap-5') }}</li>
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

