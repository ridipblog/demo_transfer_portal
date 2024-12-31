import StateRegisration from "./StateRegisration.js";
const state_reg_module=new StateRegisration();
$(document).ready(function(){
    // ------------- state user registration ---------------
    $(document).on('submit','#state_user_registration',function(e){
        e.preventDefault();
        state_reg_module.registerStateUser('#state_user_registration');
    })
});
