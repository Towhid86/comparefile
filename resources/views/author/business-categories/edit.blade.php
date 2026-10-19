@extends('layouts.author.master')

@section('title')
    {{ __('Category') }}
@endsection

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="table-header">
                <h4>{{__('Edit Category')}}</h4>
                @can('business-categories-read')
                    <a href="{{ route('author.business-categories.index') }}" class="add-order-btn rounded-2 {{ Route::is('author.business-categories.create') ? 'active' : '' }}"><i class="far fa-list" aria-hidden="true"></i> {{ __('Category List') }}</a>
                @endcan
            </div>
            <div class="order-form-section">
                <form action="{{ route('author.business-categories.update', $category->id) }}" method="POST" enctype="multipart/form-data" class="ajaxform_instant_reload">
                    @csrf
                    @method('put')
                    <div class="add-suplier-modal-wrapper">
                        <div class="row justify-content-center">
                            <div class="col-sm-10 col-md-8">
                                <div class="row">
                                    <div class="col-lg-6 mt-2">
                                        <label>{{('Name')}}</label>
                                        <input type="text" name="name" value="{{ $category->name }}" required class="form-control" placeholder="Enter Shop/Business Name">
                                    </div>
                                    <div class="col-lg-6 mt-2">
                                        <label>{{__('Status')}}</label>
                                        <div class="form-control d-flex justify-content-between align-items-center radio-switcher">
                                            <p class="dynamic-text">{{ $category->status == 1 ? 'Active' : 'Deactive' }}</p>
                                            <label class="switch m-0">
                                                <input type="checkbox" name="status" class="change-text" {{ $category->status == 1 ? 'checked' : '' }}>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mt-2">
                                        <label>{{__('Description')}}</label>
                                        <textarea name="description" class="form-control" placeholder="Enter Description">{{ $category->description }}</textarea>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="button-group text-center mt-5">
                                            <a href="{{ route('author.business-categories.index') }}" class="theme-btn border-btn m-2">{{ __('Cancel') }}</a><button class="theme-btn m-2 submit-btn">{{ __('Save') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
