import RequestModule from "./RequestModule.js";

class ReuseModule extends RequestModule {
    constructor() {
        super();
    }
    // ----- show validation error message --------------
    showErrorMessage = async (class_input, class_error, message, res_type = null) => {
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
        // $(class_error).eq(0).html("{{__('transfer_messages.transfer_message.request_cancel')}}")
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
    previewImage = async (image_class, preview_class = null) => {
        $(document).on('change', image_class, function (event) {
            var index = $(this).index(image_class);
            let file = $(this)[0].files[0];
            if (file) {
                let extension = file.name.split('.').pop().toLowerCase();
                    if(extension=="pdf"){
                        const fileURL = URL.createObjectURL(file);
                        $('.selected-document-pdf').eq(index).attr('href',fileURL);
                        $('.contain-document-image').eq(index).addClass('hidden');
                        $('.contain-document-pdf').eq(index).removeClass('hidden');
                    }else{
                        const fileURL = URL.createObjectURL(file);
                        $('.selected-document-img').eq(index).attr('src',fileURL);
                        $('.contain-document-pdf').eq(index).addClass('hidden');
                        $('.contain-document-image').eq(index).removeClass('hidden');
                    }
                    // $('.preview_registration_document').eq(index).attr('src', e.target.result);
                    $('.review-document-image-div').eq(index).show();
            }
        });
    }
    // ----------------- confirmatio message --------------
    confirmMessage = async (title, btn_text, text = "You won't be able to revert this!", icon = "warning") => {
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
    focusErrorMessage = async (input_class, error_class) => {
        $(error_class).each(function (index) {
            if ($(this).text() !== "") {
                $(input_class).eq(index).focus();
                return false;
            }
        });
    }
    // ------------------- fetch selection relational data -------------------
    getOfficePostNames = async (selection, is_district = false,is_directorate=false) => {
        const form_data = {
            depertment_id: $('#select_depert').val(),
            district_id: $('#select_district').val(),
            directorate_id:$('#select_direct').val(),
            is_district: is_district,
            is_directorate:is_directorate
        }
        this.formPostReponse = async (response) => {
            if (response.res_data.status == 200) {
                var offices = '<option value="" selected disabled>— Select —</option>';
                var posts = '<option value="" selected disabled>— Select —</option>';
                response.res_data.offices.forEach(office => {
                    offices += `<option value=${office.office_id}>${office.office_fin_assam.name}</option>`
                });
                if (!is_district || !is_directorate) {
                    response.res_data.posts.forEach(post => {
                        posts += `<option value=${post.post_names.id}>${post.post_names.name}</option>`
                    });
                    $('#select_degis').html(posts);
                }
                $('#select_office').html(offices);
            } else {
                Swal.fire(
                    response.res_data.message
                )
            }

        }
        await this.formGet(form_data, '/get-offices-posts');
    }
    // -------------- changae office by disrict ---------------
    getOfficesByDistrict = async (district_id, office_place) => {

        const form_data = {
            district_id: district_id
        };
        this.formPostReponse = (response) => {
            var offices = '<option value="" selected>All</option>';
            if (response.res_data.status == 200) {
                response.res_data.offices.forEach(office => {
                    offices += `<option value=${office.office_id}>${office?.office_fin_assam?.name}</option>`
                });
            } else {
                Swal.fire(
                    response.res_data.message
                )
            }
            office_place.html(offices);
        }

        await this.formGet(form_data, '/get-offices-by-district');
    }
    // ---------------------- fetch grade pay relations data -------------------
    getPayGrade = async (selection) => {
        const form_data = {
            depertment_id: $('#select_depert').val(),
            post_id: $('#select_degis').val()
        }
        this.formPostReponse = async (response) => {
            $('#review_pay_grade').val(response.res_data.pay_grade);
        }
        await this.formGet(form_data, '/get-pay-grade');
    }

    // -------------- calculate two date ---------------
    async calculateDates(input_date, today = new Date()) {
        let start = new Date(input_date);
        let end = new Date(today);

        let years = end.getFullYear() - start.getFullYear();
        let months = end.getMonth() - start.getMonth();
        let days = end.getDate() - start.getDate();
        // if (years < 0 || months < 0 || days < 0) {
        //     throw new Error("please enter a valid date ");
        // }
        if (days < 0) {
            months--;
            let previousMonth = new Date(end.getFullYear(), end.getMonth(), 0);
            days += previousMonth.getDate();
        }

        if (months < 0) {
            years--;
            months += 12;
        }

        return `${years} years ${months} months`;
    }

    // ------------- fetch office by district and depertment -------------
    async fetchOfficeDistDeprt(district_id = null, depertment_id = null, append_to) {
        const form_data = {
            district_id: district_id,
            depertment_id: depertment_id
        }
        this.formPostReponse = async (response) => {

            let offices = `<option disabled >Select</option>`;
            if (response.res_data.status == 400) {

            } else if (response.res_data.status == 200) {
                if (response.res_data.offices.length>0) {
                    offices += `<option value="all">All Office</option>`;
                    response.res_data.offices.forEach(office => {
                        offices += `<option value="${office?.office_fin_assam?.id ?? ''}">${office?.office_fin_assam?.name ?? ''}</option>`;
                    });
                } else {

                }
            }
            $(append_to).html(offices)
        }
        await this.formGet(form_data, '/fetch-off-dist-dept');
    }
    // ------------ fetch directorate by depertment --------------
    async fetchDirectDept(depertment_id, append_to) {
        let form_data = {
            depertment_id: depertment_id
        };
        this.formPostReponse = async (response) => {

            let options = `<option selected disabled >- Select -</option>`;
            if (response.res_data.status == 200) {
                options += `<option value="0">Not Applicable</option>`;
                if (response.res_data.directorates.length > 0) {
                    response.res_data.directorates.forEach((map, index) => {
                        options += `<option value="${map.id}">${map.name}</option>`;
                    });
                } else {
                }

            }
            $(append_to).html(options);
        }
        this.formGet(form_data, '/fetch-direct-dept');
    }

}

export default ReuseModule;
