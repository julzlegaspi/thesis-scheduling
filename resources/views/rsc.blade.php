<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $rsc->team->thesis_title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1,
        h2,
        h3 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f8f8f8;
        }

        .notes {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>{{ $rsc->team?->thesis_title }}</h1>
        <h2>{{ $rsc->team?->name }}</h2>
        <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($rsc->created_at)->format('F j, Y') }}</p>
        <p><strong>By:</strong> {{ $rsc->uploader?->name }}</p>

        <p>
            @foreach (\App\Models\Schedule::DEFENSE_STATUS as $key => $defenseStatus)
                <input type="checkbox" id="{{ $key }}" {{ ($key == $rsc->status) ? 'checked' : '' }}>
                <label for="{{ $key }}">{{ $defenseStatus }}</label>&nbsp;
            @endforeach
        </p>

        <h3>Manuscript</h3>
        <table>
            <thead>
                <tr>
                    <th>Chapter</th>
                    <th>Recommendations Suggestions and Comment (RSC)</th>
                    <th>Action Taken</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $rsc->manuscript_chapter }}</td>
                    <td>{!! nl2br($rsc->manuscript_rsc) !!}</td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <div class="notes">
            <p><strong>General comments:</strong> {{ $rsc->general_comments ?? 'N/A' }}</p>

            @if ($rsc->redefense_status == true)
                <p><strong>Re-defense on:</strong>
                    {{ \Carbon\Carbon::parse($rsc->team->schedule->start)->format('F j, Y @ g:i:s A') }}</p>
            @endif
        </div>

        <h3>Software Program</h3>
        <table>
            <thead>
                <tr>
                    <th>Module No. (DFD)</th>
                    <th>Recommendations Suggestions and Comments (RSC)</th>
                    <th>Action Taken</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td>{!! nl2br($rsc->software_program_rsc) !!}</td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <div class="notes">
            <p><strong>Noted by:</strong></p>
            @foreach ($rsc->team->panelists as $panelist)
                @if ($loop->first)
                    <p>{{ $panelist->name }}, Panel Chairman</p>
                @else
                    <p>{{ $panelist->name }}, Panel Member {{ $loop->index + 1 }}</p>
                @endif
            @endforeach
        </div>
    </div>
</body>

</html>
