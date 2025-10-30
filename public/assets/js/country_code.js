var iti = null;

$(document).ready(function () {
    
    if (iti) {
        // Destroy the previous instance if it exists
        iti.destroy(); 
    }
    iti = intlTelInput(document.querySelector("#phone"), {
        // strictMode: false,
        utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@24.5.0/build/js/utils.js",
        initialCountry: 'IN', // Pre-selected country
        // showFlags: false,
        separateDialCode: true, // Show country code in field
    });


    /* Update the phone input field when the country dropdown changes. */
    $('#country_id').on('change', function () {
        var selectedOption = $(this).find(':selected');

        // Get the country code from the data-code attribute
        var countryCode = selectedOption.data('code');

        if (iti && countryCode) {
            iti.setCountry(countryCode.toLowerCase());
        }
    });
});