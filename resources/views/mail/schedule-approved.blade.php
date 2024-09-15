<x-mail::message>
# Hello there,

A thesis defense schedule has been approved. Below are the details.

<strong>Thesis Title:</strong> {{ $schedule->team?->thesis_title }} <br>
<strong>Team Name:</strong> {{ $schedule->team?->name }} <br>
<strong>Members:</strong>
@foreach ($schedule->team->members as $member)
    <ul>
        <li>{{ $member->name }}, {{ $member->course?->code }} - {{ $member->section?->name }}</li>
    </ul>
@endforeach
<strong>Panelists:</strong>
@foreach ($schedule->team->panelists as $panelist)
    <ul>
        <li>{{ $panelist->name }}, {{ $panelist->is_panel_chair ? 'Panel chairman' : 'Panel member' }}</li>
    </ul>
@endforeach
<strong>When:</strong> {{ \Carbon\Carbon::parse($schedule->start)->format('F j, Y @ h:i A') }} <br>
<strong>Venue:</strong> {{ $schedule->venue?->name }} <br>
<strong>Type of Defense:</strong> {{ $schedule::DEFENSE_STATUS[$schedule->type_of_defense] }} <br>

<x-mail::button :url="route('dashboard')">
View Calendar
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
