import RequestModule from "../reuse_modules/RequestModule.js";
import ReuseModule from "../reuse_modules/ReuseModule.js";
const reuse_module = new ReuseModule();
class AuthoritiesModule extends RequestModule {
    total_assign_form;
    constructor() {
        console.log("Authorotites");
        super();
        this.total_assign_form = 0;
    }
    // ---------------- disabled options --------------
    disabledRoleOption = async (current, disabled_class) => {

        $(`${disabled_class} option`).attr('disabled', false);
        if (current.val() !== "") {
            $(`${disabled_class} option[value=${current.val()}]`).attr('disabled', true);
        }
    }
    // -------------- get offices by district -----------------
    getOfficeByDistrict = async (current_index, current, add_class) => {

        var district_id = current.val();
        var depertment_id = $('#inputDepartment').val();

        if (district_id != "All") {
            if (depertment_id !== "") {
                this.formPostReponse = async (response) => {
                    if (response.res_data.status == 200) {
                        // var offices = "<option value=''>All</option>";
                        var offices = "";
                        response.res_data.offices.forEach(office => {
                            offices += `<option value=${office.office_id}>${office.office_fin_assam?.name}</option>`
                        });
                        $(add_class).eq(current_index).html(offices);
                        // $(`#officeSelect_${current_index}`).select2();
                        $(add_class).eq(current_index).val(null).trigger('change');
                    } else {
                        Swal.fire(
                            response.res_data.message
                        );
                    }
                }
                var data = await this.formGet({
                    district_id: district_id,
                    depertment_id: depertment_id
                }, '/get-offices-by-dist');
            } else {
                Swal.fire(
                    'Please select depertment'
                );
            }
        }
    }
    // ----------------- get district names by offices ------------------
    getDistrictByOfficess = async (current_index, current) => {
        var depertment_id = $('#inputDepartment').val();
        var offices = current.val();
        console.log(offices);
        $('.display-district').eq(current_index).html('');
        if (offices.length != 0) {
            if (depertment_id !== "") {
                this.formPostReponse = async (response) => {
                    $('.display-district').eq(current_index).html(response);
                }
                var data = await this.formGet({
                    offices: offices,
                    depertment_id: depertment_id
                }, '/get-districts-by-offices', true);
            } else {
                Swal.fire(
                    'Please select depertment'
                );
            }
        }
    }
    // -------------- add new assign form ----------------
    addAssignForm = async () => {
        this.total_assign_form++;
        console.log(this.total_assign_form)
        var count_assign_form = $('.office-district-row').length;
        reuse_module.processingStatus('.add-assign-form');
        this.formPostReponse = (response) => {
            $('#officeDistrictContainer').append(response);
            $(`#districtSelect_${this.total_assign_form}`).select2();
            $(`#officeSelect_${this.total_assign_form}`).select2();
            this.disabledRoleOption($('#common_role'), '.assign_role');
        }
        await this.formGet({
            total_assign_form: this.total_assign_form,
            count_assign_form: count_assign_form
        }, '/add-assign-form', true);
        reuse_module.processingStatus('.add-assign-form', "end", '+ Office');
    }
    authorityRegistration = async (form) => {
        reuse_module.processingStatus('.submit-registration', 'Register');
        var form_data = new FormData($(form)[0]);
        var count_assign_form = $('.office-district-row').length;
        form_data.append('count_assign_form', count_assign_form);

        this.formPostReponse = (response) => {
            console.log(response);
            if (response.res_data.status == 400) {
                reuse_module.showErrorMessage('.registration-input', '.registration-error', response.res_data.message, 'back_end');
                reuse_module.focusErrorMessage('.registration-input', '.registration-error');
            } else {
                Swal.fire({
                    title: response.res_data.status == 401 ? 'Information' : 'Success',
                    text: response.res_data.message,
                    icon: response.res_data.status == 401 ? 'info' : 'success' // Use 'success', 'error', 'warning', or 'info' based on the message type
                }).then(() => {
                    response.res_data.status == 401 ? '' : window.location.reload();
                })
            }
        }
        await this.formPost(form_data, '/authority-registration-api');
        reuse_module.processingStatus('.submit-registration', "end", 'Register');
    }
    // ----------------- view assign data ----------------
    viewAssignData = async (user_id) => {
        $('#assign-data-div').html('')
        this.formPostReponse = async (response) => {
            $('#assign-data-div').html(response);
        }
        await this.formGet({
            user_id: user_id
        }, '/view-assign-data', true);
    }
    // --------------- disabled assign form options ---------------
    disabledAssignOption = async (current_index,type) => {
        // $('.office-district-row').eq(current_index).find(`.form_district option`).attr('disabled', false);
        // $('.office-district-row').eq(current_index).find(`.assign_role option`).attr('disabled', false);
        for (var i = 0; i < $('.office-district-row').length; i++) {
            var selected_district = current_index != i ? $('.form_district').eq(i).val() : 'All Role';
            var selected_role = current_index != i ? $('.assign_role').eq(i).val() : 'All Role';
            var current_district = $('.form_district').eq(current_index).val();
            var current_role = $('.assign_role').eq(current_index).val();
            if ((current_role != "") && (selected_district == current_district && selected_role == current_role)) {
                console.log("sa");
                $('.office-district-row').eq(current_index).find(`.assign_role`).val('').trigger('change');
                // $('.office-district-row').eq(current_index).find(`.form_district option[value=${current_district}]`).attr('disabled', true);
                // $('.office-district-row').eq(current_index).find(`.assign_role option[value=${current_role}]`).attr('disabled', true);
                Swal.fire(
                    'Same options are not allowed '
                );
            }
        }
        $('#common_role').val() ? $(`.assign_role option[value=${$('#common_role').val()}]`).attr('disabled', true) : '';
    }
}

export default AuthoritiesModule;
