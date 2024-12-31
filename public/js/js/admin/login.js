import AdminModule from "./AdminModule.js";
const admin_module = new AdminModule();

$(document).ready(function () {
    // ---------------- admin login ----------------
    $(document).on('submit', '#admin-login-form',async function (e) {
        e.preventDefault();
        admin_module.adminLogin('#admin-login-form');
    });
});
