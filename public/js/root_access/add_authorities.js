import AuthoritiesModule from "./AuthoritiesModule.js";
const authorities_module=new AuthoritiesModule();
$(document).ready(function(){
    // ------------- disabled role in form --------------
    $(document).on('change','#common_role',function(){
        authorities_module.disabledRoleOption($(this),'.assign_role');
    });
    // --------------- get offices by district ---------------
    $(document).on('change','.form_district',async function(e){
        var current_index=$('.form_district').index(this);
        authorities_module.disabledAssignOption(current_index,'district');
        $('.form_offices').eq(current_index).attr('disabled',true);
        await authorities_module.getOfficeByDistrict(current_index,$(this),'.form_offices');
        $('.form_offices').eq(current_index).attr('disabled',false);
    });
    // ---------------- disabed selected option--------------
    $(document).on('change','.assign_role',async function(e){
        var current_index=$('.assign_role').index(this);
        authorities_module.disabledAssignOption(current_index,'role');

    })
    // ----------------- add new assign form -------------
    $(document).on('click','.add-assign-form',function(){
        authorities_module.addAssignForm();
    });
    // ------------- remove assign form -------------
    $(document).on('click','.remove-assign-form',function(){
        var current_index=$('.remove-assign-form').index(this);
        $('.office-district-row').eq(current_index).remove();
    });
    // -------------- Authority registration ---------------
    $(document).on('submit','#authority_registration',function(e){
        e.preventDefault();
        authorities_module.authorityRegistration('#authority_registration');
    });
    // ------------- display district name by offices  -------------
    $(document).on('change','.form_offices',function(){
        var current_index=$('.form_offices').index(this);
        authorities_module.getDistrictByOfficess(current_index,$(this));
    });
    // ----------------- view assign data ---------------
    $(document).on('click','.view-assign-data',function(){
        console.log($(this).val())
        authorities_module.viewAssignData($(this).val());
    })
});
