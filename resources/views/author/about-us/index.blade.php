@extends('layouts.author.master')

@section('title')
    {{ __('About Us') }}
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/summernote-lite.css') }}">
@endpush

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="table-header">
                <h4>{{ __('About Us') }} </h4>
            </div>
            <form action="{{ route('author.about.update') }}" method="POST" enctype="multipart/form-data" class="ajaxform">
                @csrf
                @method('put')
                <textarea id="summernote" name="about">{{ $about->value ?? '' }}</textarea>

                <div class="col-lg-12">
                    <div class="text-center mt-5">
                        <button type="submit" class="theme-btn m-2 submit-btn">{{__('Update')}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('js')
    <script src="{{ asset('assets/js/summernote-lite.js') }}"></script>
    <script>
        $('#summernote').summernote();
    </script>
@endpush

