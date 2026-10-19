<div class="modal fade" id="payment-type-edit-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">{{ __('Edit Payment Type') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="payment_type_edit_form" enctype="multipart/form-data" class="ajaxform_instant_reload">
                    @csrf
                    @method('put')
                    <div class="row">
                        <div class="col-lg-12 mt-2">
                            <label>{{('Name')}}</label>
                            <input type="text" name="name" id="payment_type_edit_name" required class="form-control" placeholder="Enter Payment Type">
                        </div>
                        <div class="col-lg-12 mt-2">
                            <label>{{__('Status')}}</label>
                            <div class="form-control d-flex justify-content-between align-items-center radio-switcher">
                                <p class="dynamic-text">{{ __('Active') }}</p>
                                <label class="switch m-0">
                                    <input type="checkbox" name="status" id="payment_type_edit_status" class="change-text">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="button-group text-center mt-5">
                                <button type="reset" class="theme-btn border-btn m-2">{{ __('Reset') }}</button>
                                <button class="theme-btn m-2 submit-btn">{{ __('Save') }}</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
