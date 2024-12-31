import RequestModule from "../reuse_modules/RequestModule.js";
import ReuseModule from "../reuse_modules/ReuseModule.js";
const reuse_module=new ReuseModule();
class StateRegisration extends RequestModule{
    constructor(){
        super();
    }
    // ---------- registration of  state user -------------
    registerStateUser=async(form)=>{
        reuse_module.processingStatus('.submit-registration', 'Register');
        var form_data=new FormData($(form)[0]);
        this.formPostReponse=(response)=>{
            console.log(response);
            if(response.res_data.status==400){
                reuse_module.showErrorMessage('.registration-input', '.registration-error', response.res_data.message, 'back_end');
                reuse_module.focusErrorMessage('.registration-input', '.registration-error');
            }else{
                Swal.fire({
                    title: response.res_data.status == 401 ? 'Information' : 'Success',
                    text: response.res_data.message,
                    icon: response.res_data.status == 401 ? 'info' : 'success' // Use 'success', 'error', 'warning', or 'info' based on the message type
                }).then(() => {
                    response.res_data.status == 401 ? '' : window.location.reload();
                })
            }
        }
        await this.formPost(form_data,'/register-state-user');
        reuse_module.processingStatus('.submit-registration', "end", 'Register');
    }
}

export default StateRegisration;
