<?php

return [
    'login_page' => [
        'heading' => 'Login',
        'sub_text' => 'Enter your credentials to continue',
        'input' => [
            'phone' => 'Your registered Phone number',
            'pass' => 'Your Password',
        ],
        'forgot_pass' => 'Forgot password?',
        'button' => 'Login',
        'no_ac' => 'Don\'t have an account?',
        'reg' => 'Register now',
    ],
    'register_page' => [
        'heading' => 'Please Start The Registration Process here',
        'input' => [
            'name' => 'Full Name',
            'phone' => 'Phone number',
            'email' => 'Email',
            'pass' => 'Password',
            'pass_text' => 'Must be 6 characters, alphanumeric and must have atleast one uppercase and one lowercase letter',
            'c_pass' => 'Confirm Password',
            'c_pass_text' => 'Must be same as password',
            'check' => 'I agree to the terms laid down in the',
            'check_link' => 'Standard Operating Procedure (SOP)',
        ],
        'button' => 'Submit',
        'have_ac' => 'Already have an account?',
        'login' => 'Login here',
    ],
    'otp' => [
        'heading' => 'OTP Code Verification',
        'sent_to' => 'We have sent an OTP code to',
        'button' => 'Verify & Proceed',
        'no_code' => 'Didn\'t receive code?',
        'resend' => 'Resend Now',
        'messages' => [
            'title' => 'Session Expired',
            'text' => 'Your session has expired due to inactivity. Please refresh the page or click the button below to return to the registration page.',
        ],
    ],
];
