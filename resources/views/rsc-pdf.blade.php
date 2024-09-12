<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $rsc->team->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet" />
</head>

<body>
    <!-- Header Section -->
    <div class="mb-8">
        <h2 class="font-semibold text-lg">RSC</h2>
        <div class="mt-4">
            <div class="flex mb-4">
                <span class="font-semibold w-1/3 text-lg">PROJECT TITLE : {{ strtoupper($rsc->team->thesis_title) }}</span>
            </div>
            <div class="flex mb-4">
                <span class="font-semibold w-1/3 text-lg">TEAM ALIAS : {{ strtoupper($rsc->team->name) }}</span>
            </div>
            <div class="flex mb-4">
                <span class="font-semibold w-1/3 text-lg">DATE : {{ strtoupper(\Carbon\Carbon::parse($rsc->created_at)->format('F j, Y')) }}</span> &nbsp;&nbsp;&nbsp;&nbsp;
                @foreach (\App\Models\Schedule::DEFENSE_STATUS as $key => $defenseStatus)
                    {!! ($key == $rsc->status) ? "[ / ] ". $defenseStatus . '&nbsp;&nbsp;&nbsp;' : '[ ] ' . $defenseStatus . '&nbsp;&nbsp;&nbsp;' !!}
                @endforeach
            </div>
            <div class="flex mb-4">
                <span class="font-semibold w-1/3 text-lg">SECRETARY : {{ strtoupper($rsc->uploader?->name) }}</span>
            </div>
            <div class="flex mb-4">
               
            </div>
        </div>

    </div>

    <!-- Table Section -->
    <div class="overflow-x-auto relative mt-8">
        <table class="w-full text-sm text-left text-gray-500 border border-gray-300">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                <tr>
                    <th scope="col" class="py-3 px-6 border-r border-gray-300">Chapter</th>
                    <th scope="col" class="py-3 px-6 border-r border-gray-300">Page No.</th>
                    <th scope="col" class="py-3 px-6 border-r border-gray-300">Recommendations, Suggestions, and
                        Comments (RSC)</th>
                    <th scope="col" class="py-3 px-6">Action Taken</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rsc->comments as $comment)
                    @if ($loop->iteration % 2 == 0)
                        <tr class="bg-white border-b border-gray-300">
                            <td class="py-4 px-6 border-r border-gray-300">{{ strtoupper($comment->chapter) }}</td>
                            <td class="py-4 px-6 border-r border-gray-300">{{ strtoupper($comment->page_number) }}</td>
                            <td class="py-4 px-6 border-r border-gray-300">{!! nl2br($comment->comments) !!}</td>
                            <td class="py-4 px-6">[{{ $comment->user->name }}] <br> {!! nl2br($comment->action_taken) !!}</td>
                        </tr>
                    @else
                        <tr class="bg-gray-50 border-b border-gray-300">
                            <td class="py-4 px-6 border-r border-gray-300">{{ strtoupper($comment->chapter) }}</td>
                            <td class="py-4 px-6 border-r border-gray-300">{{ strtoupper($comment->page_number) }}</td>
                            <td class="py-4 px-6 border-r border-gray-300">{!! nl2br($comment->comments) !!}</td>
                            <td class="py-4 px-6">[{{ $comment->user->name }}] <br> {!! nl2br($comment->action_taken) !!}</td>
                        </tr>
                    @endif
                   
                    
                @endforeach
               
            </tbody>
        </table>
        <p class="mt-2 text-sm">***Strictly word-processed</p>
    </div>

    <!-- Noted By Section -->
    <div class="mt-10">
        <p class="font-semibold underline">NOTED BY:</p>
        <div class="grid grid-cols-3 gap-4">
            @foreach ($rsc->team->panelists as $panelist)
                <div>
                    <p class="mt-6 font-semibold">{{ strtoupper($panelist->name) }} <br> {{ ($panelist->is_panel_chair ) ? 'PANEL CHAIRMAN' : 'PANEL MEMBER' }}</p>
                </div>
            @endforeach
        </div>
    </div>


    <script>
        window.onload = function() {
          window.print();
        }
    </script>
</body>

</html>
