import RequestModule from "../reuse_modules/RequestModule.js";
import ReuseModule from "../reuse_modules/ReuseModule.js";
const reuse_module = new ReuseModule();
class RootProcessModule extends RequestModule {
    constructor() {
        super();
    }
    // --------- add director form -----------
    async addDirectorate(form) {
        var form_data = new FormData($('#add-direc-form')[0]);
        this.formPostReponse = async (response) => {
            console.log(response)
            if (response.res_data.status == 200) {

                Swal.fire(
                    'success',
                    response?.res_data?.message,
                    'success'
                ).then(() => {
                    window.location.reload();
                });
            } else {
                Swal.fire(
                    'info',
                    response?.res_data?.message,
                    'info'
                );
            }
        }
        this.formPost(form_data, '/add-directorate');
    }
    // ------------ fetch directorate by depertment --------------
    async fetchDirectDept(depertment_id) {
        let form_data = {
            depertment_id: depertment_id
        };
        this.formPostReponse = async (response) => {
            let tbody = $('#dirct-body');
            tbody.empty();
            if (response.res_data.status == 200) {
                if (response.res_data.directorates.length > 0) {
                    response.res_data.directorates.forEach((map, index) => {
                        tbody.append(`
                        <tr>
                            <td class="text-center">${index + 1}</td>
                            <td>${map?.deptartments?.name || 'N/A'}</td>
                            <td>${map?.name || 'N/A'}</td>
                        </tr>
                    `);
                    });
                } else {
                    tbody.append(
                        ` <tr>
                        <td colspan="3" class="text-center text-gray-500">No data available</td>
                    </tr>`
                    );
                }
            }
        }
        this.formGet(form_data, '/fetch-direct-dept');
    }
    // ------------ assign directorate to office -----------------
    async assignDirecToOffice(form) {
        let form_data = new FormData($(form)[0]);
        this.formPostReponse = async (response) => {
            console.log(response)
            if (response.res_data.status == 200) {
                Swal.fire(
                    'info',
                    response.res_data.message,
                    'info'
                ).then(() => {
                    window.location.reload();
                });
            } else if (response.res_data.status == 400) {
                reuse_module.showErrorMessage('.registration-input', '.registration-error', response.res_data.message);
            } else {
                Swal.fire(
                    'info',
                    response.res_data.message,
                    'info'
                );
            }
        }
        await this.formPost(form_data, '/assign-directorate-office');
    }

}

export default RootProcessModule;
