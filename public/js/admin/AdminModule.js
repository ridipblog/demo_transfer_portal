import RequestModule from "../reuse_modules/RequestModule.js";
import ReuseModule from "../reuse_modules/ReuseModule.js";
const reuse_module=new ReuseModule();
class AdminModule extends RequestModule{
    constructor(){
        super();
    }
    // ---------------- admin login  helper --------------
    // ------------ post login data ---------------
    adminLogin = async (form) => {
        reuse_module.processingStatus('.admin-login-btn');
        var form_data = new FormData($(form)[0]);
        $('.user-login-error').html('')
        this.formPostReponse = async (response) => {

            if (response.res_data.status == 200) {
                window.location.href = `/admin/admin-dashboard`;
                console.log(response.res_data.message);

            } else if (response.res_data.status == 400) {
                reuse_module.showErrorMessage('.user-login-input', '.user-login-error', response.res_data.message, 'back_end');
                reuse_module.focusErrorMessage('.user-login-input', '.user-login-error');
            } else {
                $('.user-login-error').eq(1).html(response.res_data.message);
            }
        }
        await this.formPost(form_data, '/admin/admin-login-api');
        reuse_module.processingStatus('.admin-login-btn', 'end', 'Login');
    };
}

export default AdminModule;
