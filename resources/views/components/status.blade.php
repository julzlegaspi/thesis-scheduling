@props(['statusCode'])

@if ($statusCode == \App\Models\Team::PENDING)
    <span
        {{ $attributes->merge(['class' => 'bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300']) }}>
        {{ $slot }}
    </span>
@endif

@if ($statusCode == \App\Models\Team::FOR_PANELIST_APPROVAL)
    <span
        {{ $attributes->merge(['class' => 'bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300']) }}>
        {{ $slot }}
    </span>
@endif

@if ($statusCode == \App\Models\Team::APPROVED)
    <span
        {{ $attributes->merge(['class' => 'bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300']) }}>
        {{ $slot }}
    </span>
@endif

@if ($statusCode == \App\Models\Team::DECLINED)
    <span
        {{ $attributes->merge(['class' => 'bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300']) }}>
        {{ $slot }}
    </span>
@endif

