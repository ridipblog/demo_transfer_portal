import UserAuthModule from './UserAuthModule.js'
const user_auth_module = new UserAuthModule()
import ReuseModule from '../reuse_modules/ReuseModule.js';
const reuse_module = new ReuseModule();
// --------------- post registration form data -------------------
// $(document).on('submit', '#register-form', async function (e) {
//     e.preventDefault();
//     console.log("Ok")
//     user_auth_module.userRegistration('#register-form', 'preview');
// });
$(document).ready(function () {
    // ---------------- post registration data -------------------
    $(document).on('submit', '#register-form', function (e) {
        e.preventDefault();
        user_auth_module.userRegistration('#register-form', 'submit');
    });

    // ---------------------- post registration OTP verify form data ----------------
    $(document).on('submit', '#registration-otp', async function (e) {
        e.preventDefault();
        user_auth_module.registrationOTPVerify('#registration-otp');
    });
    // ------------- re send registration OTP -----------------
    $(document).on('click','#resend-registration-otp',async function(){
        var form_data=new FormData();
        form_data.append('resend_for','registration_otp');
        user_auth_module.reSendForgotOTP(form_data,$(this),'/resend-forgot-otp','register');
    })
    // ------------- preview image on model ------------------
    reuse_module.previewImage('.registration_documents');

    // Id card Type
    $('input[name=before_mutual_transfer]').on('click', function () {
        var isChecked = $(this).val();
        if (isChecked == "no") {
            $('#avlTfrVal').addClass('hidden');
        } else if (isChecked == "yes") {
            $('#avlTfrVal').removeClass('hidden');
        } else {
            $('#avlTfrVal').addClass('hidden');
        }
    });

    // $('input[name=before_mutual_transfer]').on('click', function () {
    //     var isChecked = $(this).val();
    //     if (isChecked == "no") {
    //         $('#avlTfrVal').prop('disabled', true);
    //     } else if (isChecked == "yes") {
    //         $('#avlTfrVal').prop('disabled', false);
    //     } else {
    //         $('#avlTfrVal').prop('disabled', true);
    //     }
    // });



    $('input[name=pending_govt_dues]').on('click', function () {
        var isChecked = $(this).val();
        if (isChecked == "yes") {
            $('#noDueCertDoc').addClass('hidden');
        } else if (isChecked == "no") {
            $('#noDueCertDoc').removeClass('hidden');
        } else {
            $('#noDueCertDoc').addClass('hidden');
        }
    });

    $('.declaration-checkbox').on('change', function() {
        if ($('.declaration-checkbox').length === $('.declaration-checkbox:checked').length) {
            $('#register').prop('disabled', false);
        } else {
            $('#register').prop('disabled', true);
        }
    });

});
