import RequestModule from '../reuse_modules/RequestModule.js'
import ReuseModule from '../reuse_modules/ReuseModule.js'
const reuse_module = new ReuseModule()
class EmployeeProfileModule extends RequestModule {
    constructor() {
        super()
    }
    // -------------- save or final submit employee profile details ----------------
    async saveOrSubmitProfile(form, url, btn, api_type = 'save_submit') {
        var before_submit_text = $(btn).text();
        reuse_module.processingStatus(btn);
        var form_data = new FormData($(form)[0]);
        $('.registration-error').text('');
        this.formPostReponse = async (response) => {
            console.log(response);
            if (response.res_data.status == 200) {
                if (api_type == "preview") {
                    this.previewRegData();
                    if ($('#prevModal').hasClass('hidden')) {
                        $('#prevModal').removeClass('hidden');
                        $('body').css('overflow', 'hidden');
                    }
                } else {
                    Swal.fire({
                        title: 'Success',
                        text: response.res_data.message,
                        icon: 'info', // Use 'success', 'error', 'warning', or 'info' based on the message type
                    }).then(() => {
                        if (api_type == "all_submit" || api_type == "update_profile") {
                            window.location.href = "/employees/dashboard";
                        }
                    });
                }
            } else if (response.res_data.status == 400) {
                reuse_module.showErrorMessage('.registration-input', '.registration-error', response.res_data.message, 'back_end');
                reuse_module.focusErrorMessage('.registration-input', '.registration-error');
            } else {
                Swal.fire(response.res_data.message);
            }
        }
        await this.formPost(form_data, url);
        reuse_module.processingStatus(btn, "end", before_submit_text);
    }
    //   ------------ update employee profile --------------------
    updateEmployeeProfile = async (form) => {
        reuse_module.processingStatus('#prevModalBtn');
        var form_data = new FormData($(form)[0]);
        this.formPostReponse = async (response) => {
            if (response.res_data.status == 200) {
                Swal.fire(response.res_data.message);
            } else if (response.res_data.status == 400) {
                reuse_module.showErrorMessage('.registration-input', '.registration-error', response.res_data.message, 'back_end');
                reuse_module.focusErrorMessage('.registration-input', '.registration-error');
            } else {
                Swal.fire(response.res_data.message);
            }
        }
        await this.formPost(form_data, '/employees/update-employee-profile-api');
        reuse_module.processingStatus('#prevModalBtn', "end", "Update profile");
    }
    // ------------------ request profile transfer --------------
    requestProfileTransfer = async (form) => {
        reuse_module.processingStatus('#request-profile-form-btn');
        var form_data = new FormData($(form)[0]);
        form_data.append('target_employee', $('#request-profile-form-btn').val());
        this.formPostReponse = async (response) => {
            if (response.res_data.status == 200) {
                Swal.fire(
                    'info',
                    response.res_data.message,
                    'info'
                ).then(() => {
                    window.location.href = "/employees/dashboard";
                })
            } else if (response.res_data.status == 401) {
                $('.transfer-request-error').html(response.res_data.message);
            }
        }
        await this.formPost(form_data, '/employees/request-transfer-profile');
        reuse_module.processingStatus('#request-profile-form-btn', "end", "Request");
    }
    previewRegData = async () => {
        $('.preview_data').eq(0).html($('.preview-input').eq(0).val());
        $('.preview_data').eq(1).html($('.preview-input').eq(1).val());
        $('.preview_data').eq(2).html($('.preview-input').eq(2).val());
        $('.preview_data').eq(3).html($('.preview-input').eq(3).val());
        $('.preview_data').eq(4).html($('.preview-input').eq(4).val());
        $('.preview_data').eq(5).html($('#caste_type option:selected').text());
        $('.preview_data').eq(6).html($('.preview-input').eq(6).val());
        $('.preview_data').eq(7).html($('.preview-input').eq(7).val());
        $('.preview_data').eq(8).html($('.preview-input').eq(8).val());
        $('.preview_data').eq(9).html($('.preview-input').eq(9).val());
        $('.preview_data').eq(10).html($('#select_district option:selected').text());
        $('.preview_data').eq(11).html($('#select_depert option:selected').text());
        $('.preview_data').eq(12).html($('#review_doo_code').val());
        $('.preview_data').eq(13).html($('#select_office option:selected').text());
        $('.preview_data').eq(14).html($('#select_degis option:selected').text());
        $('.preview_data').eq(15).html($('#date_of_join_id').val());
        $('.preview_data').eq(16).html($('#date_of_join_current_id').val());
        $('.preview_data').eq(17).html($('#review_pay_grade option:selected').text());
        $('.preview_data').eq(18).html($('#review_pay_band').val());

        $('.preview_data').eq(19).html($('#preference_district_1 option:selected').text());
        $('.preview_data').eq(20).html($('#preference_district_2 option:selected').text());
        $('.preview_data').eq(21).html($('#preference_district_3 option:selected').text());
        $('.preview_data').eq(22).html($('#preference_district_4 option:selected').text());
        $('.preview_data').eq(23).html($('#preference_district_5 option:selected').text());

        $('.preview_data').eq(24).html($('input[name="case_pendding"]:checked').val());
        $('.preview_data').eq(25).html($('input[name="departmental_proceedings"]:checked').val());
        $('.preview_data').eq(26).html($('input[name="before_mutual_transfer"]:checked').val());
        $('.preview_data').eq(27).html($('#mutual_transfer_number option:selected').val());
        $('.preview_data').eq(28).html($('input[name="pending_govt_dues"]:checked').val());
    }
}

export default EmployeeProfileModule;
