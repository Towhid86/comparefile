<div class="modal fade" id="role-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">{{ __('assigned role') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="roleForm" action="{{ role_route('permissions.store') }}" method="post"
                        class="row ajaxform_instant_reload">
                    @csrf

                    <div class="col-12 form-group mb-3">
                        <label for="user_id" class="required">{{ __("user") }}</label>
                        <select name="user_id" id="user_id" class="form-control" required>
                            <option>{{ __("select-user") }}</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ ucfirst($user->name) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 form-group mb-3">
                        <label for="role_id" class="required">{{ __("role") }}</label>
                        <select name="role_id" id="role_id" class="form-control" required>
                            <option>{{ __("select-role") }}</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 text-center mt-4">
                        <button type="reset" class="btn btn-sm role-reset-btn">
                            <i class="fas fa-undo-alt"></i> {{ __("reset") }}
                        </button>
                        <button type="submit" class="btn btn-sm btn-warning btn-custom-warning fw-bold me-2 submit-btn"><i class="fas fa-save"></i> {{ __("save") }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
