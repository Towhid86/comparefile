@extends('layouts.author.master')

@section('title')
    {{ __('Privacy & Policy Settings') }}
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/summernote-lite.css') }}">
@endpush

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="table-header border-0">
                        <h4>{{ __('Privacy & Policy Settings') }}</h4>
                    </div>
                    <div class="order-form-section">
                        <form action="{{ route('author.privacy-policy.store') }}" method="post" enctype="multipart/form-data"
                            class="ajaxform">
                            @csrf
                            <div class="add-suplier-modal-wrapper d-block">
                                <div class="row">

                                    <div class="col-lg-12 mt-2">
                                        <textarea name="description" id="summernote" class="form-control summernote">{{ $privacy_policy->value ?? '' }}</textarea>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="text-center mt-5">
                                            <button type="submit"
                                                class="theme-btn m-2 submit-btn">{{ __('Update') }}</button>
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


@push('js')
    <script src="{{ asset('assets/js/summernote-lite.js') }}"></script>
    <script>
        $('.summernote').summernote({
            height: 300,
        });
    </script>
@endpush

