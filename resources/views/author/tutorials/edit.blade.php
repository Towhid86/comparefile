@extends('layouts.author.master')

@section('title')
    {{ __('Tutorial') }}
@endsection

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="table-header">
                <h4>{{ __('Edit Tutorial') }}</h4>
                @can('tutorials-read')
                <a href="{{ route('author.tutorials.index') }}" class="add-order-btn rounded-2 {{ Route::is('author.tutorials.create') ? 'active' : '' }}"><i class="far fa-list" aria-hidden="true"></i> {{ __('Tutorial List') }}</a>
                @endcan
            </div>
            <div class="order-form-section">
                <form action="{{ route('author.tutorials.update', $tutorial->id) }}" method="post" enctype="multipart/form-data"
                      class="ajaxform_instant_reload">
                    @csrf
                    @method('put')
                    <div class="add-suplier-modal-wrapper">
                        <div class="row">
                            <div class="col-lg-6">
                                <label>{{ __('Thumbnail') }}</label>
                                <div class="upload-img-v2">
                                    <label class="upload-v4 image-height">
                                        <div class="img-wrp">
                                            <img src="{{ Storage::url($tutorial->thumbnail) ?? asset('assets/images/icons/upload-icon.svg') }}" alt="user" id="profile-img">
                                        </div>
                                        <input type="file" name="thumbnail" class="d-none" onchange="document.getElementById('profile-img').src = window.URL.createObjectURL(this.files[0])" accept="image/*">
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="col-lg-12 mt-2">
                                    <label>{{ __('Title') }}</label>
                                    <input type="text" name="title" value="{{ $tutorial->title }}" required class="form-control" placeholder="Enter Thumbnail">
                                </div>
                                <div class="col-lg-12">
                                    <label>{{ __('Description') }}</label>
                                    <textarea name="description" class="form-control" placeholder="Enter Description">{{ $tutorial->description }}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label>{{ __('Video Upload') }}</label>
                                <input type="file" name="video" accept="video/*" class="form-control">
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label>{{ __('Status') }}</label>
                                <div class="form-control d-flex justify-content-between align-items-center radio-switcher">
                                    <p class="dynamic-text">{{ $tutorial->status == 1 ? 'Active' : 'Deactive' }}</p>
                                    <label class="switch m-0">
                                        <input type="checkbox" name="status" class="change-text" {{ $tutorial->status == 1 ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="button-group text-center mt-5">
                                    <a type="reset" class="theme-btn border-btn m-2">{{ __('Cancel') }}</a>
                                    <button class="theme-btn m-2 submit-btn">{{__('Save')}}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
