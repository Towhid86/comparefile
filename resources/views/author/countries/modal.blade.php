
<div class="modal fade" id="country-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">{{ __('Country') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="personal-info">
                    <form id="countryForm" action="{{ route('author.countries.store') }}" class="ajaxform_instant_reload" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="col-sm-12 col-lg-12">
                            <div class="row">
                                <div class="col-12 col-lg-6 mt-2">
                                    <label>{{(' Name')}}</label>
                                    <input type="text" name="name" required class="form-control" placeholder="Enter name">
                                </div>
                                <div class="col-12 col-lg-6 mt-2">
                                    <label>{{('Nick Name')}}</label>
                                    <input type="text" name="nick_name" class="form-control" placeholder="Enter nick name" required>
                                </div>
                                <div class="col-12 col-lg-6 mt-2">
                                    <label>{{('Iso Code')}}</label>
                                    <input type="text" name="iso_code" class="form-control" placeholder="Enter phone">
                                </div>
                                <div class="col-12 col-lg-6 mt-2">
                                    <label>{{('Alpha2 Code')}}</label>
                                    <input type="text" name="alpha2_code"  class="form-control" placeholder="Enter alpha2">
                                </div>
                                <div class="col-12 col-lg-6 mt-2">
                                    <label>{{('Alpha3 Code')}}</label>
                                    <input type="text" name="alpha3_code"  class="form-control" placeholder="Enter alpha3">
                                </div>
                                <div class="col-12 col-lg-6 mt-2">
                                    <label>{{('Phone Code')}}</label>
                                    <input type="text" name="phone_code"  class="form-control" placeholder="Enter phone code">
                                </div>

                                <div class="col-lg-12">
                                    <div class="button-group text-center mt-5">
                                        <button type="button" class="theme-btn border-btn m-2" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                                        <button type="submit" class="theme-btn m-2 submit-btn">{{ __('Save') }}</button>
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


