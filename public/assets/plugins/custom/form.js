const CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
$.ajaxSetup({ headers: { "X-CSRF-TOKEN": CSRF_TOKEN } });
let $savingLoader = '<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div>',

    $ajaxform = $(".ajaxform");
$ajaxform.initFormValidation(),
//phone validation
 $('input[name="phone"]').on('input', function () {
    this.value = this.value.replace(/[^0-9()+\-.\s]/g, '');
});
//password validation
/*  $('input[name="password"]').on('input', function () {
    const password = $(this).val();
    const pattern = /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&]).{8,}$/;

    if (!pattern.test(password)) {
        $(this).css('border-color', 'red');
        // Optionally show a message
        $('#password-error').text('Password must be at least 8 characters with an uppercase letter, number, and special character.');
    } else {
        $(this).css('border-color', 'green');
        $('#password-error').text('');
    }
});
//confirm password
$('input[name="password_confirmation"]').on('input', function () {
    const password = $('input[name="password"]').val();
    const confirmPassword = $(this).val();
    alert(password);

    if (confirmPassword !== password) {
        console.log(password1);
        $(this).css('border-color', 'red');
        $('#confirm-error').text('Passwords do not match.');
    } else {
        $(this).css('border-color', 'green');
        $('#confirm-error').text('');
    }
});
 */


// Add styles for error highlighting
$("<style>")
  .prop("type", "text/css")
  .html(`
    input.error-border {
      border: 1px solid red !important; /* important to override other CSS */
    }
    .error-msg {
      color: red;
      margin-left: 5px;
      display: block;
    }
  `)
  .appendTo("head");

    $(document).on("submit", ".ajaxform", function (e) {
        e.preventDefault();
        let t = $(this).find(".submit-btn"),
            a = t.html();
        $ajaxform.valid() &&
        $.ajax({
            type: "POST",
            url: this.action,
            data: new FormData(this),
            dataType: "json",
            contentType: !1,
            cache: !1,
            processData: !1,
            beforeSend: function () {
                t.html($savingLoader).attr("disabled", !0);
            },
            success: function (e) {
                t.html(a).attr("disabled", false);
                Notify("success", null, e)
            },
            error: function (e) {
                t.html(a).attr("disabled", !1), Notify("error", e);
            },
        });
    });

let $ajaxform_instant_reload = $(".ajaxform_instant_reload");
$ajaxform_instant_reload.initFormValidation(),
    $(document).on("submit", ".ajaxform_instant_reload", function (e) {
        e.preventDefault();
        let t = $(this).find(".submit-btn"),
            a = t.html();
        let $form = $(this);
        let requiredValid = validateRequiredFields($form);

        // Step 2: check if this is a password form
        let passwordValid = true;
        if ($form.hasClass("passwordForm")) {
            passwordValid = validatePasswordForm($form);
        }

        if (!requiredValid || !passwordValid) {
            return false; // stop submit
        }

        $ajaxform_instant_reload.valid() &&
        $.ajax({
            type: "POST",
            url: this.action,
            data: new FormData(this),
            dataType: "json",
            contentType: !1,
            cache: !1,
            processData: !1,
            beforeSend: function () {
                t.html($savingLoader).addClass("disabled").attr("disabled", !0);
            },
            success: function (e) {
                t.html(a).removeClass("disabled").attr("disabled", !1), (window.sessionStorage.hasPreviousMessage = !0), (window.sessionStorage.previousMessage = e.message ?? null), e.redirect && (location.href = e.redirect);
            },
            error: function (e) {
                t.html(a).removeClass("disabled").attr("disabled", !1), showInputErrors(e.responseJSON), Notify("error", e);
            },
        });
    });
// Password rules
    const passwordRules = /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/;

    // ✅ Required field validation
    function validateRequiredFields($form) {
        let isValid = true;

        $form.find("input[required], textarea[required]").each(function () {
            let $field = $(this);
            $field.next(".error-msg").remove();

            if ($field.val().trim() === "") {
                $field.addClass("error-border");
                $field.after('<span class="error-msg">This field is required</span>');
                isValid = false;
            } else {
                $field.removeClass("error-border");
            }
        });

        return isValid;
    }

    // ✅ Password validation (only for .passwordForm)
    function validatePasswordForm($form) {
        const $password = $form.find('input[name="password"]');
        const $confirm = $form.find('input[name="password_confirmation"]');
        const $passwordError = $form.find('.password-error');
        const $confirmError = $form.find('.confirm-error');

        if (!$password.length || !$confirm.length) {
            return true; // no password fields, skip
        }

        let passwordValid = passwordRules.test($password.val().trim());
        $password.css('border-color', passwordValid ? 'green' : 'red');
        $passwordError.text(passwordValid ? '' : 'Password must be at least 8 characters and include an uppercase letter, number, and special character.');

        let confirmValid = ($password.val() === $confirm.val() && $confirm.val().trim() !== "");
        $confirm.css('border-color', confirmValid ? 'green' : 'red');
        $confirmError.text(confirmValid ? '' : 'Passwords do not match.');

        return passwordValid && confirmValid;
    }

    // Validate on input change
// Live validation for all required fields + password fields
$(document).on("input", "input[required], radio[required], select[required], textarea[required], .passwordForm input[name='password'], .passwordForm input[name='password_confirmation']", function () {
    let $form = $(this).closest("form");

    // Run required validation only for this field (lighter than whole form)
    if ($(this).is("[required]")) {
        if ($(this).val().trim() !== "") {
            $(this).removeClass("error-border");
            $(this).next(".error-msg").remove();
        }
    }

    // Run password validation if this is a password form
    if ($form.hasClass("passwordForm")) {
        validatePasswordForm($form);
    }
});



let $ajaxform_reset_form = $(".ajaxform_reset_form");
function notification(e, t) {
    let a;
    (a = "success" == e ? "fa fa-check-circle" : "error" == e ? "fa fa-times-circle" : "fa fa-info-circle"),
        Lobibox.notify(e, {
            pauseDelayOnHover: !0,
            continueDelayOnInactiveTab: !1,
            icon: a,
            sound: !1,
            position: "top right",
            showClass: "zoomIn",
            hideClass: "zoomOut",
            size: "mini",
            rounded: !0,
            width: 250,
            height: "auto",
            delay: 2e3,
            msg: t,
        });
}
function ajaxSuccess(e, t) {
    e.redirect ? (e.message && ((window.sessionStorage.hasPreviousMessage = !0), (window.sessionStorage.previousMessage = e.message ?? null)), (location.href = e.redirect)) : e.message && Notify("success", e);
}
function clean(e) {
    return (e = (e = e.replace(/ /g, "-")).replace(/[^A-Za-z0-9\-]/, "")).toLowerCase();
}
$ajaxform_reset_form.initFormValidation(),
    $(document).on("submit", ".ajaxform_reset_form", function (e) {
        e.preventDefault();
        let t = $(this),
            a = t.find(".submit-button"),
            s = a.html();
        $ajaxform_reset_form.valid() &&
        $.ajax({
            type: "POST",
            url: this.action,
            data: new FormData(this),
            dataType: "json",
            contentType: !1,
            cache: !1,
            processData: !1,
            beforeSend: function () {
                a.html($savingLoader).attr("disabled", !0);
            },
            success: function (e) {
                a.html(s).attr("disabled", !1), t.trigger("reset"), Notify("success", e);
            },
            error: function (e) {
                a.html(s).attr("disabled", !1), showInputErrors(e.responseJSON), Notify("error", e);
            },
        });
    }),
    $(".init_form_validation").initFormValidation(),
    $(document).on("click", ".action-confirm", function (e) {
        e.preventDefault();
        let t = $(this),
            a = t.data("title") ?? "Heads Up!",
            s = t.data("type") ?? "DELETE",
            n = t.data("icon") ?? "warning",
            r = t.data("content") ?? "Are you sure to delete?",
            o = t.attr("href") ?? t.data("action"),
            i = t.html();
        swal({ title: a, text: r, icon: n, buttons: !0, dangerMode: !0 }).then((e) => {
            if (!e) return 0;
            $.ajax({
                url: o,
                data: { _token: CSRF_TOKEN },
                type: s,
                beforeSend: function () {
                    t.html($savingLoader).addClass("disabled").attr("disabled", !0);
                },
                success: function (e) {
                    t.html(i).removeClass("disabled").attr("disabled", !1), ajaxSuccess(e, t);
                },
                error: function (e) {
                    t.html(i).removeClass("disabled").attr("disabled", !1), Notify(e);
                },
            });
        });
    }),
    $(document).on("click", ".order-action", function (e) {
        e.preventDefault();
        let t = $(this),
            a = t.data("id"),
            s = t.data("status"),
            n = t.data("content") ?? "Are you sure?",
            r = t.attr("href") ?? t.data("action"),
            o = t.html();
        swal({ title: "Are you sure?", text: n, icon: "warning", buttons: !0, dangerMode: !0 }).then((e) => {
            if (!e) return 0;
            $.ajax({
                url: r,
                data: { id: a, status: s, _token: CSRF_TOKEN },
                type: "GET",
                beforeSend: function () {
                    t.html($savingLoader).addClass("disabled").attr("disabled", !0);
                },
                success: function (e) {
                    t.html(o).removeClass("disabled").attr("disabled", !1), ajaxSuccess(e, t);
                },
                error: function (e) {
                    t.html(o).removeClass("disabled").attr("disabled", !1), Notify(e);
                },
            });
        });
    });


//PREVIEW IMAGE
function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            var inputId = $(input).attr('id');

            // Select the image element based on the input's ID
            var imageElement = $('img.product-img').filter(function() {
                return $(this).closest('label').attr('for') === inputId;
            });
            imageElement.attr('src', e.target.result);
            imageElement.hide().fadeIn(650);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

// Status button Change
$(".change-text").change(function() {
    var $dynamicText = $(this).closest('.form-control').find('.dynamic-text');

    if (this.checked) {
        $dynamicText.text("Active");
    } else {
        $dynamicText.text("Deactive");
    }
});

// Status button Change
$(".cnge-text").change(function() {
    var $test = $(this).closest('.form-control').find('.is-live-text');

    if (this.checked) {
        $test.text("Yes");
    } else {
        $test.text("No");
    }
});

/** STATUS CHANGE */
$('.status1').on('change', function() {
    let checkbox = $(this);
    let status = checkbox.prop('checked') ? 1 : 0;
    let url = checkbox.data('url');
    let model =  checkbox.data('model');

    $.ajax({
        url: url,
        type: 'POST',
        data: {
            status: status, model: model
        },
        success: function(response) {
            if(status === 1){
                toastr.success(response.message + ' status published');
            }
            else{
                toastr.success(response.message + ' status unpublished');
            }
        },
        error: function(xhr, status, error) {
            console.log(error)
            toastr.error('Something Went Wrong');
        }
    });
});

/** DELETE ACTION */
$(document).on("click", ".delete-confirm", function (e) {
    e.preventDefault();
    let t = $(this),
        o = t.attr("href") ?? t.data("action"),
        i = t.html();

    // Create modal dynamically
    let confirmationModal = `
        <div class="modal fade" id="delete-confirmation-modal" tabindex="-1" aria-labelledby="delete-confirmation-modal-label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="text-end">
                        <button type="button" class="btn-close m-3 mb-0" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-0">
                        <div class="delete-modal">
                            <h5>Are You Sure?</h5>
                            <p>You won't be able to revert this!</p>
                        </div>
                        <div class="button-group">
                            <button class="btn reset-btn" data-bs-dismiss="modal">Cancel</button>
                            <button class="btn theme-btn delete-confirmation-button">Yes, Delete It!</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;

    $('body').append(confirmationModal); // Append modal to the body
    $('#delete-confirmation-modal').modal('show');

    // handle dynamic modal
    $('.delete-confirmation-button').on('click', function () {
        $.ajax({
            url: o,
            data: { _token: CSRF_TOKEN },
            type: "DELETE",
            beforeSend: function () {
                t.html($savingLoader).addClass("disabled").attr("disabled", true);
            },
            success: function (e) {
                t.html(i).removeClass("disabled").attr("disabled", false);
                ajaxSuccess(e, t);
            },
            error: function (e) {
                t.html(i).removeClass("disabled").attr("disabled", false);
                Notify(e);
            },
        });

        // Hide and remove modal
        $('#delete-confirmation-modal').modal('hide');
        $('#delete-confirmation-modal').remove();
    });
});

$(document).ready(function () {
    /** SEARCH */
    $(".searchForm").on("submit", function (e) {
        e.preventDefault();
        const searchText = $(".searchInput").val();
        const url = $(this).attr("action");
        console.log(url);
        $.ajax({
            url: url,
            type: "GET",
            data: {search: searchText},
            success: function (response) {
                $("#searchResults").html(response);
            },
            error: function (xhr) {
                console.log(xhr.responseText);
            },
        });
    });
     //let searchTimeout; // Declare timeout variable for debouncing

    /*  $(".searchInput").on("input", function () {
        clearTimeout(searchTimeout); // Clear previous timeout

        const form = $(this).closest(".searchForm"); // Get the form element
        const url = form.attr("action"); // Get form action URL
        const formData = form.serialize(); // Serialize all input fields
        const searchText = $(".searchInput").val();
        //const url = $(this).attr("action");

        searchTimeout = setTimeout(() => {
            $.ajax({
                url: url,
                type: "GET",
                data: formData, // Send all form input data
                //data: {search: searchText},
                success: function (response) {
                    $("#searchResults").html(response); // Update search results
                    console.log(response);
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                },
            });
        }, 300); // Debounce time (adjust as needed)
    }); */

    /* let searchTimeout; // Declare timeout variable for debouncing

      $(document).on("input change", ".searchInput, .perPageSelect", function () {
        clearTimeout(searchTimeout); // Clear previous timeout

        searchTimeout = setTimeout(() => {
            const form = $(this).closest(".searchForm");  // Get form element
            const url = form.attr("action"); // Get form action URL
            const formData = form.serialize(); // Serialize all input fields

            $.ajax({
                url: url,
                type: "GET",
                data: formData, // Send all form input data
                  beforeSend: function () {
                    $("#searchResults").html("<p>Loading...</p>"); // Show loading state
                },
                success: function (response) {
                    $("#searchResults").html(response); // Update search results
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                },
            });
        }, 300); // Adjust debounce delay as needed
    }); */

    let searchTimeout; // Declare timeout variable for debouncing

function fetchSearchResults() {
    clearTimeout(searchTimeout); // Clear previous timeout

    const form = $(this).closest(".searchForm");  // Get form element
    const url = form.attr("action"); // Get form action URL
    const formData = form.serialize(); // Serialize all input fields
    //console.log(formData);
    searchTimeout = setTimeout(() => {
        $.ajax({
            url: url,
            type: "GET",
            data: formData, // Send all form input data
            success: function (response) {
                $(".searchResults").html(response); // Update search results
            },
            error: function (xhr) {
                console.log(xhr.responseText);
            },
        });
    }, 300); // Debounce time (adjust as needed)
}

// Trigger search on input (for live search)
$(".searchInput").on("input", fetchSearchResults);
// Trigger search on per_page dropdown change
$(".perPageSelect").on("change", fetchSearchResults);
// Trigger search on creator dropdown change
$(".creator").on("change", fetchSearchResults);
$(".assign").on("change", fetchSearchResults);
// Trigger search on cunselor dropdown change
$(".counselor").on("change", fetchSearchResults);
// Trigger search on tags checkbox change
$(".check-tag").on("change", fetchSearchResults);
// Trigger search on tags Status change
$(".searchStatus").on("change", fetchSearchResults);


    // Handle the "x" icon click event
    $(".clearSearchInput").on("click", function () {
        $(".searchInput").val(""); // Clear the search input
        // $(".searchForm").submit(); // Submit the form to show the full list of items
        $(".clearSearchInput").addClass('d-none');
        $(this).closest('.searchForm').submit();
    });

    // Show/hide "delete" button based on input value
    $(".searchInput").on("input", function () {
        if ($(this).val().trim() !== "") {
            $(".clearSearchInput").removeClass('d-none');
        } else {
            $(".clearSearchInput").addClass('d-none');
        }
    });


});

/** CHECKBOX FOR DELETE ALL */
$(document).ready(function () {
    // Select all checkboxes when the checkbox in the header is clicked
    $(".selectAllCheckbox").on("click", function () {
        $(".checkbox-item").prop("checked", this.checked);
    });

    // Perform the delete action for selected elements when the delete icon is clicked
    $(".delete-selected").on("click", function (e) {
        var checkedCheckboxes = $(".checkbox-item:checked");
        if (checkedCheckboxes.length === 0) {
            toastr.error('No items selected. Please select at least one item to delete.');
        } else {
            $('#multi-delete-modal').modal('show');
        }
    });


    $('.multi-delete-btn').on('click', function() {
        var ids = $(".checkbox-item:checked").map(function() {
            return $(this).val();
        }).get();

        let submitButton = $(this);
        let originalButtonText = submitButton.html();
        let del_url = $('.checkbox-item').data('url');

        $.ajax({
            type: "POST",
            url: del_url,
            data: {
                ids
            },
            dataType: "json",
            beforeSend: function () {
                submitButton.html($savingLoader).attr('disabled', true);
            },
            success: function (res) {
                submitButton.html(originalButtonText).attr('disabled', false);
                window.sessionStorage.hasPreviousMessage = true;
                window.sessionStorage.previousMessage = res.message ?? null;
                res.redirect && (location.href = res.redirect);
            },
            error: function (xhr) {
                submitButton.html(originalButtonText).attr('disabled', false);
                Notify('error', xhr);
            }
        });
    });
});



/** system setting start */
    // Initial label text
var initialLabelText = $("#mail-driver-type-select option:selected").val();

$("#mail-driver-type-select").on("change", function () {
    var selectedOptionValue = $(this).val();
    $("#mail-driver-label").text(selectedOptionValue);
});

$("#mail-driver-label").text(initialLabelText);

/** system setting end */
