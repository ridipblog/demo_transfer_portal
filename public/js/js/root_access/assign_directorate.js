import ReuseModule from "../reuse_modules/ReuseModule.js";
import RootProcessModule from "./RootProcessModule.js";

const root_process_module = new RootProcessModule();
const reuse_module = new ReuseModule();
$(document).ready(function () {
    // ------------ fetch office by district and depertment-----------------
    $(document).on('change', '#select-district', async function () {
        let district_id = $('#select-district').val();
        console.log(district_id);
        let depertment_id = $('#select-depertment').val();
        reuse_module.fetchOfficeDistDeprt(district_id, depertment_id, '#select-offices');
    });
    $(document).on('change', '#select-depertment', async function () {
        let district_id = $('#select-district').val();
        let depertment_id = $('#select-depertment').val();
        await reuse_module.fetchOfficeDistDeprt(district_id, depertment_id, '#select-offices');
        await reuse_module.fetchDirectDept(depertment_id, '#select-directorate');
    });
    // ---------- assign diretorate to office ----------------
    $(document).on('submit', '#assign-direc-form', function (e) {
        e.preventDefault();
        root_process_module.assignDirecToOffice('#assign-direc-form');
    });

});
