@extends('layouts.author.master')

@section('title')
    {{ __('Add New Testimonial') }}
@endsection

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="table-header">
                        <h4>{{  __('Add New Testimonial') }}</h4>
                        <div>
                            <a href="{{ route('author.testimonials.index') }}" class="theme-btn print-btn text-light">
                                <i class="fas fa-list me-1"></i>
                                {{ __("View List") }}
                            </a>
                        </div>
                    </div>

                    <div class="order-form-section">
                        <form action="{{ route('author.testimonials.store') }}" method="post" enctype="multipart/form-data" class="ajaxform_instant_reload">
                            @csrf

                            <div class="add-suplier-modal-wrapper">
                                <div class="row">


                                    <div class="col-lg-6 mt-2">
                                        <label>{{ __('Client Name') }}</label>
                                        <input type="text" name="name" required class="form-control" placeholder="{{ __('Enter Client Name') }}" >
                                    </div>

                                    <div class="col-sm-6 mt-2">
                                        <label>{{ __('Stars') }}</label>
                                        <div class="gpt-up-down-arrow position-relative">
                                            <select name="star" required="" class="form-control select-dropdown">
                                                <option value="1">{{ __('1') }}</option>
                                                <option value="2">{{ __('2') }}</option>
                                                <option value="3">{{ __('3') }}</option>
                                                <option value="4">{{ __('4') }}</option>
                                                <option value="5" selected>{{ __('5') }}</option>
                                            </select>
                                            <span></span>
                                        </div>
                                    </div>


                                    <div class="col-lg-6 mt-2">
                                        <label>{{ __('Works At') }}</label>
                                        <input type="text" name="work_at" required class="form-control" placeholder="{{ __('Enter Client Name') }}" >
                                    </div>

                                    <div class="col-lg-6 settings-image-upload mt-2">
                                        <label class="title">{{__('Client Image')}}</label>
                                        <div class="upload-img-v2">
                                            <label class="upload-v4 settings-upload-v4">
                                                <div class="img-wrp">
                                                    <img
                                                        src="{{ asset('assets/images/icons/upload-icon.svg') }}"
                                                        alt="user" id="image">
                                                </div>
                                                <input type="file" name="image" class="d-none" accept="image/*"
                                                       onchange="document.getElementById('image').src = window.URL.createObjectURL(this.files[0])"
                                                       class="form-control">
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 mt-2">
                                        <label>{{ __('Status') }}</label>
                                        <div class="gpt-up-down-arrow position-relative">
                                            <select name="status" required="" class="form-control select-dropdown">
                                                <option value="1">{{ __('Active') }}</option>
                                                <option value="0">{{ __('Deactive') }}</option>
                                            </select>
                                            <span></span>
                                        </div>
                                    </div>


                                    <div class="col-lg-12 mt-2">
                                        <label>{{ __('Review') }}</label>
                                        <textarea name="text" class="form-control" placeholder="{{ __('Enter review message here') }}"></textarea>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="button-group text-center mt-5">
                                            <a href="" class="theme-btn border-btn m-2">{{__('Cancel')}}</a>
                                            <button class="theme-btn m-2 submit-btn">{{__('Save')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
