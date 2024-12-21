<?php

return [
    'site_name' => 'SWAGATA SATIRTHA',
    'site_tag' => 'GOVT. OF ASSAM',
    'nav_menu' => [
        'dash' => 'Dashboard',
        'apl' => 'Applicants',
        'logout' => 'Logout',
    ],
    'heading' => 'Create Your Profile',
    'text' => 'Please create your profile by providing the necessary details',
    'search_pan' => [
        'pan_no' => 'Enter your PAN Number registered with FINASSAM',
        'button' => 'Submit',
    ],
    'form' => [
        'basic_info' => [
            'heading' => 'Basic Information',
            'name' => 'Full Name',
            'dob' => 'Date of Birth',
            'gender' => 'Gender',
            'f_name' => 'Father Name',
            'm_name' => 'Mother Name',
            'caste' => 'Category',
            'pno' => 'Phone number',
            'apno' => 'Alt. Phone number',
            'email' => 'Email',
            'pan' => 'PAN Number',
            'messages' => [
                'title' => 'Persional information not found !!',
                'text' => 'We were unable to find your persional information. Please try again later.',
            ],
        ],
        'emp_info' => [
            'heading' => 'Employment Information',
            'dist_cp' => 'District (Current Posting)',
            'dept_cp' => 'Department (Current Posting)',
            'office_cp' => 'Office (Current Posting)',
            'desg_cp' => 'Designation (Current Posting)',
            'doj_fj' => 'Date of Joining (First Joining)',
            'doj_cp' => 'Date of Joining (Current Posting)',
            'g_pay' => 'Grade Pay',
            'p_bank' => 'Pay Band',
            'messages' => [
                'title' => 'Employment information not found !!',
                'text' => 'We were unable to find your employment information. Please try again later.',
            ],
        ],
        'prefs' => [
            'heading' => 'Preferences',
            'note_1' => 'Note: Choose the preferred districts you wish to transfer to. ',
            'note_2' => 'Preferences and employment information to recommend the most compatible mutual transfer opportunities.',
            1 => '1st',
            2 => '2nd',
            3 => '3rd',
            4 => '4th',
            5 => '5th',
        ],
        'addl_info' => [
            'heading' => 'Additional Information',
            'ccp' => 'Are there any criminal cases pending?',
            'dpp' => 'Are there any departmental proceedings pending against you?',
            'mtb' => 'Have you availed any mutual transfer before?',
            'no_mt' => 'How many mutual transfer already availed?',
            'govt_due' => 'Any pending govt. dues?',
            'messages' => [
                'title' => 'Additional information not found !!',
                'text' => 'We were unable to find any addition information. Please try again later.',
            ],
        ],
        'docs' => [
            'heading' => 'Documents',
            'txt_1' => 'Drop item here or',
            'txt_2' => 'Browse files',
            'txt_3' => 'Max size',
            1 => 'photo',
            2 => 'signature',
            3 => 'pan_card',
            4 => 'department_id_card',
            5 => 'no_govt_due_certificate',
            6 => 'appointment_letter',
            7 => 'first_page_of_service_book',
        ],
        'submit' => [
            'decl_1' => 'I hereby declare that all information provided is correct to the best of my knowledge. I understand that if any discrepancy is found, my application is liable to be rejected.',
            'decl_2' => 'I agree to the terms laid down in the',
            'decl_2_link' => 'Standard Operating Procedure (SOP)',
            'button' => [
                'save' => 'Save',
                'submit' => 'Preview & Final Submit',
                'update' => 'Update profile',
            ],
        ],
    ],
    'preview' => [
        'heading' => 'Preview Details',
        'button' => [
            'close' => 'Close',
            'submit' => 'Final Submit',
        ],
    ],
    'profile_status' => [
        'status' => [
            'pending' => 'Pending',
            'verified' => 'Verified',
            'not_recc' => 'Not Recommended',
            'recc' => 'Recommended',
        ],
        'steps' => [
            1 => 'Account Created',
            2 => 'Complete profile',
            3 => 'Profile Verified',
            4 => 'Recommended',
        ],
        'button' => [
            'request' => 'New mutual transfer',
        ],
    ],
    'dashboard' => [
        'pen_ver' => 'Your Profile',
        'button' => [
            'edit' => 'Edit',
        ],
        'my_request' => [
            'heading' => 'My Request',
            'card' => [
                'status' => 'Active',
                'heading' => 'Mutual Transfer Requested',
                'btn_appDown' => 'Mutual Transfer Application',
            ],
            'no_req_act' => 'No Active Mutual Transfer',
            'req_now' => 'Request Now',
            'status' => [
                'rej_aa' => 'Rejected by Approving Authority',
                'apr_aa' => 'Transfer Approved',
                'acc_usr' => 'Accepted by Recepient',
                'cnl_you' => 'Canceled by you',
                'rej_usr' => 'Rejected by user',
            ],
            'button' => [
                'order' => 'Joint Transfer Order',
                'cancel' => 'Cancel',
            ],
        ],
        'no_inc' => [
            'heading' => 'Incoming Requests',
            'txt' => 'No Incomming Requests.',
            'button' => [
                'yes' => 'Yes',
                'no' => 'No',
            ],
        ],
        'by_pref' => [
            'heading' => 'Recommended by preference',
            'table_col1' => 'District',
            'table_col2' => 'Count',
            'btn_list' => 'View List',
        ],
    ],
    'search_profile' => [
        'heading' => 'All Profiles',
        'dist' => 'District',
        'office' => 'Office',
        'btn_filter' => 'Filter',
        'plr' => 'Search by Name or PAN Number...',
        'btn_search' => 'Search',
        'table_col1' => 'Name & Designation',
        'table_col2' => 'Office & Department',
        'table_col3' => 'Phone',
        'send_request' => [
            'heading' => 'Send Request',
            'p_1' => 'Send your transfer request to ',
            'p_2' => 'I have seen your profile and interested in mutual transfer.',
            'btn_close' => 'Close',
            'btn_accept' => 'Send Request',
        ],
        'nfd' => [
            'heading' => 'No Profile Found!',
            'txt' => 'No profiles are available at the current time. Please visit later.',
        ],
    ],
    'profile_alter_text' => [
        'profile_status' => [
            [
                'color' => 'yellow',
                'header' => 'Verification in Progress',
                'body' => 'Your profile verification is under progress, you will be informed once it gets verified. ',
            ],
            [
                'color' => 'green',
                'header' => 'Verification Completed',
                'body' => 'Your profile has been successfully verified. You can now proceed with submitting or receiving transfer requests.',
            ],
            [
                'color' => 'red',
                'header' => 'Profile rejected !',
                'body' => 'Your profile is rejected. Update and resubmit your profile.',
            ],
            [
                'color' => 'yellow',
                'header' => 'Profile Incomplete',
                'body' => 'Your profile is currently incomplete. Please <u><a href="/employees/update-profile" style="color:blue;" >complete your profile</a></u> to proceed with account verification and enable mutual transfer requests.',
            ],
        ],
        'noc_status' => [
            [
                'color' => 'yellow',
                'header' => 'Recommendation Pending',
                'body' => 'Your profile has been verified, but the recommendation process is still pending. Please contact your respective appointing authority for further assistance.',
            ],
            [
                'color' => 'green',
                'header' => 'Recommendation Completed',
                'body' => 'Your profile has been verified, and the recommendation has been successfully completed.',
            ],
            [
                'color' => 'red',
                'header' => 'Profile Not Recommended',
                'body' => 'Your profile has been rejected for recommendation. Please contact your respective appointing authority for further assistance.',
            ],
        ],
        'second_transfer_verification' => [
            1 => [
                'color' => 'yellow',
                'header' => 'Transfer is recommend by Department HOD ',
                'body' => 'Transfer request is recommended by the department HOD, please wait for approval.',
            ],
            2 => [
                'color' => 'red',
                'header' => 'Transfer is rejected',
                'body' => 'Transfer application is rejected , now you can request again  ',
            ],
        ],
        'reason' => 'Reason',
    ],
];
