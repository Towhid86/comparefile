@extends('layouts.author.master')

@section('title')
    {{ __('Design List') }}
@endsection

@section('main_content')
<div class="erp-table-section">
    <div class="container-fluid">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-header border-0">
                    <h4>{{ __('Design List') }}</h4>
                    <a href="{{ route('author.designs.create') }}" class="theme-btn print-btn text-light">
                        <i class="far fa-plus" aria-hidden="true"></i>
                        {{ __('Create New') }}
                    </a>
                </div>

                <div class="responsive-table">
                    <table class="table" id="datatable">
                        <thead>
                            <tr>
                                @can('designs-delete')
                                <th width="10px">
                                    <div class="d-flex align-items-center gap-3">
                                        <input type="checkbox" class="selectAllCheckbox">
                                        <i class="fal fa-trash-alt delete-selected"></i>
                                    </div>
                                </th>
                                @endcan
                                <th>{{ __('SL') }}.</th>
                                <th>{{ __('Image') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody class="searchResults">
                            @include('author.web-setting.designs.datas')
                        </tbody>
                    </table>
                </div>
                <nav>
                    <ul class="pagination">
                        <li class="page-item">{{ $designs->links('pagination::bootstrap-5') }}</li>
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
