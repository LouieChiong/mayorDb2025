<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voter List</title>
    <style>
        @page {
            size: A4;
            margin: 20mm;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            padding: 20px;
            box-sizing: border-box;
            border: 1px solid #000;
        }
        .header {
            width: 100%;
            margin-bottom: 20px;
            display: -ms-flexbox;
            display: -webkit-flex;
            display: flex;
            -ms-flex-align: center;
            -webkit-align-items: center;
            -webkit-box-align: center;
            align-items: center;
        }
        .header .logo {
            width: 100px; /* Set fixed width for logos */
            height: 100px; /* Set fixed height for logos */
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .header .title {
            text-align: center;
            font-weight: bold;
            font-size: 16px;
            flex: 1; /* Allow title to take remaining space */
        }
        .details {
            margin-bottom: 20px;
        }
        .details div {
            margin-bottom: 5px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            border: 1px solid #000;
            text-align: left;
            padding: 5px;
        }
        .table th {
            background-color: #f2f2f2;
        }
        .footer {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header with Logos and Title in a row -->
        <div class="header">
            <table style="width: 100%">
                <tr>
                    <td style="width: 25%; text-align: center; flex: 1; justify-content: center; align-items: center;">
                        <img src="{{ public_path('storage/images/logo2.png') }}" width="100" height="100" alt="Left Logo" style="max-width: 100%; height: auto;">
                    </td>
                    <td style="width: 50%; text-align: center; font-weight: bold; font-size: 16px; flex: 1; justify-content: center; align-items: center;">
                        <span style="font-size: 20px; font-weight: bolder"> HUGPONG SURIGAO DEL SUR </span>
                        <br>
                        MUNICIPALITY OF BAROBO
                    </td>
                    <td style="width: 25%; text-align: center; flex: 1; justify-content: center; align-items: center;">
                        <img src="{{ public_path('storage/images/logo.png') }}" width="110" height="110" alt="Right Logo" style="max-width: 100%; height: auto;">
                    </td>
                </tr>
            </table>
        </div>

        <!-- Details Section -->
        <div class="details">
            <div style="text-transform: capitalize"> <span style="font-weight: bold">MUNICIPAL: BAROBO</span>  </div>
            <div style="text-transform: capitalize"> <span style="font-weight: bold">BARANGAY:</span> {{  optional($leader->barangay)->barangay_name ?? ' Not Assigned' }} </div>
            <div style="text-transform: capitalize"> <span style="font-weight: bold">PUROK / SITIO:</span>   {{  optional($leader->barangay)->purok_name ?? ' Not Assigned' }} </div>
        </div>

        @php
            $count = 2;
        @endphp
        <!-- Voters Table -->
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 10% !important">Members</th>
                    <th>Voter Name</th>
                    <th style="width: 15% !important">PRCNT #</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="width: 10% !important">1</td>
                    <td>{{ $leader->full_name }}</td>
                    <td style="text-align: right, width: 15% !important">{{ $leader->precinct }}</td>
                </tr>
                    @foreach ($voters as $index => $voter)
                        <tr>
                            <td style="width: 10% !important">{{ $count++ }}</td>
                            <td>{{ $voter->full_name }}</td>
                            <td style="text-align: right, width: 15% !important">{{ $voter->precinct }}</td>
                        </tr>
                    @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3">Total Count: {{ $voters->count() + 1 }}</td>
                </tr>
            </tfoot>
        </table>

        <div style="margin-top: 20px">
            <p>Confirme:</p>
            <p style="text-align: left;">
                <span style="border-bottom:2px solid">{{ $leader->full_name }}</span>
            </p>
            <p style="text-align: left; position: relative; width: 40%;">
                <span style="text-align: center; position: absolute; top: 18px; left:74px">Signature</span>
                <br />
                <span>__________________________</span>
            </p>
        </div>
    </div>
</body>
</html>
