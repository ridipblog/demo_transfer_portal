import UserAuthModule from "./UserAuthModule.js";
const user_auth_module = new UserAuthModule();
$(document).ready(function () {
    // -------------- post login form data ----------------
    $(document).on('submit', '#user-login-form', async function (e) {
        e.preventDefault();
        user_auth_module.userLogin('#user-login-form');
    });

})
