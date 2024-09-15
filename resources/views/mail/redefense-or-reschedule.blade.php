<x-mail::message>
# Hello Admin,

@if ($schedule->custom_status == $schedule::RE_DEFENSE)
The thesis defense re-defense schedule has been re-submitted for approval.
@endif

@if ($schedule->custom_status == $schedule::RE_SCHEDULE)
The thesis defense schedule has been re-submitted for approval after being rescheduled.
@endif


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

<x-mail::button :url="route('approvals.index')">
Approve or Decline
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
