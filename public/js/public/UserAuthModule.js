import RequestModule from "../reuse_modules/RequestModule.js";
import ReuseModule from "../reuse_modules/ReuseModule.js";

const reuse_module = new ReuseModule();
class UserAuthModule extends RequestModule {
    constructor() {
        console.log("User auth module");
        super();
    }
    // -------------- user registration ----------------
    userRegistration = async (form, preview) => {
        reuse_module.processingStatus('#register');
        var form_data = new FormData($(form)[0]);
        form_data.append('preview', preview);

        this.formPostReponse = async (response) => {
            console.log(response.res_data);
            if (response.res_data.status == 200) {
                if (preview == "preview") {
                    this.previewRegData();
                    if ($('#prevModal').hasClass('hidden')) {
                        $('#prevModal').removeClass('hidden');
                        $('body').css('overflow', 'hidden');
                    }
                } else {
                    var locale = window.App?.locale;
                    window.location.href = `/${locale}/registration-OTP`;
                }
            } else if (response.res_data.status == 402) {
                $('.registration-error').eq(4).html(response.res_data.message);
            } else if (response.res_data.status == 400) {
                reuse_module.showErrorMessage('.registration-input', '.registration-error', response.res_data.message, 'back_end');
                reuse_module.focusErrorMessage('.registration-input', '.registration-error');
            } else {
                Swal.fire(response.res_data.message);
            }
        }
        await this.formPost(form_data, '/user-registration');
        reuse_module.processingStatus('#register', "end", "Submit");
    }
    // --------------- registration otp verify ---------------------
    registrationOTPVerify = async (form) => {
        reuse_module.processingStatus('.registration-OTP-btn');
        var form_data = new FormData($(form)[0]);
        this.formPostReponse = async (response) => {
            console.log(response)
            if (response.res_data.status == 200) {
                Swal.fire({
                    'title': 'Registration Successful!',
                    'text': `${response.res_data.message} ${response.res_data.ref_id}`,
                    'icon': 'success'
                }).then(() => {
                    var locale = window.App?.locale;
                    window.location.href = `/${locale}/user-login`;
                })
            } else if (response.res_data.status == 400) {
                Swal.fire("Somthing is issue here , please register again !");
                // reuse_module.showErrorMessage('.registration-input', '.registration-error', response.res_data.message, 'back_end');
            } else {
                $('.registration-OTP-error').html(response.res_data.message);
            }
        }
        await this.formPost(form_data, '/registration-otp-api');
        reuse_module.processingStatus('.registration-OTP-btn', 'end', 'Verify & Proceed');
    }
    // ------------ post login data ---------------
    userLogin = async (form) => {
        reuse_module.processingStatus('.user-login-btn');
        var form_data = new FormData($(form)[0]);
        $('.user-login-error').html('')
        this.formPostReponse = async (response) => {

            if (response.res_data.status == 200) {
                var locale = window.App?.locale;
                var origin = window.location.origin
                window.location.href = `/${locale}/employees/dashboard`;
                console.log(response.res_data.message);

            } else if (response.res_data.status == 400) {
                reuse_module.showErrorMessage('.user-login-input', '.user-login-error', response.res_data.message, 'back_end');
                reuse_module.focusErrorMessage('.user-login-input', '.user-login-error');
            } else {
                $('.user-login-error').eq(1).html(response.res_data.message);
            }
        }
        await this.formPost(form_data, '/user-login-api');
        reuse_module.processingStatus('.user-login-btn', 'end', 'Login');
    };

    // ------------ post for got password form ---------------
    forgotPassword = async (form, url, btn, api_type) => {
        var btn_text = $(btn).text();
        reuse_module.processingStatus(btn);
        var form_data = new FormData($(form)[0]);
        if (api_type != "request_otp") {
            form_data.append('api_type', api_type);
        }
        if (api_type == "set_password") {
            form_data.append("otp", $('#idNum').val());
        }
        // $('.user-login-error').html('')
        this.formPostReponse = async (response) => {
            console.log(response)
            if (response.res_data.status == 200) {
                if (api_type == "request_otp") {
                    var locale = window.App?.locale;
                    window.location.href = `/${locale}/set-new-password`;
                } else if (api_type == "verify_otp") {
                    $('.set-password-div').addClass('hidden');
                    $('.set-password-div').eq(1).removeClass('hidden');
                } else if (api_type == "set_password") {
                    Swal.fire(
                        'info',
                        'Password has been changed !',
                        'info'
                    ).then(() => {
                        var locale = window.App?.locale;
                        window.location.href = `/${locale}/user-login`;
                    });
                }
            } else if (response.res_data.status == 400) {
                reuse_module.showErrorMessage(api_type == "verify_otp" ? '.change-password-input' : '.user-login-input', api_type == "verify_otp" ? '.change-password-error' : '.user-login-error', response.res_data.message, 'back_end');
                reuse_module.focusErrorMessage(api_type == "verify_otp" ? '.change-password-input' : '.user-login-input');
            } else {
                $(api_type == "verify_otp" ? '.change-password-error' : '.user-login-error').eq($(api_type == "verify_otp" ? '.change-password-error' : '.user-login-error').length - 1).html(response.res_data.message);
            }
        }
        await this.formPost(form_data, url);
        reuse_module.processingStatus(btn, 'end', btn_text);
    };
    // ------------------- resend-forgotpassword-otp -------------------
    reSendForgotOTP = async (form_data, btn, url, redirect_url) => {
        var btn_text = $(btn).text();
        reuse_module.processingStatus(btn);
        this.formPostReponse = (response) => {
            if (response.res_data.status == 200 || response.res_data.status == 401 || response.res_data.status == 402) {
                Swal.fire(
                    'info',
                    response.res_data.message,
                    'info'
                ).then(() => {
                    if (response.res_data.status == 402) {
                        var locale = window.App?.locale;
                        window.location.href = `/${locale}/${redirect_url}`;
                    }
                });
            } else if (response.res_data.status == 400) {
                var message = '';
                response.res_data.message.forEach(element => {
                    message += element;
                });
                Swal.fire(
                    'info',
                    message,
                    'info'
                ).then(() => {
                    var locale = window.App?.locale;
                    window.location.href = `/${locale}/${redirect_url}`;
                });
            }
        }
        this.formPost(form_data, url);
        reuse_module.processingStatus(btn, 'end', btn_text);
    }



    // ------------ post login data (_verification login) ---------------
    verificationLogin = async (form) => {
        reuse_module.processingStatus('.verification-login-btn');
        var form_data = new FormData($(form)[0]);
        $('.verification-login-error').html('')
        this.formPostReponse = async (response) => {
            console.log(response)
            // alert('ee')
            if (response.res_data.status == 200) {
                if (response.res_data.first_login == 1) {
                    if(response.res_data.department_dash == 1){
                        var locale = window.App?.locale;
                        // alert('here');
                        window.location.href = `/${locale}/department/department-dashboard`;
                    }else{
                        if (response.res_data.role == 'Approver') {
                            var locale = window.App?.locale;

                                var locale = window.App?.locale;
                                // window.location.href = `/${locale}/verifier/verifier-dashboard`;
                                window.location.href = `/${locale}/department/department-dashboard`;
                        } else {                    
                                var locale = window.App?.locale;                       
                                window.location.href = `/${locale}/verifier/verifier-dashboard`;
                      
                        }
                    }
                
                } else {
                    var locale = window.App?.locale;
                    window.location.href = `/${locale}/verification-otp`;

                }

            } else if (response.res_data.status == 400) {
                reuse_module.showErrorMessage('.verification-login-input', '.verification-login-error', response.res_data.message, 'back_end');
            } else {
                $('.verification-login-error').eq(1).html(response.res_data.message);
            }
        }
        await this.formPost(form_data, '/verification-login-api');
        reuse_module.processingStatus('.verification-login-btn', 'end', 'Login');
    };



     // ------------ post login data (_department login) ---------------
     verificationDepartmentLogin = async (form) => {
        reuse_module.processingStatus('.verification-login-btn');
        var form_data = new FormData($(form)[0]);
        $('.verification-login-error').html('')
        this.formPostReponse = async (response) => {
            // alert('here')
            if (response.res_data.status == 200) {
                if (response.res_data.first_login == 1) {
                    var locale = window.App?.locale;
                    window.location.href = `/${locale}/department/department-dashboard`;
                } else {
                    var locale = window.App?.locale;
                    window.location.href = `/${locale}/verification-department-pin`;
                }
            } else if (response.res_data.status == 400) {
                reuse_module.showErrorMessage('.verification-department-login-input', '.verification-login-error', response.res_data.message, 'back_end');
            } else {
                $('.verification-department-login-error').html(response.res_data.message);
            }
        }
        await this.formPost(form_data, '/verification-department-login-api');
        reuse_module.processingStatus('.verification-department-login-btn', 'end', 'Login');
    };



    previewRegData = async () => {
        $('.preview_data').eq(0).html($('.preview-input').eq(0).val());
        $('.preview_data').eq(1).html($('.preview-input').eq(1).val());
        $('.preview_data').eq(2).html($('.preview-input').eq(2).val());
        $('.preview_data').eq(3).html($('.preview-input').eq(3).val());
        $('.preview_data').eq(4).html($('.preview-input').eq(4).val());
        $('.preview_data').eq(5).html($('.preview-input').eq(5).val());
        $('.preview_data').eq(6).html($('#caste_type option:selected').text());
        $('.preview_data').eq(7).html($('.preview-input').eq(7).val());
        $('.preview_data').eq(8).html($('.preview-input').eq(8).val());
        $('.preview_data').eq(10).html($('.preview-input').eq(10).val());
        $('.preview_data').eq(11).html($('#disability_type option:selected').text());
        $('.preview_data').eq(12).html($('#select_district option:selected').text());
        $('.preview_data').eq(13).html($('#select_depert option:selected').text());
        $('.preview_data').eq(14).html($('#review_doo_code').val());
        $('.preview_data').eq(15).html($('#select_office option:selected').text());
        $('.preview_data').eq(16).html($('#select_degis option:selected').text());
        $('.preview_data').eq(17).html($('#date_of_join_id').val());
        $('.preview_data').eq(18).html($('#date_of_join_current_id').val());
        $('.preview_data').eq(19).html($('#review_pay_grade option:selected').text());
        $('.preview_data').eq(20).html($('#review_pay_band').val());
        $('.preview_data').eq(21).html($('input[name="ex_serviceman"]:checked').val());

        $('.preview_data').eq(22).html($('#preference_district_1 option:selected').text());
        $('.preview_data').eq(23).html($('#preference_district_2 option:selected').text());
        $('.preview_data').eq(24).html($('#preference_district_3 option:selected').text());

    }
}
export default UserAuthModule;


