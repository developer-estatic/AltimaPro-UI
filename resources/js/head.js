$(document).ready(function() {

    $('#crm-logged-user-menu').on('click', function(){
        $('.dropdown-menu').toggleClass('d-block');
    });

    $('.crm-main-wrapper .crm-main-container .crm-header .crm-header-left .crm-header-hamburger').on('click', function(){
        $('.crm-main-wrapper .crm-main-container .crm-nav-wrapper').toggleClass('crm-open-nav-menu')
    });

    $('.crm-main-wrapper .crm-main-container .crm-nav-wrapper .crm-nav-container .crm-nav-left ul>li').on('click', function(){
        $(this).toggleClass('crm-menu-open')
    });

    $(document).on('click', '.crm-show-right-side-bar', function() {

        $('.dropdown-menu').removeClass('d-block');
        $('.crm-rightsidebar-wrapper').removeClass('crm-show-rightsidebar');
        $('.crm-rightsidebar-container').empty();

        $.ajax({
            url: 'get-template',
            data: {
                type: $(this).attr('data-type'),
                typeId: $(this).attr('data-id')
            },
            success: (response) => {
                $('.crm-rightsidebar-container').html(response);
            },
            error: function(response){
                // console.log('Err');
            }
        });

        $('.crm-rightsidebar-wrapper').addClass('crm-show-rightsidebar');
    });

    $(document).on('click', '.crm-rightsidebar-header-close-btn', function() {
        $('.crm-rightsidebar-wrapper').removeClass('crm-show-rightsidebar');
    });
});
