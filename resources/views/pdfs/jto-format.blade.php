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
        line-height: 25px;
    }

    .nor-body {
        margin-top: 20px;
        /*        text-indent: 150px;*/
        line-height: 25px;
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

    .bord,
    .bord td,
    .bord th {
        border: 1px solid black;
        border-collapse: collapse;
        padding: 2px;
    }

    ol {
        list-style: decimal;
        padding-left: 10px;
    }
</style>

<body>

    <table>
        <tr>
            <td colspan="2">
                <h3 style="text-align: center;">GOVERNMENT OF ASSAM</h3>
                <h3 style="text-align: center;">OFFICE OF THE Director of {{ $candidate2->department_name }}</h3>
                <h3 style="text-align: center;">GUWAHATI</h3>
                <hr style="margin-bottom: 50px">
            </td>
        </tr>
        <tr>
            <td># {{ $ref_code }}</td>
            <td style="text-align:right;">Date: {{ \Carbon\Carbon::parse($date)->format('d-m-Y') }}</td>
        </tr>
        <tr>
            {{-- either grade/3 or grade/4 by post --}}
            <td colspan="2"><br>
                <p class="cert-body">In pursuance the of the approval No……………and as per provision of the officer
                    memorandum No.GAD/386878/ dated 31/12/2024 , the following
                    {{ $candidate1->grade_type == 3 ? 'Grade III' : 'Grade IV' }} employees are hereby transferred as
                    per mutual request in their own grade and Scale of Pay with effect from the date of joining as per
                    place of posting mentioned below.</p> <br>
            </td>
        </tr>
    </table>

    <table class="bord">
        <tr>
            <th width="30%">Details</th>
            <th>Applicant 1</th>
            <th>Applicant 2</th>
        </tr>
        <tr>
            <td>Full Name</td>
            <td>{{ $candidate1->full_name }}</td>
            <td>{{ $candidate2->full_name }}</td>
        </tr>
        <tr>
            <td>Mobile Number</td>
            <td>{{ $candidate1->phone }}</td>
            <td>{{ $candidate2->phone }}</td>
        </tr>
        <tr>
            <td>Present Office Name</td>
            <td>{{ $candidate1->office_name }}, {{ $candidate1->department_name }}, {{ $candidate1->district_name }}
            </td>
            <td>{{ $candidate2->office_name }}, {{ $candidate2->department_name }}, {{ $candidate2->district_name }}
            </td>
        </tr>
        <tr>
            <td>Present Working District</td>
            <td>{{ $candidate1->district_name }}</td>
            <td>{{ $candidate2->district_name }}</td>
        </tr>
        <tr>
            <td>Transferred to (Office Name)</td>
            <td>{{ $candidate2->office_name }}, {{ $candidate2->department_name }}, {{ $candidate2->district_name }}
            </td>
            <td>{{ $candidate1->office_name }}, {{ $candidate1->department_name }}, {{ $candidate1->district_name }}
            </td>
        </tr>
    </table>

    <table>
        <tr>
            <td colspan="">
                {{-- <p class="nor-body"><span class="inline-txt">{{ $candidate1->full_name }}</span> will join in the
                    office of <span class="inline-txt">{{ $candidate2->office_name }}</span> and <span
                        class="inline-txt">{{ $candidate2->full_name }}</span> will join in the Office of <span
                        class="inline-txt">{{ $candidate1->office_name }}</span>.</p>
                <br><br> --}}
                <p>TERMS & CONDITIONS</p>
                <ol class="nor-body">
                    <li>Both the employees shall be released within 7 days from the issuance of this order.</li>
                    <li>In case an applicant pairing in mutual transfer is not in the office anymore due to resignation,
                        retirement or demise etc. this mutual transfer order will be treated as cancelled.</li>
                    <li>In case of detection of any kind of discrepancies at any stage either in the documents or
                        information submitted by the applicant/ applicants, the entire process will be cancelled without
                        assigning any reasons threof or the candidates will be reverted to their original place of
                        posting.
                    </li>
                    <li>In case of detection of any discrepancies either in the documentation or information
                        submitted by the applicant / applicants the entire process will be cancelled.</li>
                    <li>No TA & DA shall be admissible for the purpose.</li>
                </ol>
            </td>
        </tr>
    </table>

    <table style="margin-top: 60px;">
        <tr>
            <td></td>
            <td width="200px" style="text-align:center;margin-top: 50px;">
                {{-- <p>State Level Competent Authority</p>
                <p>Assam Secretariat, Dispur</p> --}}

                <p>Sd/-</p>
                <p>{{ $designation }}</p>
                <p>{{ $candidate2->department_name }}</p>
                <p>Date: {{ \Carbon\Carbon::parse($date)->format('d-m-Y') }}</p>

            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td colspan="">
                {{-- <p class="nor-body"><span class="inline-txt">{{ $candidate1->full_name }}</span> will join in the
                    office of <span class="inline-txt">{{ $candidate2->office_name }}</span> and <span
                        class="inline-txt">{{ $candidate2->full_name }}</span> will join in the Office of <span
                        class="inline-txt">{{ $candidate1->office_name }}</span>.</p>
                <br><br> --}}
                <p>Copy for information & necessary action to:-</p>
                <ol class="nor-body">
                    <li>The</li>
                    <li>The</li>
                    <li>The</li>
                    <li>The</li>
                    <li>The</li>
                </ol>
            </td>
        </tr>
    </table>

    <table style="margin-top: 60px;">
        <tr>
            <td></td>
            <td width="200px" style="text-align:center;margin-top: 50px;">
                <p>{{ $designation }}</p>
                <p>{{ $candidate2->department_name }}</p>

            </td>
        </tr>
    </table>
    <table class="t-100 bor-0-0 fs-12" style="margin-top: 50px!important; text-align:center;">
        <tr>
            <td class=" fs-10 p-1" style="color: #aaaaaa!important; text-align: center;">This is a system generated
                order, no signature is required.</td>
        </tr>
    </table>

</body>

</html>
