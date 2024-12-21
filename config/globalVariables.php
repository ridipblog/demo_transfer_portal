<?php
return [
    'registration_documtns' => [
        '1' => 'photo',
        '2' => 'signature',
        '3' => "pan_card",
        '4' => "depertment_card",
        // '5' => "no_govt_due_certificate",
        // '6' => 'appoinment_letter', //optional document
        // '7' => 'first_page_of_service_book' //optional document
    ],
    'registration_upload_name' => [
        '1' => 'photo',
        '2' => 'signature',
        '3' => "pan_card",
        '4' => "depertmental_card",
        // '5' => "no_govt_due_certificate",
        // '6' => 'appointment_letter', //optional document
        // '7' => 'first_page_of_service_book' //optional document
    ],
    'all_users_tables' => [
        '1' => 'user_credentials',
        '2' => 'appointing_authories'

    ],
    'pan_retrive_api_key' => [
        'api_key' => '$2a$05$HJ2SEB6.PilCuaGfz9KHwe.0.XL1GZuYTPaNAhUu9X7gAr1huCOaO'
    ],
    'pay_band_list' => [
        '1' => '20000-30000',
        '2' => '31000-40000',
        '3' => '41000-50000',
        '4' => '51000-60000'
    ],

    'profile_alter_text' => [
        'profile_status' => [
            '0' => [
                'color' => 'yellow',
                'header' => 'Verification in Progress',
                'body' =>
                'Your account verification is in progress. You will be notified once your profile is approved.',
            ],
            '1' => [
                'color' => 'green',
                'header' => 'Verification Completed',
                'body' =>
                'Your profile has been successfully verified. You can now proceed with submitting or receiving transfer requests.',
            ],
            '2' => [
                'color' => 'red',
                'header' => 'Profile rejected !',
                'body' =>
                'Your profile is rejected. Update and resubmit your profile.',
            ],
            '3' => [
                'color' => 'yellow',
                'header' => 'Profile Incomplete',
                'body' =>
                'Your profile is currently incomplete. Please <u><a href="/employees/update-profile" style="color:blue;" >complete your profile</a></u> to proceed with account verification and enable mutual transfer requests.',
            ],
        ],
        'noc_status' => [
            '0' => [
                'color' => 'yellow',
                'header' => 'Profile Not Recomended ',
                'body' => 'Your profile is verified but not yet recomended, Please contact your respective appointing authority.',
            ],
            '1' => [
                'color' => 'green',
                'header' => 'Profile Recomended',
                'body' => 'Your profile has been recomemded. You can now proced with transfer request.',
            ],
            '2' => [
                'color' => 'red',
                'header' => 'Profile Not Recommended',
                'body' => 'Your profile has been rejected for recommendation. Please contact your respective appointing authority for further assistance.',
            ]
        ],
        'second_transfer_verification' => [
            '1' => [
                'color' => 'yellow',
                'header' => 'Transfer is approved by Department HOD ',
                'body' => 'Transfer one step up, processs is still process ',
            ],
            '2' => [
                'color' => 'red',
                'header' => 'Transfer is rejected',
                'body' => 'Transfer application is rejected , now you can request again  ',
            ]
        ]
    ],

];
