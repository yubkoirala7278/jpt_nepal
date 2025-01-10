<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admit Card</title>
    <style>
        @font-face {
            font-family: 'NotoSansJP' !important;
            src: url('{{ storage_path('fonts/NotoSansJP-Regular.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        body {
            font-family: 'NotoSansJP' !important;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            src: url('{{ storage_path('fonts/NotoSansJP-Regular.ttf') }}') format('truetype');
        }

        @page {
            size: A4;
            margin: 20mm;
        }

        .container {
            width: 100%;
            padding: 0;
        }


        .header img {
            width: 100px;
            height: auto;
            object-fit: contain;
        }

        .title {
            text-align: center;
            flex-grow: 1;
            font-size: 16px;
        }

        .profile-image {
            text-align: center;
        }

        .title p {
            margin: 0;
            font-weight: bold;
        }

        .exam-info {
            margin-top: 5px;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 6px 10px;
            border: 1px solid #afafaf;
            text-align: left;
            font-size: 12px;
        }

        td:first-child {
            font-weight: bold;
        }



        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .title {
            display: inline-block;
            vertical-align: top;
            margin-left: 10px;
        }


        /* For print media */
        @media print {
            body {
                margin: 0;
            }

            .container {
                padding: 0;
                margin: 0;
            }

            .admit-card {
                padding: 15px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="admit-card">
            <div class="header">
                <div class="title" style="font-size: 12px">
                    第393回 JPT 日本語能力試験 受験票 / 393rd test JPT Examination Voucher
                    しけんとうじつ じゅけんひょう かなら も き
                    試験当日、この受験票を必ず持って来てください。
                    Please be sure to bring this examination voucher with you on the day of the examination.
                </div>
            </div>
            <div class="exam-info">
                <table style="width: 100%; border-collapse: collapse;">
                    <!-- Section Header -->
                    <tr>
                        <td colspan="1" style="font-weight: bold; text-align: center; background-color: #f9f9f9; padding: 8px; width: 25%;">
                            <div style="font-size: 14px;">Date of the exam</div>
                        </td>
                        <td colspan="1" style="text-align: center; padding: 8px; width: 25%;">{{$examDate}}</td>
                        <td colspan="2" style="text-align:center; width: 50%;">
                            <img src="{{ $imagePath }}" alt="Profile Image" style="height: 100px">
                        </td>
                    </tr>
                
                    <tr>
                        <td colspan="2" style="font-weight: bold; text-align: center; background-color: #f9f9f9; padding: 8px; width: 50%;">
                            <div style="font-size: 14px;">Reception hours</div>
                        </td>
                        <td colspan="2" style="text-align: center; padding: 8px; width: 50%;">{{$receptionHours}}</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="font-weight: bold; text-align: center; background-color: #f9f9f9; padding: 8px; width: 50%;">
                            <div style="font-size: 14px;">Test venue</div>
                        </td>
                        <td colspan="2" style="text-align: center; padding: 8px; width: 50%;">ブトワル (Butwal)</td>
                    </tr>
                
                    <!-- Examinee Information Header -->
                    <tr>
                        <td colspan="4" style="text-align: center; font-weight: bold; background-color: #eaeaea; padding: 8px;">
                            Examinee Information
                        </td>
                    </tr>
                
                    <!-- Examinee Information -->
                    <tr>
                        <td style="font-weight: bold; background-color: #f9f9f9; padding: 8px; width: 25%;">Venue Code</td>
                        <td colspan="3" style="padding: 8px; width: 75%;">3455</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold; background-color: #f9f9f9; padding: 8px; width: 25%;">Examinee's Number</td>
                        <td colspan="3" style="padding: 8px; width: 75%;">{{$examineeNumber}}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold; background-color: #f9f9f9; padding: 8px; width: 25%;">Date of Birth</td>
                        <td colspan="3" style="padding: 8px; width: 75%;">{{ $dob }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold; background-color: #f9f9f9; padding: 8px; width: 25%;">Gender</td>
                        <td colspan="3" style="padding: 8px; width: 75%;">{{ $gender }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold; background-color: #f9f9f9; padding: 8px; width: 25%;">Examinee Category</td>
                        <td colspan="3" style="padding: 8px; width: 75%;">{{ $examineeCategory }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold; background-color: #f9f9f9; padding: 8px; width: 25%;">Exam Category</td>
                        <td colspan="3" style="padding: 8px; width: 75%;">{{ $examCategory }}</td>
                    </tr>
                
                    <!-- Notes -->
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 8px;">{{$applicantName}}</td>
                    </tr>
                    <tr>
                        <td colspan="4" style="text-align: center; font-weight: bold; padding: 8px; background-color: #f9f9f9; font-size: 12px; font-weight: normal;">
                            <i>Score certificate will show the registered information as it appears here. Corrections to registered information and photo changes will be accepted at the examination site on the day of the exam.</i>
                        </td>
                    </tr>
                
                    <!-- Belongings -->
                    <tr>
                        <td colspan="4" style="text-align: center; font-weight: bold; padding: 8px; background-color: #eaeaea;">
                            Belongings
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" style="padding: 8px; font-size: 12px; text-align: justify; font-weight: normal;">
                            Pencil or mechanical pencil (black B or HB), eraser, watch (smart watches are not allowed), ID (with photo. Photocopies are not accepted. Please make sure to bring the original).
                        </td>
                    </tr>
                
                    <!-- Precautions -->
                    <tr>
                        <td colspan="4" style="text-align: center; font-weight: bold; padding: 8px; background-color: #eaeaea;">
                            Precautions
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" style="padding: 8px; font-size: 12px; text-align: justify; font-weight: normal;">
                            Examinees must bring their admit copy and a government-issued ID, enter 30 minutes before the exam, avoid phones and smartwatches, and comply with exam rules, or face removal and cancellation for misconduct.
                        </td>
                    </tr>
                
                    <!-- Footer -->
                    <tr>
                        <td colspan="2" style="padding: 12px; width: 50%;">
                            <img src="{{ $logo }}" alt="Logo Image" style="width: 140px;">
                        </td>
                        <td colspan="2" style="padding: 12px; font-size: 14px; width: 50%;">
                            <strong>Contact for more details:</strong>
                            <br> Kathmandu: 9851181648
                            <br> Birtamod: 9852640662
                        </td>
                    </tr>
                </table>
                

            </div>
        </div>
    </div>
</body>

</html>
