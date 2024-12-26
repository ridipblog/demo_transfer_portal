import EmployeeProfileModule from './EmployeeProfileModule.js'
const employee_profile_module = new EmployeeProfileModule()
import ReuseModule from '../reuse_modules/ReuseModule.js'
const reuse_module = new ReuseModule()

$(document).ready(function () {

    // --------------- get relational data by depertment selectio-----------------
    $(document).on('change', '#select_depert', async function () {
        $('#review_pay_grade').val('');
        await reuse_module.getOfficePostNames($(this))
        await reuse_module.fetchDirectDept($('#select_depert').val(),'#select_direct');
    })
    $(document).on('change', '#select_district', function () {
        console.log($('#select_depert').val())
        reuse_module.getOfficePostNames('#select_depert', true,true)
    });
    // ---------- fetch ofices by depertment , district and direcorate ----------
    $(document).on('change','#select_direct',async function(){
        await reuse_module.getOfficePostNames('#select_direct',true,true);
    });
    // ------------------ get relational data by depertment and posts -------------
    $(document).on('change', '#select_degis', function () {
        reuse_module.getPayGrade()
    })
    // ---------------- save employee profile ----------------
    $(document).on('click', '#save_profile', function (e) {
        employee_profile_module.saveOrSubmitProfile('#save-profile-form', '/employees/save-profile-api', '#save_profile')
    })
    // ------------------ preview final and submit --------------
    $(document).on('click', '.final_complete_btn', function (e) {
        employee_profile_module.saveOrSubmitProfile('#save-profile-form', '/employees/preview-submit-profile-api', '.final_complete_btn', 'preview')
    })
    // ----------------- final submit after preview ----------------
    $(document).on('click', '#all_submit_profile', function (e) {
        employee_profile_module.saveOrSubmitProfile('#save-profile-form', '/employees/submit-profile-api', '#all_submit_profile', 'all_submit')
    })
    // ------------------- update profile data -------------------
    $(document).on('click', '#update-profile-btn', function (e) {
        employee_profile_module.saveOrSubmitProfile('#save-profile-form', '/employees/update-profile-api', '#update-profile-btn', 'update_profile')
    })
    $(document).on('submit', '#update-employee-profile-form', function (e) {
        e.preventDefault()
        employee_profile_module.updateEmployeeProfile('#update-employee-profile-form')
    })
    // ------------ get ddo code by selecting office name ------------------
    // $(document).on('change', '#select_office', function () {
    //     var data = {
    //         office_id: $(this).val()
    //     }
    //     employee_profile_module.getDDOCode('/employees/get-ddo-code-api', data)
    // })
    // ---------------- remove current district form preference --------------
    $(document).on('change', '#select_district', function () {
        employee_profile_module.removeDistrictPrefence($(this).val())
    })
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
            $('.review-document-image-div').eq(4).hide();
            $('#noDueCertDoc').addClass('hidden');
        } else if (isChecked == 'no') {
            $('#noDueCertDoc').removeClass('hidden');
            $('.review-document-image-div').eq(4).show();
        } else {
            $('#noDueCertDoc').addClass('hidden');
            $('.review-document-image-div').eq(4).hide();
        }
    })

    $('.declaration-checkbox').on('change', function () {
        if ($('.declaration-checkbox').length === $('.declaration-checkbox:checked').length) {
            $('.final_complete_btn').prop('disabled', false)
        } else {
            $('.final_complete_btn').prop('disabled', true)
        }
    })

    // ------------ calculate time of service ------------
    $(document).on('change', '#date_of_join_id', async function () {
        try {
            let first_date_of_join = $('#date_of_join_id').val();
            let time_of_service = await reuse_module.calculateDates(first_date_of_join);
            $('#time_of_service').val(time_of_service)
        } catch (error) {
            $('#date_of_join_id').val('');
            $('#time_of_service').val('')
            Swal.fire(
                'info',
                error?.message,
                'info'
            );
        }
    });
    $('.select2').select2()

})
