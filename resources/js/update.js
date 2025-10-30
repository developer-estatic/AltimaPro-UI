import Swal from 'sweetalert2';

const Toast= Swal.mixin({
    toast: true,
    position: 'center',
    customClass: {
        popup: 'colored-toast',
    },
    showConfirmButton: false,
    timer: 1500,
    timerProgressBar: true,
})

/* For combining API message object to a string */
window.combineMessage = function (val) {
    let message = "";
    let newLine = "";

    if (Object.keys(val).length === 0 || val.constructor === Object) {
        for (const [key, value] of Object.entries(val)) {
            message = message + newLine + `${value}`;
            newLine = "\n";
        }
    } else {
        message = val;
    }
    return message;
};


$(document).ready(function () {
    // script to change password
    $(document).on('click', '#changePassword', function () {
        try {
            let formData = new FormData();
            let currentPassword = $('#currentPassword').val();
            let newPassword = $('#newPassword').val();
            let newPasswordConfirmation = $('#newPasswordConfirmation').val();
            let actionUrl = $('#changePasswordForm').attr('action');

            formData.append('current_password', currentPassword);
            formData.append('new_password', newPassword);
            formData.append('new_password_confirmation', newPasswordConfirmation);

            processRequest(formData, actionUrl, 'POST');
        } catch (error) {
            // Log err
        }
    });

    // script to update profile
    $(document).on('click', '#updateProfile', function () {
        let formData = new FormData();
        let firstName = $('#firstName').val();
        let lastName = $('#lastName').val();
        let phone = $(".iti__selected-dial-code").text() + ' ' + $('#phone').val();
        let avatar = $('#avatar').prop('files')[0];
        let actionUrl = $('#updateProfileForm').attr('action');

        formData.append('first_name', firstName);
        formData.append('last_name', lastName);
        formData.append('phone', phone);
        if (avatar !== undefined)
            formData.append('avatar', avatar);
        processRequest(formData, actionUrl, 'POST');
    });

    $(document).on('click', '#addUser', function () {

        try {
            let phoneNumber = $('#phone').val();
            phoneNumber = phoneNumber.replace(/\s+/g, '');

            let formData = new FormData();
            let firstName = $('#firstName').val();
            let lastName = $('#lastName').val();
            let email = $('#email').val();

            let phone = $(".iti__selected-dial-code").text() + ' ' + phoneNumber;

            let password = $('#password').val();
            let confirmPassword = $('#confirmPassword').val();
            let roles = $('#roles').val();
            let country_id = $('#country_id').val();
            let business_unit_id = $('#business_unit_id').val();
            let status = $('#status').val();
            let actionUrl = $('#addUserForm').attr('action');

            formData.append('first_name', firstName);
            formData.append('last_name', lastName);
            formData.append('email', email);

            formData.append('phone', phone);

            formData.append('password', password);
            formData.append('confirm_password', confirmPassword);
            formData.append('roles', roles);
            formData.append('country_id', country_id);
            formData.append('business_unit_id', business_unit_id);
            formData.append('status', status);

            processRequest(formData, actionUrl, 'POST');
        } catch (error) {
            // Log err
        }
    });

    $(document).on('click', '#updateUser', function () {

        try {
            let phoneNumber = $('#phone').val();
            phoneNumber = phoneNumber.replace(/\s+/g, '');

            let formData = new FormData();
            let firstName = $('#firstName').val();
            let lastName = $('#lastName').val();
            let email = $('#email').val();

            let phone = $(".iti__selected-dial-code").text() + ' ' + phoneNumber;

            let password = $('#password').val();
            let confirmPassword = $('#confirmPassword').val();
            let roles = $('#roles').val();
            let country_id = $('#country_id').val();
            let business_unit_id = $('#business_unit_id').val();
            let status = $('#status').val();

            let actionUrl = $('#updateUserForm').attr('action');
            formData.append('_method', 'PUT');

            formData.append('first_name', firstName);
            formData.append('last_name', lastName);
            formData.append('email', email);

            formData.append('phone', phone);

            formData.append('password', password);
            formData.append('confirm_password', confirmPassword);
            formData.append('roles', roles);
            formData.append('country_id', country_id);
            formData.append('business_unit_id', business_unit_id);
            formData.append('status', status);

            processRequest(formData, actionUrl, 'POST');

        } catch (error) {
            // Log err
        }
    });

    $(document).on('click', '#updateStatus', function () {

        try {
            let formData = new FormData();
            let userIds = $('#userIds').val();

            let status = ($('#status').val()) ? $('#status').val() : '';
            let actionUrl = $('#updateStatusForm').attr('action');

            formData.append('status', status);
            formData.append('userIds', userIds);
            processRequest(formData, actionUrl, 'POST');
        } catch (error) {
            // Log err
        }
    });

});

// Common function to process post requests
function processRequest(formData, actionUrl, method) {
    try {
        $('#alert').html('');
        $('.invalid-feedback').html('');

        $.ajax({
            url: actionUrl,
            method: method,
            contentType: false,
            cache: false,
            processData: false,
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Laravel CSRF token
            },
            success: function (response) {
                if (response.success) {
                    $(".crm-rightsidebar-header-close-btn").trigger('click');
                    // openToast(response.message);
                    Toast.fire({
                        position: "top-end",
                        icon: "success",
                        text: response.message,
                        timer: 2500
                    });
                } else {
                    let msg = combineMessage(response.message);
                    $('#alert').html('<div class="alert alert-danger">' + msg + '</div>');
                }
                $('.btn-edit-user').remove();
                $('#users-table').DataTable().ajax.reload();
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    $('#alert').html('<div class="alert alert-danger">' + "Oops! There were some errors with your input. Please check below" + '</div>');
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function (key, value) {
                        $('input[name=' + key + ']').after('<div class="invalid-feedback d-block">' + value[0] + '</div>');
                    });
                }
            }
        });

    } catch (error) {
        // Log err
    }
}
