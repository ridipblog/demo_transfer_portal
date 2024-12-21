import RequestModule from "../reuse_modules/RequestModule.js";
import ReuseModule from "../reuse_modules/ReuseModule.js";
const reuse_module=new ReuseModule();
class TransferRequestModule extends RequestModule {
    constructor() {
        super();
    }
    // ------------------ cancel transfer request -----------------
    async transferRequestCancel(btn) {
        reuse_module.processingStatus(btn,null,'<i class="bi bi-arrow-clockwise"></i>');
        var form_data = new FormData();
        form_data.append('request_id', $(btn).val());
        this.formPostReponse = async (response) => {
            $('.pop-card-div').addClass('hidden');
            if(response.res_data.status==200){
                Swal.fire(
                    'info',
                    response.res_data.message,
                    'info'
                ).then(()=>{
                    window.location.reload();
                });
            }else{
                Swal.fire(
                    'info',
                    response.res_data.message,
                    'error'
                )
            }
        }
        await this.formPost(form_data, '/employees/request-cancel-api');
        reuse_module.processingStatus(btn,"end",'<iclass="bi bi-ban"></i>');
    }
    // -------------------- action request by target emloyeee----------------
    async actionOnRequest(btn,action,btn_text=null) {
        reuse_module.processingStatus(btn,null,'<i class="bi bi-arrow-repeat"></i>');
        var form_data = new FormData();
        form_data.append('request_id', $(btn).val());
        form_data.append('request_action',action);
        this.formPostReponse = async (response) => {
            $('.pop-card-div').addClass('hidden');
            if(response.res_data.status==200){
                Swal.fire(
                    'info',
                    response.res_data.message,
                    'info'
                ).then(()=>{
                    window.location.reload();
                });
            }else{
                Swal.fire(
                    'info',
                    response.res_data.message,
                    'error'
                )
            }
        }
        await this.formPost(form_data, '/employees/action-on-request-api');
        reuse_module.processingStatus(btn,"end",btn_text);

        // reuse_module.processingStatus(btn,"end",action=="reject" ? '<i class="bi bi-x"></i>':'<i class="bi bi-check"></i>');
    }
    // --------------------- search profiles for request by input and select ----------------
    async searchProfileForRequest(form,search_type=null){
        var form_data=new FormData($(form)[0]);
        form_data.append('search_type',search_type);
        this.formPostReponse=async(response)=>{

            $('.search-profile-data-div').empty();
            $('.search-profile-data-div').html(response);
        }
        await this.formPost(form_data,'/employees/search-profile-api',true);
    }
}

export default TransferRequestModule;
