import EmployeeProfileModule from './EmployeeProfileModule.js'
const employee_profile_module = new EmployeeProfileModule()
import ReuseModule from '../reuse_modules/ReuseModule.js'
const reuse_module = new ReuseModule()


$(document).ready(function () {
    // --------------- get relational data by depertment selectio-----------------
    $(document).on('change', '#select_depert', function () {
console.log("ok");
        reuse_module.getOfficePostNames($(this))
    });
$(document).on('change', '#select_district', function () {
        console.log($('#select_depert').val())
        reuse_module.getOfficePostNames('#select_depert',true)

    })
    // ------------------ get relational data by depertment and posts -------------
    $(document).on('change','#select_degis',function(){
        reuse_module.getPayGrade();
    });
    // ---------------- save employee profile ----------------
    $(document).on('click', '#save_profile', function (e) {
        employee_profile_module.saveOrSubmitProfile('#save-profile-form', '/employees/save-profile-api', '#save_profile')
    });
    // ------------------ preview final and submit --------------
    $(document).on('click', '.final_complete_btn', function (e) {
        employee_profile_module.saveOrSubmitProfile('#save-profile-form', '/employees/preview-submit-profile-api', '.final_complete_btn', 'preview')
    });
    // ----------------- final submit after preview ----------------
    $(document).on('click', '#all_submit_profile', function (e) {
        employee_profile_module.saveOrSubmitProfile('#save-profile-form', '/employees/submit-profile-api', '#all_submit_profile', 'all_submit')
    });
    // ------------------- update profile data -------------------
    $(document).on('click', '#update-profile-btn', function (e) {
        employee_profile_module.saveOrSubmitProfile('#save-profile-form', '/employees/update-profile-api', '#update-profile-btn', 'update_profile')
    });
    $(document).on('submit', '#update-employee-profile-form', function (e) {
        e.preventDefault()
        employee_profile_module.updateEmployeeProfile('#update-employee-profile-form')
    });
    // ---------------- remove current district form preference --------------
    reuse_module.previewImage('.registration_documents')
    $('input[name=before_mutual_transfer]').on('click', function () {
        var isChecked = $(this).val()
        if (isChecked == 'no') {
            $('#avlTfrVal').addClass('hidden')
        } else if (isChecked == 'yes') {
            $('#avlTfrVal').removeClass('hidden')
        } else {
            $('#avlTfrVal').addClass('hidden')
        }
    })

    $('input[name=pending_govt_dues]').on('click', function () {
        var isChecked = $(this).val()
        if (isChecked == 'yes') {
            $('#noDueCertDoc').addClass('hidden')
        } else if (isChecked == 'no') {
            $('#noDueCertDoc').removeClass('hidden')
        } else {
            $('#noDueCertDoc').addClass('hidden')
        }
    });

    $('.declaration-checkbox').on('change', function () {
        if ($('.declaration-checkbox').length === $('.declaration-checkbox:checked').length) {
            $('.submit-profile-btn').prop('disabled', false);
        } else {
            $('.submit-profile-btn').prop('disabled', true);
        }
    });

    $('.select2').select2();
});
