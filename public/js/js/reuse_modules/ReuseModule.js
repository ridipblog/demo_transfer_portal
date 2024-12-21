import RequestModule from "./RequestModule.js";

class ReuseModule extends RequestModule{
    constructor(){
        super();
    }
    // ----- show validation error message --------------
    showErrorMessage=async(class_input, class_error, message, res_type = null)=>{
        $(class_error).html('');
        for (var i = 0; i < $(class_input).length; i++) {
            for (var j = 0; j < message.length; j++) {
                // message.forEach(mes => {
                // if (mes.indexOf($(class_input).eq(i).attr('name').replaceAll('_', ' ')) !== -1) {
                //     $(class_error).eq(i).html(mes);
                // }
                var regex;
                if (res_type == "back_end") {
                    regex = new RegExp(`\\b${$(class_input).eq(i).attr('name').replaceAll('_', ' ').replaceAll('[]', '')}\\b`, 'gim');
                } else {
                    regex = new RegExp(`\\b${$(class_input).eq(i).attr('name')}\\b`, 'gim');
                }
                if (regex.test(message[j])) {
                    $(class_error).eq(i).html(message[j].replaceAll('_', ' '));
                    if (res_type == "back_end") {
                        break;
                    }
                }

                // });
            }
        }
    }
    // -------------- procession status --------------
    // processingStatus=async(process_btn,process_type="start",text="Processing")=>{
    //     $(process_btn).attr('disabled',process_type=="start"?true:false);
    //     $(process_btn).html(text);

    // }
    processingStatus = async (process_btn, process_type = "start", text = "Processing") => {
        $(process_btn).attr('disabled', process_type === "start" ? true : false);

        if (process_type === "start") {
            $(process_btn).html(
                `<div class="h-4 w-4 rounded-full border-2 border-white/50 relative inline-block">
                <div class="h-4 w-4 rounded-full border-t-2 border-l-2 z-10 -top-0.5 -left-0.5 border-white absolute inline-block animate-spin"></div>
            </div> ${text}`
            );
        } else {
            $(process_btn).html(text);
        }
    };
    previewImage=async(image_class,preview_class=null)=>{
        $(document).on('change',image_class,function(event){
            var index=$(this).index(image_class);
            let file=event.target.files[0];
            if(file){
                let render=new FileReader();
                render.onload=function(e){
                    $('.preview_registration_document').eq(index).attr('src',e.target.result);
                }
                render.readAsDataURL(file);
            }
        });
    }
    // ----------------- confirmatio message --------------
    confirmMessage=async(title,btn_text,text="You won't be able to revert this!",icon="warning")=>{
        return Swal.fire({
            title: title,
            text: text,
            icon: icon,
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: btn_text
          });
    }
    // --------------------- focus on error field  --------------------
    focusErrorMessage=async(input_class,error_class)=>{
        $(error_class).each(function(index){
            if($(this).text()!==""){
                $(input_class).eq(index).focus();
                return false;
            }
        });
    }
    // ------------------- fetch selection relational data -------------------
    getOfficePostNames=async(selection)=>{
        const form_data={
            depertment_id:selection.val()
        }
        this.formPostReponse=async(response)=>{
            var offices='<option value="">— Select —</option>';
            var posts='<option value="">— Select —</option>';
            response.res_data.offices.forEach(office => {
                offices+=`<option value=${office.id}>${office.name}</option>`
            });
            response.res_data.posts.forEach(post => {
                posts+=`<option value=${post.post_names.id}>${post.post_names.name}</option>`
            });
            $('#select_office').html(offices);
            $('#select_degis').html(posts);
        }
        await this.formGet(form_data,'/get-offices-posts');
    }
    // ---------------------- fetch grade pay relations data -------------------
    getPayGrade=async(selection)=>{
        const form_data={
            depertment_id:$('#select_depert').val(),
            post_id:$('#select_degis').val()
        }
        this.formPostReponse=async(response)=>{
            $('#review_pay_grade').val(response.res_data.pay_grade);
        }
        await this.formGet(form_data,'/get-pay-grade');
    }
}

export default ReuseModule;
