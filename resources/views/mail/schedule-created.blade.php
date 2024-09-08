<x-mail::message>
# Hello, {{ $panelist->name}}

A thesis schedule has been submitted for approval for the team '{{ $schedule->team->name }}' with the thesis title '{{ $schedule->team->thesis_title }}'.

Please log in to the app to view more details and to approve or deny.

<x-mail::button :url="route('approvals.index')">
View more details
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
