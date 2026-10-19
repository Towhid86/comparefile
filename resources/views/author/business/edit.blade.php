@extends('layouts.author.master')

@section('title')
    {{ __('Shop') }}
@endsection

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="table-header">
                <h4>{{__('Edit Shop')}}</h4>
                @can('business-read')
                <a href="{{ route('author.business.index') }}" class="add-order-btn rounded-2 {{ Route::is('authorbusiness.create') ? 'active' : '' }}"><i class="far fa-list" aria-hidden="true"></i> {{ __('Shop List') }}</a>
                @endcan
            </div>
            <div class="order-form-section">
                <form action="{{ route('author.business.update', $business->id) }}" method="post" enctype="multipart/form-data"
                      class="ajaxform_instant_reload">
                    @csrf
                    @method('put')
                    <div class="add-suplier-modal-wrapper">
                        <div class="row">
                            <div class="col-lg-6">
                                <label>Image</label>
                                <div class="upload-img-v2">
                                    <label class="upload-v4 image-height">
                                        <div class="img-wrp">
                                            <img src="{{ asset($business->user->image ?? 'assets/images/icons/upload-icon.svg') }}" alt="" id="profile-img">
                                        </div>
                                        <input type="file" name="image" class="d-none" onchange="document.getElementById('profile-img').src = window.URL.createObjectURL(this.files[0])" accept="image/*">
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <div class="col-lg-12 mt-2">
                                    <label>{{__('Business Category')}}</label>
                                    <div class="gpt-up-down-arrow position-relative">
                                        <select name="business_category_id" required class="form-control table-select w-100 role">
                                            <option value=""> {{__('Select Category')}}</option>
                                            @foreach ($business_categories as $category)
                                                <option value="{{ $category->id }}" {{ optional($business->businessCategory)->id == $category->id ? 'selected' : '' }}>{{ ucfirst($category->name) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12 mt-2">
                                    <label>{{('Shop/Business Name')}}</label>
                                    <input type="text" name="business_name" value="{{ $business->name }}" required class="form-control" placeholder="Enter Shop/Business Name">
                                </div>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label>{{__('Package')}}</label>
                                <div class="gpt-up-down-arrow position-relative">
                                    <select name="plan_id" required class="form-control table-select w-100 role">
                                        <option value=""> {{__('Select a package')}}</option>
                                        @foreach ($plans as $plan)
                                            <option value="{{ $plan->id }}" {{ optional($business->user->plan)->id == $plan->id ? 'selected' : '' }}> {{ $plan->name }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label>{{('Name')}}</label>
                                <input type="text" name="name" value="{{ $business->user->name ?? '' }}" required class="form-control" placeholder="Enter Name">
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label>{{__('Role')}}</label>
                                <div class="$rolegpt-up-down-arrow position-relative">
                                    <select name="role" required class="form-control table-select w-100 role">
                                        <option value=""> {{__('Select a role')}}</option>
                                        @foreach ($roles as $role)
                                            <option
                                                value="{{ $role->name }}" @selected($role->name == $business->user->role ?? '')> {{ ucfirst($role->name) }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label>{{__('Email')}}</label>
                                <input type="email" name="email" value="{{ $business->user->email ?? '' }}" required
                                       class="form-control" placeholder="Enter Email">
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label>{{__('Phone')}}</label>
                                <input type="text" name="phone" value="{{ $business->user->phone ?? '' }}" class="form-control"
                                       placeholder="Enter Phone Number">
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label>{{__('Password')}}</label>
                                <input type="password" name="password" class="form-control"
                                       placeholder="Enter Password">
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label>{{__('Confirm password')}}</label>
                                <input type="password" name="password_confirmation" class="form-control"
                                       placeholder="Enter Confirm password">
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label>{{__('Address')}}</label>
                                <textarea name="business_address" class="form-control" placeholder="Enter Address">{{ $business->business_address }}</textarea>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label>{{__('Select Country')}}</label>
                                <div class="gpt-up-down-arrow position-relative">
                                    <select name="country_id" required class="form-control table-select w-100 role">
                                        <option value=""> {{__('Select a Country')}}</option>
                                        @foreach ($countries as $country)
                                            <option
                                                value="{{ $country->id }}" @selected($country->id == $business->user->country_id ?? '')> {{ $country->name }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label>{{('Balance')}}</label>
                                <input type="number" step="any" name="balance" value="{{ $business->balance }}"  class="form-control" placeholder="Enter Balance">
                            </div>

                            <div class="col-lg-12">
                                <div class="button-group text-center mt-5">
                                    <a type="reset" class="theme-btn border-btn m-2">{{ __('Reset') }}</a>
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
