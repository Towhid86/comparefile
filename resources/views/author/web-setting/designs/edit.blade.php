@extends('layouts.author.master')

@section('title')
    {{ __('Edit Design') }}
@endsection

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="table-header">
                        <h4>{{  __('Edit Design') }}</h4>
                        <div>
                            <a href="{{ route('author.designs.index') }}" class="theme-btn print-btn text-light">
                                <i class="fas fa-list me-1"></i>
                                {{ __("View List") }}
                            </a>
                        </div>
                    </div>

                    <div class="order-form-section">
                        <form action="{{ route('author.designs.update', $design->id) }}" method="post" enctype="multipart/form-data" class="ajaxform_instant_reload">
                            @csrf
                            @method('put')

                            <div class="add-suplier-modal-wrapper">
                                <div class="row">

                                    <div class="col-lg-5 mt-2 align-self-center">
                                        <label>{{ __('Image') }}</label>
                                        <input type="file" name="image" class="form-control">
                                    </div>

                                    <div class="col-lg-1 mt-2 align-self-center mt-4">
                                        <img class="table-img" src="{{ asset($design->value['image']) }}" alt="img">
                                    </div>

                                    <div class="col-sm-6 mt-2">
                                        <label>{{ __('Status') }}</label>
                                        <div class="gpt-up-down-arrow position-relative">
                                            <select name="status" required="" class="form-control select-dropdown">
                                                <option @selected($design->status == 1) value="1">{{ __('Active') }}</option>
                                                <option @selected($design->status == 0) value="0">{{ __('Deactive') }}</option>
                                            </select>
                                            <span></span>
                                        </div>
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
