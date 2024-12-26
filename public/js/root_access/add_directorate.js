import ReuseModule from "../reuse_modules/ReuseModule.js";
import RootProcessModule from "./RootProcessModule.js";

const root_process_module = new RootProcessModule();
const reuse_module = new ReuseModule();
$(document).ready(function () {
    // ----------- add directorate -------------
    $(document).on('submit','#add-direc-form',async function(e){

        e.preventDefault();
        root_process_module.addDirectorate();
    });
    // ------- filter directorate by depertment ----------------
    $(document).on('change','#select-depertment',async function(){
        root_process_module.fetchDirectDept($('#select-depertment').val())
    });
});
