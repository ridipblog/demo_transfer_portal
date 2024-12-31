import UserAuthModule from './UserAuthModule.js'
const user_auth_module = new UserAuthModule()
$(document).ready(function () {
    // ----------------- request for otp ---------------
    $(document).on('submit', '#forgot-password-form', async function (e) {
        e.preventDefault();
        user_auth_module.forgotPassword('#forgot-password-form', '/forgot-password-api', "#forgot-password-btn", "request_otp");
    });
    // ----------------- verify otp ---------------
    $(document).on('submit', '#verify-otp-form', async function (e) {
        e.preventDefault();
        user_auth_module.forgotPassword('#verify-otp-form', '/verify-set-password', "#verifyCodeBtn", "verify_otp");
    });
    // ----------------- set new password  ---------------
    $(document).on('submit', '#set-password-form', async function (e) {
        e.preventDefault();
        user_auth_module.forgotPassword('#set-password-form', '/verify-set-password', "#set-password-btn", "set_password");
    });
    //   ------ re-send forgot password OTP -------------------
    $(document).on('click', '#resend-forgot-password-otp', async function () {
        var form_data=new FormData();
        form_data.append('resend_for','forgot_password');
        user_auth_module.reSendForgotOTP(form_data,$(this),'/resend-forgot-otp','user-login');
    });

})
