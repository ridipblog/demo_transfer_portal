<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>No Objection Certificate</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: "Lato", sans-serif;
            box-sizing: border-box;
        }

        body {
            padding: 20mm;
            font-size: 1rem;
            width: 175mm;
            /* A4 Width */
            height: 285mm;
            /* A4 Height */
            background-image: url('{{ public_path('images/watermark.png') }}');
            background-repeat: no-repeat;
            background-position: center;
            background-size: contain;
        }

        h1 {
            text-align: center;
            font-size: 1.8rem;
            margin-bottom: 20px;
        }

        p {
            margin: 10px 0;
            line-height: 1.6;
        }

        .content {
            margin-top: 20px;
            text-align: justify;
        }

        .inline-txt {
            text-indent: 0;
            display: inline-block;
            /*        border-bottom: 1px dashed #000;*/
            text-align: center;
            padding: 0 !important;
            line-height: 0;
            font-weight: 600;
        }

        table {
            width: 100%;
            margin-top: 40px;
        }

        td {
            vertical-align: top;
        }

        .signatory {
            text-align: right;
            margin-top: 50px;
        }

        .footer {
            margin-top: 80px;
            text-align: center;
        }

        .footer td {
            font-size: 0.75rem;
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
    </style>
</head>

<body>
    @if (!$view_data['is_error'])
        @php
            $pdf_data = $view_data['noc_details'];
        @endphp
        <h1>No Objection Certificate (NOC)</h1>
        <p>Date: {{ \Carbon\Carbon::now()->format('d,F Y') }}</p>

        <div class="content">
            <p>It is hereby certified that Shri / Smti <span
                    class="inline-text">{{ $pdf_data->full_name ?? 'N/A' }}</span> currently serving as <span
                    class="inline-text">{{ $pdf_data->employment_details->post_names->name ?? 'N/A' }}</span> in
                {{ $pdf_data->employment_details->post_names->type == 1 ? 'Grade III' : 'Grade IV' }} in the office of
                <span class="inline-text">{{ $pdf_data->employment_details->offices_finassam->name ?? 'N/A' }}</span>,
                District of <span
                    class="inline-text">{{ $pdf_data->employment_details->districts->name ?? 'N/A' }}</span>, in the Pay
                Band of <span class="inline-text">{{ $pdf_data->employment_details->pay_band }}</span> with Grade Pay of
                <span class="inline-text">{{ $pdf_data->employment_details->grade_pay }}</span> under the
                <span class="inline-text">{{ $pdf_data->employment_details->departments->name ?? 'N/A' }}</span>
                Department, has
                applied for a No Objection Certificate for a mutual transfer.
            </p>

            <p>As per the terms and conditions of the Government of Assam Notification No. <span
                    class="inline-text">xxxxx</span> dated <span
                    class="inline-text">{{ \Carbon\Carbon::now()->format('d,F,Y') }}</span>, it is confirmed that
                the applicant has no pending liabilities under this Appointing Authority, and no departmental or
                criminal proceedings are pending. The undersigned, as the Appointing Authority, has no objection to the
                mutual transfer of the applicant, subject to a suitable replacement and the realization of any
                government loans.</p>
        </div>

        <table style="margin-top: 120px;">
            <tr>
                <td></td>
                <td width="200px" style="text-align:center;margin-top: 150px;">
                    <p>Appointing Authority Name</p>
                    <p>{{ $pdf_data->noc_generated_by_user->post_names->name ?? 'Designation' }}</p>
                    <p>(Appointing Authority)</p>
                </td>
            </tr>
        </table>

        <table style="margin-top:18rem;">
            <tr>
                <td><small>www.swagatasatirtha.assam.gov.in</small></td>
                <td style="text-align: center;"><small>+91 882 676 2317</small></td>
                <td style="text-align: right;"><small>helpdesk.swagatasatirtha@gmail.com</small></td>
            </tr>
        </table>
    @else
        <h1>{{ $view_data['message'] }}</h1>
    @endif
</body>

</html>
