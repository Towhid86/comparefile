@extends('layouts.author.master')

@section('title')
    {{ __('Edit Testimonial') }}
@endsection

@section('main_content')
<div class="erp-table-section">

    <div class="container-fluid">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-header">
                    <h4>{{__('Edit Testimonial') }}</h4>
                    <div>
                        <a href="{{ route('author.testimonials.index') }}" class="theme-btn print-btn text-light">
                            <i class="fas fa-list me-1"></i>
                            {{ __("View List") }}
                        </a>
                    </div>
                </div>

                <div class="order-form-section">

                    <form action="{{ route('author.testimonials.update',['testimonial'=>$testimonial]) }}" method="post" enctype="multipart/form-data" class="ajaxform_instant_reload">
                        @csrf
                        @method('put')

                        <div class="add-suplier-modal-wrapper">
                            <div class="row">
                                <div class="col-lg-6 mt-2">
                                    <label>{{ __('Client Name') }}</label>
                                    <input type="text" name="name" required class="form-control" value="{{ $testimonial->name }}" placeholder="{{ __('Enter Client Name') }}">
                                </div>

                                <div class="col-sm-6 mt-2">
                                    <label>{{ __('Stars') }}</label>
                                    <div class="gpt-up-down-arrow position-relative">
                                        <select name="star" required="" class="form-control select-dropdown">
                                            <option @selected($testimonial->star == 1) value="1">{{ __('1') }}</option>
                                            <option @selected($testimonial->star == 2) value="2">{{ __('2') }}</option>
                                            <option @selected($testimonial->star == 3) value="3">{{ __('3') }}</option>
                                            <option @selected($testimonial->star == 4) value="4">{{ __('4') }}</option>
                                            <option @selected($testimonial->star == 5) value="5">{{ __('5') }}</option>
                                        </select>
                                        <span></span>
                                    </div>
                                </div>

                                <div class="col-lg-6 mt-2">
                                    <label>{{ __('Works At') }}</label>
                                    <input type="text" name="work_at" required class="form-control" placeholder="{{ __('Enter Client Name') }}" value="{{ $testimonial->work_at ?? '' }}" >
                                </div>
                                <div class="col-lg-6 settings-image-upload mt-2">
                                    <label class="title">{{__('Client Image')}}</label>
                                    <div class="upload-img-v2">
                                        <label class="upload-v4 settings-upload-v4">
                                            <div class="img-wrp">
                                                <img
                                                    src="{{ asset($testimonial->image ?? 'assets/images/icons/upload-icon.svg') }}"
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
                                            <option @selected($testimonial->status == 1) value="1">{{ __('Active') }}</option>
                                            <option @selected($testimonial->status == 0) value="0">{{ __('Deactive') }}</option>
                                        </select>
                                        <span></span>
                                    </div>
                                </div>

                                <div class="col-lg-12 mt-2">
                                    <label>{{ __('Review') }}</label>
                                    <textarea name="text" id="" class="form-control" placeholder="{{ __('Enter review message here') }}">{{ $testimonial->text }}</textarea>
                                </div>

                                <div class="col-lg-12">
                                    <div class="button-group text-center mt-5">
                                        <a href="" class="theme-btn border-btn m-2">{{__('Cancel')}}</a>
                                        <button class="theme-btn m-2 submit-btn">{{__('Update')}}</button>
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
