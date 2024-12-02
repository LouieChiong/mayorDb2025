<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay List</title>
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
            <div style="text-transform: capitalize"> <span style="font-weight: bold">Barangay List</span>  </div>

        </div>

        <!-- Voters Table -->
        <table class="table">
            <tr>
                <th style="width: 35%; text-align: center">Barangay</th>
                <th style="width: 35%; text-align: center">Purok / Sitio</th>
                <th style="width: 15%; text-align: center">Leaders</th>
                <th style="width: 15%; text-align: center">Members</th>
            </tr>
            @foreach ($barangays as $barangay)
                <tr>
                    <td style="width: 35%">{{ $barangay->barangay_name }}</td>
                    <td style="width: 35%">{{ $barangay->purok_name }}</td>
                    <td style="text-align: center; width: 15%">{{ optional($barangay->leaders)->count() }}</td>
                    <td style="text-align: center; width: 15%">{{ optional($barangay->voters)->count() }}</td>
                </tr>
            @endforeach
        </table>
    </div>
</body>
</html>
