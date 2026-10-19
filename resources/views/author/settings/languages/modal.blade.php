<div class="modal fade" id="language-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">{{ __('Country') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="personal-info">
                    <form id="languageForm" action="{{ route('author.languages.store') }}" method="post" enctype="multipart/form-data" class="ajaxform_instant_reload">
                        @csrf
                        <div class="add-suplier-modal-wrapper">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label>Flag</label>
                                    <div class="upload-img-v2">
                                        <label class="upload-v4 image-height">
                                            <div class="img-wrp">
                                                <img src="{{ asset('assets/images/icons/upload-icon.svg') }}" alt="user" id="img">
                                            </div>
                                            <input type="file" name="flag" class="d-none" onchange="document.getElementById('img').src = window.URL.createObjectURL(this.files[0])" accept="image/*">
                                        </label>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="col-lg-12 mt-2">
                                        <label>{{('Name')}}</label>
                                        <input type="text" name="name" required class="form-control" placeholder="Language Name">
                                    </div>
                                    <div class="col-lg-12 mt-2">
                                        <label>{{('Short Name')}}</label>
                                        <input type="text" name="alias" required class="form-control" placeholder="Language Short Name">
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <label>{{ __('Direction') }}</label>
                                    <div class="gpt-up-down-arrow position-relative">
                                        <select name="direction" required class="form-control select-dropdown">
                                            <option value="ltl">{{ __('LTL') }}</option>
                                            <option value="rtl">{{ __('RTL') }}</option>
                                        </select>
                                        <span></span>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="button-group text-center mt-5">
                                        <a type="reset" class="theme-btn border-btn m-2">{{ __('Cancel') }}</a>
                                        <button class="theme-btn m-2 submit-btn">{{__('Save')}}</button>
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
