@extends('layouts.author.master')

@section('title')
    {{ __('assigned role') }}
@endsection

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="table-header">
                <h4>{{__('assigned role')}}</h4>
            </div>
            <div class="row justify-content-center mt-4">
                <div class="col-md-8">
                    <div class="card shadow border-0">
                        <div class="card-body">
                            <div class="table-header">
                                <h3>{{ __("assign-role-to-user") }}</h3>
                                 @can('posts-create')
                                <a href="#role-modal" data-bs-toggle="modal" class="add-order-btn rounded-2"><i class="fas fa-plus-circle"></i> {{ __('Assign Role') }}</a>
                            @endcan
                            </div>

                            <div class="row">
                                @foreach ($users->filter(fn($u) => $u->roles->isNotEmpty()) as $user)
                                    <div class="col-12 col-md-6 col-lg-6 mb-3">
                                        <div class="alert alert-info d-flex justify-content-between align-items-center flex-wrap h-100">
                                            <!-- User Info & Roles -->
                                            <div class="mb-2 mb-md-0">
                                                <strong>{{ $user->name }}</strong> - {{ __('has-role') }}:
                                                @foreach ($user->roles as $role)
                                                    <span class="badge bg-secondary">{{ $role->name }}</span>
                                                @endforeach
                                            </div>

                                            <!-- Actions Dropdown -->
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="far fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    @can('roles-update')
                                                        <li>
                                                            <a href="#"
                                                            class="dropdown-item edit-btn"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#role-modal"
                                                            data-form="roleForm"
                                                            id="role_edit_{{ $user->id }}"
                                                            data-id="{{ $user->id }}"
                                                            data-user_id="{{ $user->id }}"
                                                            data-role_id="{{ $user->roles[0]['id'] ?? '' }}"
                                                            data-url="{{ role_route_with_id('permissions.update', $user->id) }}">
                                                                <i class="fal fa-pencil-alt me-1"></i> {{ __('Edit') }}
                                                            </a>
                                                        </li>
                                                    @endcan

                                                    @can('roles-delete')
                                                        <li>
                                                            <a href="{{ role_route_with_id('permissions.destroy', $user->id) }}"
                                                            class="dropdown-item confirm-action"
                                                            data-method="DELETE">
                                                                <i class="fal fa-trash-alt me-1"></i> {{ __('Delete') }}
                                                            </a>
                                                        </li>
                                                    @endcan
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('modal')
    @include('author.permissions.modal')
@endpush

@push('js')
    <script src="{{ asset('assets/js/custom/custom.js') }}"></script>
@endpush
