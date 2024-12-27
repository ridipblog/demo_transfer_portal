<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>No Objection Certificate</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap"
        rel="stylesheet">
</head>
<style>
    * {
        margin: 0;
        padding: 0;
        font-family: "Lato", sans-serif;
        box-sizing: border-box;
    }

    p {
        margin: 0;
        padding: 0;
    }

    body {

        background-image: url(../../assets/img/watermark.png);
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        background-repeat: no-repeat;
        background-position: center;
        padding: 20mm;
        font-size: .85rem;
        width: 175mm;
        /* A4 Width */
        height: 285mm;
        /* A4 Height */
    }

    h1 {
        font-size: 1.4rem;
    }

    small {
        font-size: .75rem;
    }

    table {
        width: 100%;
    }

    .cert-body {
        margin-top: 20px;
        text-indent: 150px;
        line-height: 30px;
    }

    .inline-txt {
        text-indent: 0;
        /*        display: inline-block;*/
        /*        border-bottom: 1px dashed #000;*/
        text-align: center;
        padding: 0 !important;
        line-height: 0;
        font-weight: 600;
    }

    @media print {
        @page {
            size: A4;
            margin: 10mm;
        }

        body {
            padding: 0;
            margin: 0;
        }
    }

    html,
    body {
        height: 100%;
        /* width: 100%; */
    }

    .sign-div {
        height: 35px;
        margin-bottom: 5px;
    }
</style>

<body>
    @if (!$view_data['is_error'])
        @php
            $pdf_data = $view_data['trasnfer_employee_details'];
        @endphp
        <table>
            <tr>
                <td colspan="2">
                    <h1 style="text-align: center;margin-bottom: 50px">Joint Application for Mutual Transfer</h1>
                </td>
            </tr>
            <tr>
                <td>No.: {{ $pdf_data->transfer_ref_code }}</td>
                @php
                    $accepted_date = new DateTime($pdf_data->updated_at);
                @endphp
                <td style="text-align: right">Date: {{ $accepted_date->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td colspan="2"><br>
                    <p>To,</p>
                    <p>The State Level Competent Authority for Mutual Transfer, <br><span
                            class="inline-txt">{{ $pdf_data->transfer_employee_user->employment_details->departments->name }}</span>
                        Department<br>Government of Assam</p><br>
                    <p>Subject: Joint Application for Mutual Transfer</p><br>
                    <p>Sir / Madam</p>
                    <p class="cert-body">With reference to the above, we have the honour to inform you that, we <br>
                        (A) Shri/Smti <span
                            class="inline-txt">{{ $pdf_data->transfer_employee_user->full_name }}</span>,
                        presently serving as <span
                            class="inline-txt">{{ $pdf_data->transfer_employee_user->employment_details->post_names->name }}</span>
                        in
                        {{ $pdf_data->transfer_employee_user->employment_details->post_names->type == 3 ? 'Grade III' : 'Grade IV' }}
                        in the office of <span
                            class="inline-txt">{{ $pdf_data->transfer_employee_user->employment_details->offices_finassam->name }}</span>,
                        <span
                            class="inline-txt">{{ $pdf_data->transfer_employee_user->employment_details->districts->name }}</span>,
                        and under <span
                            class="inline-txt">{{ $pdf_data->transfer_employee_user->noc_generated_by_user->name ?? '' }},
                            {{ $pdf_data->transfer_employee_user->noc_generated_by_user->designation ?? '' }},
                            {{ $pdf_data->transfer_employee_user->noc_generated_by_user->departments->name ?? '' }},
                            {{ $pdf_data->transfer_employee_user->noc_generated_by_user->districts->name ?? '' }}</span>
                        as appointing authority
                        and <br>
                        (B) Shri / Smti <span
                            class="inline-txt">{{ $pdf_data->transfer_employee_target_user->full_name }}</span>,
                        presently
                        serving as <span
                            class="inline-txt">{{ $pdf_data->transfer_employee_target_user->employment_details->post_names->name }}</span>
                        in
                        {{ $pdf_data->transfer_employee_target_user->employment_details->post_names->type == 3 ? 'Grade III' : 'Grade IV' }}
                        in the office of <span
                            class="inline-txt">{{ $pdf_data->transfer_employee_target_user->employment_details->offices_finassam->name }}</span>,
                        <span
                            class="inline-txt">{{ $pdf_data->transfer_employee_target_user->employment_details->districts->name }}</span>
                        and under <span
                            class="inline-txt">{{ $pdf_data->transfer_employee_target_user->noc_generated_by_user->name ?? '' }},
                            {{ $pdf_data->transfer_employee_target_user->noc_generated_by_user->designation ?? '' }},
                            {{ $pdf_data->transfer_employee_target_user->noc_generated_by_user->departments->name ?? '' }},
                            {{ $pdf_data->transfer_employee_target_user->noc_generated_by_user->districts->name ?? '' }}</span>
                        as appointing authority,
                        do hereby apply for mutual transfer as per terms & Conditions laid down in the SOP, <span
                            class="inline-txt"></span>, dated <span class="inline-txt">XXX</span>.
                        The mutual transfer which may kindly be considered and approved at the earliest convenience. The
                        NOC from the respective Appointing Authorities are enclosed for ready reference.
                    </p>
                </td>
            </tr>
        </table>

        <table style="margin-top: 30px;">
            <tr>
                {{-- <td width="50%"></td> --}}
                <td style="">
                    <p>Yours faithfully</p><br><br>

                    <p>Name: <span class="inline-txt">{{ $pdf_data->transfer_employee_user->full_name ?? 'N/A' }}</span></p>
                    <p>Presently serving as: <span
                            class="inline-txt">{{ $pdf_data->transfer_employee_user->employment_details->post_names->name ?? 'N/A' }}</span>
                        in
                        {{ isset($pdf_data->transfer_employee_user->employment_details->post_names->type) ? ($pdf_data->transfer_employee_user->employment_details->post_names->type == 3 ? 'Grade III' : ' Grade IV') : '' }}
                        in the
                        office of <span
                            class="inline-txt">{{ $pdf_data->transfer_employee_user->employment_details->offices_finassam->name ?? 'N/A' }}</span>,
                        District: <span
                            class="inline-txt">{{ $pdf_data->transfer_employee_user->employment_details->districts->name ?? 'N/A' }}</span>
                    </p>
                    <p>
                        Directorate : <span
                            class="inline-txt">{{ isset($pdf_data->transfer_employee_user->employment_details->directorate_id) ? $pdf_data->transfer_employee_user->employment_details->directorate_id===0 ?'Not Applicable' : $pdf_data->transfer_employee_user->employment_details->directorate->name ?? 'N/A' : 'Not Assign' }}</span>
                    </p>
                    <p>Pay Band: <span
                            class="inline-txt">{{ $pdf_data->transfer_employee_user->employment_details->pay_band ?? 'N/A' }}</span>
                        Grade Pay: <span
                            class="inline-txt">{{ $pdf_data->transfer_employee_user->employment_details->pay_grade  ?? 'N/A'}}</span>
                    </p>
                </td>
            </tr>
            <tr>
                {{-- <td width="50%"></td> --}}
                <td style=""><br>

                    <p>Name: <span class="inline-txt">{{ $pdf_data->transfer_employee_target_user->full_name ?? 'N/A' }}</span>

                    </p>
                    <p>Presently serving as: <span
                            class="inline-txt">{{ $pdf_data->transfer_employee_target_user->employment_details->post_names->name ?? 'N/A' }}</span>
                        in
                        {{ isset($pdf_data->transfer_employee_target_user->employment_details->post_names->type) ? ($pdf_data->transfer_employee_target_user->employment_details->post_names->type == 3 ? 'Grade III' : ' Grade IV') : '' }}
                        in the
                        office of <span
                            class="inline-txt">{{ $pdf_data->transfer_employee_target_user->employment_details->offices_finassam->name ?? 'N/A' }}</span>,
                        District: <span
                            class="inline-txt">{{ $pdf_data->transfer_employee_target_user->employment_details->districts->name ?? 'N/A' }}</span>
                    </p>
                    <p>
                        Directorate : <span
                            class="inline-txt">{{ isset($pdf_data->transfer_employee_target_user->employment_details->directorate_id) ? $pdf_data->transfer_employee_user->employment_details->directorate_id===0 ?'Not Applicable' : $pdf_data->transfer_employee_user->employment_details->directorate->name ?? 'N/A' : 'Not Assign' }}</span>
                    </p>
                    <p>Pay Band: <span
                            class="inline-txt">{{ $pdf_data->transfer_employee_target_user->employment_details->pay_band ?? 'N/A' }}</span>
                        Grade Pay: <span
                            class="inline-txt">{{ $pdf_data->transfer_employee_target_user->employment_details->pay_grade ?? 'N/A' }}</span>
                    </p>
                </td>
            </tr>
        </table>

        <table style="position: absolute;bottom: 0;left: 0;width: 100%;padding: 50px;">
            <tr>
                <td><small>www.swagatasatirtha.assam.gov.in</small></td>
                <td style="text-align: center;"><small>+91 882 676 2317</small></td>
                <td style="text-align: right;"><small>helpdesk.swagatasatirtha@gmail.com</small></td>
            </tr>
        </table>
        <table class="t-100 bor-0-0 fs-12" style="margin-top: 50px!important">
            <tr>
                <td colspan="6" class="text-c fs-10 p-1" style="color: #aaaaaa!important;text-align: center;">(This
                    is a system generated
                    application, no signature required.)</td>
            </tr>
        </table>
    @else
        {{ $view_data['message'] }}
    @endif
</body>

</html>
