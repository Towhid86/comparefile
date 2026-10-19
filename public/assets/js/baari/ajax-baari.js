
/** confirm modal start */
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).on('click', '.confirm-action', function (event) {
    event.preventDefault();
    let url = $(this).data('action') ?? $(this).attr('href');
    let method = $(this).data('method') ?? 'POST';
    let icon = $(this).data('icon') ?? 'fas fa-warning';
    let urlData = $(this).data('url')??'';
    let section = $(this).data('section')??'';
    let formData = '';


    $.confirm({
        title: "Are you sure?",
        icon: icon,
        theme: 'modern',
        closeIcon: true,
        animation: 'scale',
        type: 'red',
        scrollToPreviousElement: false,
        scrollToPreviousElementAnimate: false,
        buttons: {
            confirm: {
                btnClass: 'btn-red',
                action: function () {
                    event.preventDefault();
                    $.ajax({
                        type: method,
                        url: url,
                        success: function (response) {
                            if (response.redirect) {
                                window.sessionStorage.hasPreviousMessage = true;
                                window.sessionStorage.previousMessage = response.message ?? null;
                                //location.href = response.redirect;
                                if(urlData && section){
                                    // Refresh only the relevant data (no page reload)
                                    loadTableData(formData, urlData, section);
                                }else {
                                    location.href = response.redirect;
                                }
                            } else {
                                Notify('success', response)

                                if(urlData && section){
                                    // Refresh only the relevant data (no page reload)
                                    loadTableData(formData, urlData, section);
                                }
                            }
                        },
                        error: function (xhr, status, error) {
                            Notify('error', xhr)
                        }
                    })
                }
            },
            close: {
                action: function () {
                    this.buttons.close.hide()
                }
            }
        },
    });
});
/**confirm modal end */

/**form modal data load statrt */
let $modal_form = $(".modal_form");
$modal_form.initFormValidation(),
   // $(document).ready(function () {
    // Universal form submission handling
    $($modal_form).on('submit', function (e) {
        e.preventDefault(); // Prevent default form submission

        let t = $(this).find(".submit-btn"),
            a = t.html();
        let formData = $(this).serialize();
        let urlData = $(this).data('url');
        let section = $(this).data('section');

        if ($modal_form.valid()) {
            $.ajax({
                url: this.action, // Ensure correct form action
                method: "POST",
                data: formData,
                success: function (response) {
                    // Clear the form fields
                    //$modal_form[0].reset();
                    $modal_form.trigger("reset");
                    // Close any open modal or offcanvas
                    $('.modal').modal('hide');
                    //$('.offcanvas').offcanvas('hide');

                    // Show a success message
                    Notify("success", null, response.message);

                    // Refresh only the relevant data (no page reload)
                    loadTableData(formData, urlData, section);

                    // Reset button state
                    t.html(a).removeClass("disabled").attr("disabled", false);

                    // Store session messages if needed
                    window.sessionStorage.hasPreviousMessage = true;
                    window.sessionStorage.previousMessage = response.message ?? null;
                },
                error: function (xhr) {
                    alert('An error occurred. Please try again.');
                }
            });
        }
    });


    function loadTableData(formData=null,urlData,section) {
        //let route = $(this).data('url');
        //console.log(formData);
        // Fetch updated table data via AJAX
        $.ajax({
            url: urlData, // Replace with the route to fetch table data
            method: "GET",
            data: formData,

            success: function (response) {
                // Replace the table body with the updated content
                $(`#${section}Data`).html(response);
                //$('.searchResults').html(response);
               // allert('Data get successfully!');
            },
            error: function (xhr) {
                // Handle error
                console.error('Error loading table data:', xhr);
            }
        });
    }
//});

/**form modal data load end */


/** filter all from start */
$('.filter-form').on('change', function (e) {
    var table = $(this).attr('table');
    $.ajax({
        type: "POST",
        url: $(this).attr('action'),
        data: new FormData(this),
        dataType: "json",
        contentType: false,
        cache: false,
        processData: false,
        success: function (res) {
            $(table).html(res.data);
        }
    });
});

/** filter all from  end */

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
                    <div class="modal-body">
                        <div class="delete-modal text-center mb-lg-4">
                            <h5>Are You Sure?</h5>
                            <p>You won't be able to revert this!</p>
                        </div>
                         <div class="d-flex justify-content-center">
                            <div class="button-group">
                                <button class="btn reset-btn border rounded" data-bs-dismiss="modal">Cancel</button>
                                <button class="btn theme-btn border rounded delete-confirmation-button">Yes, Delete It!</button>
                            </div>
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
                t.html($savingLoader).attr('disabled', true);
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

// Listen for input changes and update feature values accordingly
$('#words_limit').on('input', function () {
    $('#word_feature').val($('#words_limit').val() + ' Word Limit');
});

$('#images_limit').on('input', function () {
    $('#image_feature').val($('#images_limit').val() + ' images Limit');
});


/** =====================**
 * blog published
 * blog unpublished
 **=======================*/
$('.status-item').each(function () {
    let container = $(this);
    let service = container.data('id');
    //let status_switch = '#status_switch_'+service ;
    $(container).on('change',function () {
        let id = $(container).data('id');
        let statusModel = $(container).data('status-model');
        let url = $(container).data('url') ?? '';

        /* if ($('#status_'+service).is(":checked"))
        {
            let status = 1
        }else {
            let status = 0
        } */
        let status = $(container).is(":checked") ? 1 : 0 ;
        //call ajax function
       ajaxFunction(id,statusModel,status,url);
    });
});

function ajaxFunction(id,statusModel,status,url){
    $.ajax({
        url: url??'/author/publish/status',
        method:"get",
        dataType:"json",
        data:{
            'status':status,'id':id,'statusModel':statusModel,
        },
        success: function(data){
            //alert(data.status);
            /*if(data.status==1){
                toastr.success(statusModel+' Active !');
            }else{
                toastr.error(statusModel+' Inactive !');
            }*/
            if(data.status==1){
                toastr.success(statusModel+' Active !');
            }else{
                toastr.error(statusModel+' Inactive !');
            }
        },
        error: function (data) {
            console.log(data)
            //alert('Error occur fetch sub_category action.....!!');
            toastr.error('Something Went Wrong');
        }
    });
}

/** STATUS CHANGE */
//$('.status').on('change', function() {
$(document).on('change', '.status', function() {
    let checkbox = $(this);
    let status = checkbox.prop('checked') ? 1 : 0;
    let statusModel =  checkbox.data('status-model');
    let id =  checkbox.data('id');
    let url =  checkbox.data('url') ?? '';

    ajaxFunction(id,statusModel,status,url);

});

// Status button Change
$('.status .dropdown-item').on('click', function (e) {
    e.preventDefault(); // Prevent the default link behavior
    let status = $(this).data('status');
    let bgColor = $(this).data('bg-color');
    let statusText = $(this).text();
    let statusModel = $(this).closest('.status').data('status-model');
    let id = $(this).closest('.status').data('id');
    // Call your function with the selected status text
    ajaxDropdownFunction(id, statusModel, status, statusText, bgColor);

});

function ajaxDropdownFunction(id,statusModel,status,statusText,bgColor=null){
    $.ajax({
        url:'/author/website/status',
        method:"get",
        dataType:"json",
        data:{
            'id':id,'status':status,'statusModel':statusModel,'statusText':statusText,'bgColor':bgColor,
        },
        success: function(data){
            //alert(data.status);
            /*if(data.status==1){
                toastr.success(statusModel+' Active !');
            }else{
                toastr.error(statusModel+' Inactive !');
            }*/
            if(data.status){
                toastr.success(statusText +  ' Success!');

                // Select the specific status badge by ID
                let statusBadge = $('#statusBadge-' + id);

                // Remove existing background classes
                statusBadge.removeClass('bg-danger bg-primary bg-warning bg-success');

                // Add the appropriate background class based on the selected status
                if (status) {
                    statusBadge.addClass(bgColor);
                    $('#statusDropdown-' + id).text(statusText);
                }else{
                    statusBadge.addClass('bg-danger'); // Default to 'bg-danger' for unhandled cases
                        $('#statusDropdown-' + id).text('Pending');
                }

            }else{
                toastr.error(statusModel+' '+status+' Failed !');
            }
        },
        error: function (data) {

            console.log(data)
            //alert('Error occur fetch sub_category action.....!!');
            toastr.error('Something Went Wrong');
        }
    });
}


