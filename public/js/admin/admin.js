import AdminModule from "./AdminModule.js";
const admin_module = new AdminModule();

$(document).ready(function () {

    // ---- revert user by admin -------------

    $(document).on('click', '.revert_id', async function () {
        await admin_module.reverUser($(this).val());
    })
});
