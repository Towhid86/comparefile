@extends('layouts.author.master')

@section('title')
    {{ __('Edit Subscription Plan') }}
@endsection

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="table-header">
                <h4>{{__('Edit Package')}}</h4>
                @can('plans-read')
                    <a href="{{ route('author.plans.index') }}" class="add-order-btn rounded-2 {{ Route::is('author.users.create') ? 'active' : '' }}"><i class="far fa-list" aria-hidden="true"></i> {{ __('Package List') }}</a>
                @endcan
            </div>
            <div class="order-form-section mt-3">
                <form action="{{ route('author.plans.update', $plan->id) }}" method="POST" class="ajaxform_instant_reload">
                    @csrf
                    @method('put')
                    <div class="add-suplier-modal-wrapper d-block">
                        <div class="row">
                            <div class="col-lg-6 mb-2">
                                <label>{{ __('Package Name') }}</label>
                                <input type="text" name="name" value="{{ $plan->name }}" required class="form-control" placeholder="{{ __('Enter Package Name') }}">
                            </div>
                            <div class="col-lg-6 mb-2">
                                <label>{{ __('Subtitle') }}</label>
                                <input type="text" name="subtitle" value="{{ $plan->subtitle }}" required class="form-control" placeholder="{{ __('Enter Subtitle') }}">
                            </div>
                            <div class="col-lg-6 mb-2">
                                <label>{{ __('Duration Type') }}</label>
                                <div class="gpt-up-down-arrow position-relative">
                                    <select name="duration_type" class="form-control select-dropdown">
                                        <option value="">{{ __('Select Duration') }}</option>
                                        <option value="monthly" @selected($plan->duration_type == 'monthly')>{{ __('Monthly') }}</option>
                                        <option value="yearly" @selected($plan->duration_type == 'yearly')>{{ __('Yearly') }}</option>
                                        <option value="lifetime" @selected($plan->duration_type == 'lifetime')>{{ __('Lifetime') }}</option>
                                    </select>
                                    <span></span>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <label>{{ __('Duration') }}</label>
                                <input type="number" name="duration" class="form-control" max="11"  value="{{ $plan->duration }}" placeholder="{{ __('Enter number') }}">
                            </div>
                            <div class="col-lg-6 mb-2">
                                <label>{{ __('Role') }}</label>
                                <div class="gpt-up-down-arrow position-relative">
                                    <select name="role" required class="form-control select-dropdown">
                                        <option value="">{{ __('Select Role') }}</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->name }}" @selected($plan->role == $role->name)>{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    <span></span>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <label>{{ __('Regular Price') }}</label>
                                <input type="number" min="0" step="any" name="price" value="{{ $plan->price }}" required class="form-control price" placeholder="{{ __('Enter Plan Price') }}">
                            </div>
                            <div class="col-lg-6 mb-2">
                                <label>{{ __('Discount(%)') }}</label>
                                <input type="number" min="0" max="100" name="discount" value="{{ $plan->discount }}" class="form-control discount" placeholder="{{ __('Enter Discount') }}">
                            </div>

                            <div class="col-lg-6 mb-2">
                                <label>{{__('Saved')}}</label>
                                <input type="number" id="saved_price" value="{{ $plan->price - $plan->sales_price }}" readonly placeholder="Saved Price" class="form-control">
                            </div>

                            <div class="col-lg-6 mb-2">
                                <label>{{__('Sales Price')}}</label>
                                <input type="number" id="sales_price" value="{{ $plan->sales_price }}" readonly placeholder="Sales Price" class="form-control">
                            </div>

                            <div class="col-lg-12">
                                <h6>{{__('Add Features')}}</h6>
                            </div>

                            <div class="col-lg-6 mb-2">
                                <label>{{ __('Features Name') }}</label>
                                <input type="text" class="form-control add-feature-name" placeholder="{{ __('Enter Features Name') }}">
                            </div>

                            <div class="col-lg-6 mb-2">
                                <label>{{ __('Details') }}</label>
                                <input type="text" class="form-control add-feature-details" placeholder="{{ __('Enter Details') }}">
                            </div>


                            <div class="col-lg-6 mb-4">
                                <button class="add-feature-btn" id="feature-btn">{{__('Save')}}</button>
                            </div>

                            <div class="col-lg-12">
                                <h6>{{__('All Features')}}</h6>
                            </div>
                            <div class="accordion mt-3" id="accordionExample">
                                <div class="row feature-list">
                                    @foreach($plan->features ?? [] as $key => $feature)
                                    <div class="col-md-6 remove-list">

                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <div class="feature-add-wrp accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                    <div class="form-control d-flex justify-content-between align-items-center">
                                                        <input type="text" name="features[{{ $key }}][name][]" value="{{ $feature['name'] ?? '' }}" class="form-control">
                                                        <label class="switch">
                                                            <input type="checkbox" class="plan-checkbox" name="features[{{ $key }}][status][]" {{ isset($feature['status']) && $feature['status'] == 1 ? 'checked' : '' }}>
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </div>
                                                    <button type="button" class="remove-one"><i class="fas fa-trash-alt"></i></button>
                                                </div>
                                            </h2>
                                            <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="col-lg-12 mt-1">
                                                        <input type="text" name="features[{{ $key }}][details][]" value="{{ $feature['details'] ?? '' }}" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="button-group text-center mt-5">
                                    <button type="reset" class="theme-btn border-btn m-2">Reset</button>
                                    <button class="theme-btn m-2 submit-btn">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/js/custom/custom.js') }}"></script>
@endpush
