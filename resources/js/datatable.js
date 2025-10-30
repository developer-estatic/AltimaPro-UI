$(document).ready(function () {

    $(document).on('click', '#select-all-users', function () {
        if ($(this).prop('checked') == true) {
            $('.dt-user').prop('checked', true);
        } else {
            $('.dt-user').prop('checked', false);
        }
        callCheckboxSelect();
    });

    $(document).on('click', '.dt-user', function () {
        callCheckboxSelect();
    });

});

function callCheckboxSelect() {

    $('.checkbox-selected').remove();
    if($('.dt-user').filter(':checked').length) {

        let userIds = [];
        $('.dt-user').filter(':checked').each(function() {
            userIds.push(parseInt($(this).val()));
        });

        let html = '<div class="checkbox-selected d-inline ml-3">';
            html+= '<label>Selected '+$('.dt-user').filter(':checked').length+'</label>';
            html+= '<i class="fa-solid fa-arrow-right fa-2xs ml-2"></i>';
            html+= '<a href="javascript:void(0);" class="change-status crm-show-right-side-bar" data-type="change-status" data-id="['+userIds+']" title="Change Status"><i class="fa-solid fa-right-left fa-2xs"></i><a>'
            html+= '</div>'

        $('#users-table_length').append(html);
    }
}
