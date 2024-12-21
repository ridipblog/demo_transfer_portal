
import UserAuthModule from "../public/UserAuthModule.js";
const user_auth_module=new UserAuthModule();

// -------------- post login form data ----------------
$(document).on('submit','#verification-department-login-form',async function(e){
    e.preventDefault();
    // 
    user_auth_module.verificationDepartmentLogin('#verification-department-login-form');
});
