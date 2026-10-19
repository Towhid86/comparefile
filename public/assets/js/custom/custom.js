////////////////////////////////////////////////////////////////////////////////////////////////////

$('.view-btn').each(function () {
    let container = $(this);
    let id = container.data('id');

    // User View Modal
    $('#user_view_' + id).on('click', function () {
        $('#user_view_business_category').text($('#user_view_' + id).data('business_category'));
        $('#user_view_business_name').text($('#user_view_' + id).data('business_name'));

        let imageSrc = $('#user_view_' + id).data('image');
        $('#user_view_image').attr('src', imageSrc);
        $('#user_view_name').text($('#user_view_' + id).data('name'));
        $('#user_view_role').text($('#user_view_' + id).data('role'));
        $('#user_view_email').text($('#user_view_' + id).data('email'));
        $('#user_view_phone').text($('#user_view_' + id).data('phone'));
        $('#user_view_address').text($('#user_view_' + id).data('address'));
        $('#user_view_country_id').text($('#user_view_' + id).data('country_id'));
        $('#user_view_statfeatures-listus').text($('#user_view_' + id).data('status') == 1 ? 'Active' : 'Deactive');    });

    // Plan View Modal
    $('#plan_view_' + id).on('click', function () {
        let features =$('#plan_view_' + id).data('features');
        let featuresList = $('#features-list');

        featuresList.empty();

        features.forEach(feature => {
            let featureHtml = `
                <div class="row align-items-center mt-3 feature-entry">
                    <div class="col-md-1">
                        <p id="plan_view_features_yes">
                            ${feature.value == 1 ? '<i class="fas fa-check-circle"></i>' : '<i class="fas fa-times-circle"></i>'}
                        </p>
                    </div>
                    <div class="col-1">
                        <p>:</p>
                    </div>
                    <div class="col-md-7">
                        <p id="plan_view_features_name">${feature.name}</p>
                    </div>
                </div>
            `;

            featuresList.append(featureHtml);
        });
    });

    // Category View
    $('#category_view_' + id).on('click', function () {
        $('#category_view_name').text($('#category_view_' + id).data('name'));
        $('#category_view_description').text($('#category_view_' + id).data('description'));
        $('#category_view_status').text($('#category_view_' + id).data('status') == 1 ? 'Active' : 'Deactive');
    });
    // Faqs view
    $('#faqs_view_' + id).on('click', function () {
        $('#faqs_view_question').text($('#faqs_view_' + id).data('question'));
        $('#faqs_view_answer').text($('#faqs_view_' + id).data('answer'));
        $('#faqs_view_status').text($('#faqs_view_' + id).data('status') == 1 ? 'Active' : 'Deactive');
    });

});

// edit modal

// ✅ When modal closes, reset/clear form
$('.modal').on('hidden.bs.modal', function () {
    let form = $(this).find('form');
    if (form.length) {
        // Clear all inputs
        //form[0].reset(); // Native reset clears values
        form.trigger('reset');
        // Extra clear for file inputs
        form.find('input[type="file"]').val('');

        // Remove hidden PUT method input (if you want to reset it too)
        form.find('input[name="_method"]').remove();
        form.find('input[name="_method"]').remove();
        form.attr('action', form.data('create-url'));
    }
});

$(document).on('click', '.edit-btn', function () {
        let $this = $(this),
            formId = $this.data('form'),
            form = $('#' + formId);

        if (!form.length) return;

        form.find('input[name="password"], input[name="password_confirmation"]').removeAttr('required');

        form.find(':input').each(function () {
            let $field = $(this);
            let fieldName = $field.attr('name');
            if (fieldName && $this.data(fieldName) !== undefined) {
                let value = $this.data(fieldName);

                if ($field.is(':checkbox')) {
                    $field.prop('checked', value === 'on' || !!value);
                }
                else if ($field.is(':radio')) {
                    form.find(`input[name="${fieldName}"][value="${value}"]`).prop('checked', true);
                }
                else if ($field.hasClass('summernote')) {
                    if ($field.next('.note-editor').length) {
                        $field.summernote('code', value);
                    } else {
                        $field.summernote({ height: 200 }).summernote('code', value);
                    }
                }
                else if ($field.attr('type') === 'file') {
                    // ✅ Skip setting value for file inputs (for security reasons)
                    $field.val('');
                }
                else {
                    $field.val(value);
                }
            }
        });

        // Ensure PUT method input exists
        if (!form.find('input[name="_method"]').length) {
            form.append('<input type="hidden" name="_method" value="PUT">');
        }

        // Update action URL
        form.attr('action', $this.data('url'));

        // ✅ Show image preview if exists
        let imageUrl = $this.data('image') || '/assets/images/icons/upload-icon.svg';;
        if (imageUrl) {
            $('#imgPreview').attr('src','/'+ imageUrl).show();
        } else {
            $('#imgPreview').hide();
        }
    });

$('.edit-btn').each(function () {
    let container = $(this);
    let service = container.data('id');
    let id = service;


    $('#menu_edit_'+service).on('click',function () {
        $('#menu_edit_name').val($('#menu_edit_'+service).data('name'));
        $('#menu_edit_menu_id').val($('#menu_edit_'+service).data('menu_id')).prop('selected', true);
        $('#menu_edit_type').val($('#menu_edit_'+service).data('type')).prop('selected', true);
        $('#menu_edit_position').val($('#menu_edit_'+service).data('position')).prop('selected', true);
        $('#menu_edit_content_position').val($('#menu_edit_'+service).data('content_position')).prop('selected', true);
        $('#menu_edit_priority').val($('#menu_edit_'+service).data('priority'));
        $('.dynamic-text').text($('#menu_edit_'+service).data('status') == 1 ? 'Active' : 'Deactive');
        let edit_action_route = $(this).data('url');
        $('#menu_edit_form').attr('action', edit_action_route+'/'+id);
    });
    $('#company_edit_'+service).on('click',function () {
        $('#name').val($('#company_edit_'+service).data('name'));
        $('#email').val($('#company_edit_'+service).data('email'));
        $('#phone').val($('#company_edit_'+service).data('phone'));
        $('#address').val($('#company_edit_'+service).data('address'));
        $('#address_map').val($('#company_edit_'+service).data('address-map'));
        $('#office_time').val($('#company_edit_'+service).data('office-time'));
        $('#facebook').val($('#company_edit_'+service).data('facebook'));
        $('#linkedin').val($('#company_edit_'+service).data('linkedin'));
        $('#instagram').val($('#company_edit_'+service).data('instagram'));
        $('#x').val($('#company_edit_'+service).data('x'));
        $('#company_edit_company_id').val($('#company_edit_'+service).data('company_id')).prop('selected', true);
        $('.dynamic-text').text($('#company_edit_'+service).data('status') == 1 ? 'Active' : 'Deactive');
        let edit_action_route = $(this).data('url');
        $('#company_edit_form').attr('action', edit_action_route+'/'+id);

    });
    // language edit
    $('#language_edit_' + service).on('click', function () {
        const $this = $(this);
        const form = $('#languageForm');

        // Update form fields with data attributes
        $('input[name="name"]').val($this.data('name'));
        $('input[name="alias"]').val($this.data('alias'));
        $('select[name="direction"]').val($this.data('direction'));
        // Handle image preview
        const flag = $this.data('flag') || '/assets/images/icons/upload-icon.svg';
        $('#img').attr('src', flag);
        // Ensure PUT method is included in the form
        //if ($('input[name="_method"]').length === 0) {
            form.append('<input type="hidden" name="_method" value="PUT">');
       // }

        // Update the form action URL
        form.attr('action', $this.data('url'));
    });

    // post edit
    $('#post_edit_' + service).on('click', function () {
        const $this = $(this);
        const form = $('#postForm');

        // Update form fields with data attributes
        $('select[name="menu_id"]').val($this.data('menu_id'));
        $('input[name="title"]').val($this.data('title'));
        $('textarea[name="description"]').summernote('code', $this.data('description'));
        $('input[name="meta_keywords"]').val($this.data('meta_keywords'));
        $('textarea[name="meta_description"]').val($this.data('meta_description'));

        // Handle image preview
        const image = $this.data('image') || '/assets/images/icons/upload-icon.svg';
        $('#post_image').attr('src', '/' + image);

        // Toggle visibility of sections based on menu name
        const menuType = $this.data('menu_type');
        $('.settings-image-upload').toggle(!(menuType === 'experience' || menuType === 'skills'));
        $('.skills').toggle(menuType === 'skills');
        $('.description').toggle(!(menuType === 'skills'));
        $('.experience').toggle(menuType === 'experience');
        $('.project').toggle(/project(s)?/i.test(menuType));

        let value_data = $this.data('value'); // jQuery auto-parses JSON

        // Update URL field
        $('input[name="url"]').val(value_data.url);

        // Update organization and duration fields
        $('input[name="organization"]').val(value_data.organization);
        $('input[name="duration"]').val(value_data.duration);

         if (value_data.tags) {
             $('input[name="tags"]').val(value_data.tags);
         }
          // Clear all skill rows except the first one
        $('.skills-list .remove-list:not(:first)').remove();
        // Clear values in the first row
        $('input[name="skill_name[]"]').first().val('');
        $('input[name="proficiency[]"]').first().val('');

        if (value_data.skill_name && Array.isArray(value_data.skill_name)) {
            value_data.skill_name.forEach((skill, index) => {
                if (index === 0) {
                    $('input[name="skill_name[]"]').first().val(skill);
                    $('input[name="proficiency[]"]').first().val(value_data.proficiency?.[index] ?? '');
                } else {
                    $('#skills-btn').trigger('click');
                    $('input[name="skill_name[]"]').last().val(skill);
                    $('input[name="proficiency[]"]').last().val(value_data.proficiency?.[index] ?? '');
                }
            });
        }
        // Ensure PUT method is included in the form
        //if ($('input[name="_method"]').length === 0) {
            form.append('<input type="hidden" name="_method" value="PUT">');
       // }

        // Update the form action URL
        form.attr('action', $this.data('url'));
    });

    //w
    $('#banner_edit_'+service).on('click',function () {
        $('#title').val($('#banner_edit_'+service).data('title'));
        $('#sub_title').val($('#banner_edit_'+service).data('sub-title'));
        $('#description').val($('#banner_edit_'+service).data('description'));
        //$('#banner').attr('src').empty();
        //let banner = $('#banner_edit_'+service).data('banner');
        var bannerUrl = $('#banner_edit_'+service).data('banner');
                 if (bannerUrl) {
                    $('#banner-edit').attr('src',bannerUrl);
                }

        let edit_action_route = $(this).data('url');
        $('#banner_edit_form').attr('action', edit_action_route+'/'+id);

    });

    $('#partner_edit_'+service).on('click',function () {
        $('#name').val($('#partner_edit_'+service).data('name'));
        //$('#partner').attr('src').empty();
        //let partner = $('#partner_edit_'+service).data('partner');
        var logoUrl = $('#partner_edit_'+service).data('logo');
                 if (logoUrl) {
                    $('#logo-edit').attr('src',logoUrl);
                }

        let edit_action_route = $(this).data('url');
        $('#partner_edit_form').attr('action', edit_action_route+'/'+id);

    });

});

/** Subscriptions Plan start */

function updateSalesPrice() {
    let price = parseFloat($('.price').val()) || 0;
    let discount = parseFloat($('.discount').val()) || 0;

    if (discount > 100) {
        toastr.warning('Discount cannot be more than the 100.', 'Warning');
        return;
    }

    // Calculate the sales price based on discount
    let salesPrice = 0;
    let savedPrice = 0;
    let discountAmount = price * (discount / 100);
    salesPrice = price - discountAmount;
    savedPrice = price - salesPrice;
    $('#sales_price').val(salesPrice.toFixed(2));
    $('#saved_price').val(savedPrice.toFixed(2));
}

// updateSalesPrice will be called when these fields change
$('.price, .discount').on('input change', updateSalesPrice);

//dynamic btn
/** Subscriptions Plan end */
 //dynamic skills btn
 let a =0;
$("#skills-btn").click(function(e){
    e.preventDefault();
    a++;
    var index = $('.skills-list').children().length;
    var name = $('.add-skills-name').val();
    if (name !=='') {

        $('.skills-list').append(`
            <div class="row align-items-end skills-row remove-list">
                <!-- Skill Name -->
                <div class="col-lg-5 mt-2">
                    <input type="text" class="form-control" name="skill_name[]" id="skillName[${a}]" placeholder="e.g., JavaScript" required>
                </div>

                <!-- Proficiency Level -->
                <div class="col-lg-5 mt-2">
                    <input type="number" class="form-control" name="proficiency[]"  id="skillLevel[${a}]" min="1" max="100" value="80" required>
                </div>

                <!-- Remove Button -->
                <div class="col-lg-2 mt-2 d-flex justify-content-start align-items-start">
                    <button type="button" class="btn btn-link btn-sm text-danger p-0 remove-one" title="Remove">
                        <i class="fas fa-trash-alt fs-5"></i>
                    </button>
                </div>
            </div>
        `);


        $('.add-skills').val('');
    }
});
$(function () {
    $("body").on("click", ".remove-one", function () {
        $(this).closest(".remove-list").remove();
    });
});
$('#post-modal').on('hidden.bs.modal', function () {
    //$('.remove-list').html(''); // Clear all dynamic rows
    $('.remove-list').remove();
    a = 1; // Reset the counter
});

var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
