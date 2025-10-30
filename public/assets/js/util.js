function openToast(msg) {

    $('#toast').children().find("#msg").text(msg);
    $('#toast').show();
    $('#toast').removeClass('d-none');
    
   setTimeout(() => {
        $('#toast').hide();
    }, 5000);
}