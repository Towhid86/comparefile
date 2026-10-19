@extends('layouts.author.master')

@section('title')
    {{ __('Create Blog') }}
@endsection


@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="table-header mb-4">
                        <h4>{{ __('Create Blog') }}</h4>
                        <a href="{{ route('author.blogs.index') }}" class="theme-btn print-btn text-light">
                            <i class="fas fa-list me-1"></i>
                            {{ __('Blog List') }}
                        </a>
                    </div>

                    <div class="tab-content order-summary-tab">
                        <div class="tab-pane fade mt-1 show active" id="add-new-user">
                            <div class="order-form-section">
                                <form action="{{ route('author.blogs.store') }}" method="post" enctype="multipart/form-data"
                                    class="ajaxform_instant_reload">
                                    @csrf

                                    <div class="add-suplier-modal-wrapper">
                                        <div class="row">
                                            <div class="col-lg-12 mt-2">
                                                <label>{{ __('Title') }}</label>
                                                <input type="text" name="title" required class="form-control" placeholder="{{ __('Enter Title') }}">
                                            </div>

                                            <div class="col-lg-6 mt-2">
                                                <label>{{ __('Status') }}</label>
                                                <div class="gpt-up-down-arrow position-relative">
                                                    <select name="status" required=""
                                                        class="form-control select-dropdown">
                                                        <option value="">{{ __('Select a status') }}</option>
                                                        <option value="1">{{ __('Active') }}</option>
                                                        <option value="0">{{ __('Deactive') }}</option>
                                                    </select>
                                                    <span></span>
                                                </div>
                                            </div>

                                            <div class="col-lg-5 mt-2">
                                                <div>
                                                    <label>{{ __('Image') }}</label>
                                                    <input type="file" accept="image/*" name="image" class="form-control file-input-change" data-id="image" required>
                                                </div>
                                            </div>

                                            <div class="col-lg-1 mt-2 align-self-center">
                                                <div class="align-self-center mt-3">
                                                    <img src="{{ asset('assets/images/icons/upload.png') }}" id="image" class="table-img">
                                                </div>
                                            </div>

                                            <div class="col-lg-12 mt-2">
                                                <label>{{ __('Description') }}</label>
                                                <textarea type="text" name="descriptions" class="form-control" placeholder="{{ __('Enter Description') }}"></textarea>
                                            </div>

                                            {{-- <div class="col-lg-6 mt-2">
                                                <div class="feature-row sample-form-wrp duplicate-feature">
                                                    <div class="">
                                                        <button type="button" class="btn btn-secondary service-btn-possition feature-add-btn">{{ __('+') }}</button>
                                                        <button type="button" class="btn text-danger remove-btn-features feature-remove-btn"
                                                            disabled=""><i class="fas fa-trash"></i></button>
                                                    </div>

                                                    <div class="row mb-4">
                                                        <div class="mt-2">
                                                            <label>{{ __('Tags') }}</label>
                                                            <input type="text" name="tags[]" class="form-control clear-input" placeholder="{{ __('Enter Tag') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> --}}

                                            <div class="col-12 mb-2">
                                                <div class="manual-rows" id="dynamic-input-fields">
                                                    <div class="row row-items">
                                                        <div class="col-sm-6">
                                                            <label for="">{{ __('Tags') }}</label>
                                                            <input type="text" name="tags[]" class="form-control" required
                                                                placeholder="Enter tags name">
                                                        </div>
                                                        <div class="col-sm-1 align-self-center mt-3">
                                                            <button type="button" class="btn text-danger trash remove-btn-features"
                                                                onclick="removeDynamicField(this)"><i
                                                                    class="fas fa-trash"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 mt-2">
                                                        <a href="javascript:void(0)" class="fw-bold text-primary add-new-item"
                                                            onclick="addDynamicField()"><i class="fas fa-plus-circle"></i> Add new
                                                            row</a>
                                                    </div>
                                                </div>
                                            </div>

                                            <h6 class="mt-5">{{ __('SEO Meta Tags') }}</h6>
                                            <div class="col-lg-12 mt-2">
                                                <label>{{ __('Meta Title') }}</label>
                                                <input type="text" name="meta[title]" class="form-control" placeholder="{{ __('Enter Title') }}">
                                            </div>
                                            <div class="col-lg-12 mt-2">
                                                <label>{{ __('Meta Description') }}</label>
                                                <textarea type="text" name="meta[description]" class="form-control" placeholder="{{ __('Enter meta Description') }}" ></textarea>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="button-group text-center mt-5">
                                                    <a href=""
                                                        class="theme-btn border-btn m-2">{{ __('Cancel') }}</a>
                                                    <button class="theme-btn m-2 submit-btn">{{ __('Save') }}</button>
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
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/js/custom/custom.js') }}"></script>
@endpush
