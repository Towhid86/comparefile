@extends('layouts.author.master')

@section('title')
    {{ __('Subscription Plan')  }}
@endsection

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="table-header border-0">
                <h4>{{__('Subscription Plan')}}</h4>
                <div class="d-flex align-items-center gap-2">
                    @can('plans-create')
                        <a href="{{ route('author.plans.create') }}" class="add-order-btn rounded-2 {{ Route::is('author.plans.create') ? 'active' : '' }}"><i class="fas fa-plus-circle"></i> {{ __('Add New Package') }}</a>
                    @endcan
                    <a href="#" class="p-0" data-bs-toggle="modal" data-bs-target="#subscription-setting-modal">
                        <img src="{{ asset('assets/images/icons/settings-rectangle.svg')}}" alt="icon">
                    </a>
                </div>
            </div>

            @php
            $duration_types = ['monthly', 'yearly', 'lifetime'];
            @endphp

            <div class="subscription-plan-tabs">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    @foreach($duration_types as $duration_type)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $loop->iteration == 1 ? 'active' : '' }}" id="subscription-{{ $duration_type }}" data-bs-toggle="tab" data-bs-target="#subscription-{{ $duration_type }}-pane" type="button" role="tab" aria-controls="subscription-{{ $duration_type }}-pane" aria-selected="false" tabindex="-1">{{ $duration_type }}</button>
                        </li>
                    @endforeach
                  </ul>
                @foreach($duration_types as $duration_type)
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade {{ $loop->iteration == 1 ? 'active show' : '' }}"
                             id="subscription-{{ $duration_type }}-pane" role="tabpanel"
                             aria-labelledby="subscription-{{ $duration_type }}" tabindex="0">
                            <div class="row">
                                @foreach($plans->where('duration_type', $duration_type)->merge($plans->where('duration_type', null))->sortBy('duration') as $plan)
                                    <div class="col-xxl-3 col-lg-4 col-sm-6 mt-5">

                                        @php
                                            $currentPlanSetting = $plan_settings->where('plan_id', $plan->id)->first();
                                        @endphp

                                        <div class="content {{ $currentPlanSetting ? 'active' : '' }}">
                                            <div class="most-popular">
                                                {{ $currentPlanSetting ? $currentPlanSetting->title : '' }}
                                            </div>
                                            <div class="border-bottom p-3">
                                                <div class="title d-flex align-items-center gap-2">
                                                    <h4 class="text-blue">{{ $plan->name }}</h4>
                                                    @if($plan->sales_price > 0)
                                                        <button>
                                                            {{ $plan->discount }}% OFF
                                                        </button>
                                                    @endif
                                                </div>
                                                <p>{{ $plan->subtitle }}</p>
                                                <div class="d-flex align-items-center gap-2">
                                                    <h4>${{ $plan->sales_price }}</h4>
                                                    @if($plan->sales_price > 0)
                                                        <p class="main-price">${{ $plan->price }}</p>
                                                        <img src="{{ asset('assets/images/icons/draw.svg')}}" alt="icon" class="w-52">
                                                        <p class="text-green">Save ${{ $plan->price - $plan->sales_price }}</p>
                                                    @else
                                                        <p class="main-price">/ Free Forever</p>
                                                    @endif

                                                </div>
                                            </div>
                                            <div class="features p-3">
                                                @foreach($plan->features ?? [] as $key => $feature)
                                                    <div class="d-flex align-items-center gap-2 mb-2">
                                                        @if(isset($feature['status']) && $feature['status'] == 1)
                                                            <img src="{{ asset('assets/images/icons/right-circle.svg')}}" alt="icon">
                                                        @else
                                                            <img src="{{ asset('assets/images/icons/cross-btn.svg')}}" alt="icon">
                                                        @endif
                                                        <p>{{ $feature['name'] ?? '' }}</p>
                                                        <div class="alert-circle " data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="{{ $feature['details'] ?? '' }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none"><g clip-path="url(#clip0_2602_23137)"><path d="M7.99967 14.6654C11.6816 14.6654 14.6663 11.6806 14.6663 7.9987C14.6663 4.3168 11.6816 1.33203 7.99967 1.33203C4.31778 1.33203 1.33301 4.3168 1.33301 7.9987C1.33301 11.6806 4.31778 14.6654 7.99967 14.6654Z" stroke="#97979F" stroke-linecap="round" stroke-linejoin="round"/><path d="M8 5.33203V7.9987" stroke="#97979F" stroke-linecap="round" stroke-linejoin="round"/><path d="M8 10.668H8.00667" stroke="#97979F" stroke-linecap="round" stroke-linejoin="round"/></g><defs><clipPath id="clip0_2602_23137"><rect width="16" height="16" fill="white"/></clipPath></defs></svg>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <div
                                                class="btns d-flex p-3 align-items-center justify-content-center gap-2">
                                                <button>
                                                    <a href="{{ route('author.plans.destroy', $plan->id) }}" class="confirm-action" data-method="DELETE">
                                                        {{ __('Delete') }}
                                                    </a>
                                                </button>
                                                <button>
                                                    <a  href="{{ route('author.plans.edit', $plan->id) }}">{{('Edit')}}</a>
                                                </button>

                                            </div>

                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="modal fade" id="plan-view-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">{{ __('Features List') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="personal-info" id="features-list">
                        {{-- will be added for js --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-custom-design" id="subscription-setting-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Subscription Plan  Setting </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('author.plan-settings.store') }}" method="post" enctype="multipart/form-data" class="ajaxform_instant_reload">
                    @csrf
                  <div class="mt-2">
                    <label for="category-name" class="col-form-label fw-medium">Highlight Package </label>
                    <div class="input-wrapper pos-up-down-arrow">
                        <select name="plan_id" class="form-control m-0" required="">
                            <option value="10">Select one</option>
                            @foreach($plans as $plan)
                            <option value="{{ $plan->id }}">{{ $plan->name }}</option>
                            @endforeach
                        </select>
                        <span class="pos-right-arrow"></span>
                    </div>
                  </div>
                  <div class="mt-2">
                    <label for="category-name" class="col-form-label fw-medium">Title</label>
                    <input type="text" name="title" class="form-control" id="category-name" placeholder="Most Popular">
                  </div>

                    <div class="col-lg-12">
                        <div class="button-group text-center mt-5">
                            <button type="reset" class="theme-btn border-btn m-2">{{ __('Reset') }}</button>
                            <button class="theme-btn m-2 submit-btn">{{ __('Save') }}</button>
                        </div>
                    </div>
                </form>
            </div>

          </div>
        </div>
    </div>

@endsection
@push('modal')
    @include('author.components.multi-delete-modal')
@endpush

@push('js')
    <script src="{{ asset('assets/js/custom/custom.js') }}"></script>
@endpush
