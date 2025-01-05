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

        .table .next {
            border:  1px solid #000;
            border-right: none !important;
            border-left: none !important;
            padding: 5px;
            height: 14px;
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
            <div style="text-transform: capitalize"> <span style="font-weight: bold">Leader List</span>  </div>

        </div>

        <!-- Voters Table -->
        <table class="table">
            <thead>
                    <tr>
                        <th style="width: 35%; text-align: center; font-size: 14px">Leader Name</th>
                        <th style="width: 30%; text-align: center; font-size: 14px">Barangay</th>
                        <th style="width: 20%; text-align: center; font-size: 14px">Purok / Sitio</th>
                        <th style="width: 10%; text-align: center; font-size: 14px">Precinct</th>
                        <th style="width: 8%; text-align: center; font-size: 14px">Members</th>
                    </tr>
            </thead>
                <tbody>
                    @if($groupLeaders->isNotEmpty())
                        @foreach ($groupLeaders as $leaders)
                            @foreach ($leaders as $leader)
                                <tr>
                                    <td style="font-size: 12px">{{ $leader->full_name ?? '-' }}</td>
                                    <td style="font-size: 12px">{{ $leader->barangay->barangay_name ?? '-' }}</td>
                                    <td style="font-size: 12px">{{ $leader->barangay->purok_name ?? '-' }}</td>
                                    <td style="font-size: 12px; text-align: center">{{ $leader->precinct ?? '-' }}</td>
                                    <td style="font-size: 12px; text-align: center">{{ optional($leader->voters)->count() }}</td>
                                </tr>
                            @endforeach
                            <tr >
                                <td colspan="5" >{{$leaders->first()->barangay->barangay_name }} leaders: {{ $leaders->count() }} </td>
                            </tr>
                            <tr>
                                <td class="next" colspan="5"></td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
        </table>
    </div>
</body>
</html>
