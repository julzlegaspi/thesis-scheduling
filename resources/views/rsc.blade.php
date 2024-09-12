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
            width: 100%;
            margin: 0;
            /* Remove margin to extend the layout */
            padding: 20px;
            background-color: #fff;
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
        <p><strong>PROJECT TITLE:</strong> {{ strtoupper($rsc->team->thesis_title) }}</p>
        <p><strong>TEAM ALIAS:</strong> {{ strtoupper($rsc->team->name) }}</p>
        <p><strong>DATE:</strong> {{ strtoupper(\Carbon\Carbon::parse($rsc->created_at)->format('F j, Y')) }}</p>
        <p><strong>BY:</strong> {{ strtoupper($rsc->uploader?->name) }}</p>

        <p>
            @foreach (\App\Models\Schedule::DEFENSE_STATUS as $key => $defenseStatus)
                <input type="checkbox" id="{{ $key }}" {{ $key == $rsc->status ? 'checked' : '' }}>
                <label for="{{ $key }}">{{ $defenseStatus }}</label>&nbsp;
            @endforeach
        </p>

        <h3>{{ $rsc::TYPE[$rsc->type] }}</h3>
        <table>
            <thead>
                <tr>
                    <th>CHAPTER</th>
                    <th>PAGE NO.</th>
                    <th>RECOMMENDATIONS, SUGGESTIONS AND COMMENTS (RSC)</th>
                    <th>ACTION TAKEN</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rsc->comments as $comment)
                    <tr>
                        <td>{{ $comment->chapter }}</td>
                        <td>{{ $comment->page_number }}</td>
                        <td>{!! nl2br($comment->comments) !!}</td>
                        <td>[{{ $comment->user->name }}] <br> {!! nl2br($comment->action_taken) !!}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="notes">
            <p><strong>Noted by:</strong></p>
            @foreach ($rsc->team->panelists as $panelist)
                <p>{{ $panelist->name }}, {{ ($panelist->is_panel_chair ) ? 'Panel Chairman' : 'Panel Member' }}</p>
            @endforeach
        </div>
    </div>
</body>

</html>
