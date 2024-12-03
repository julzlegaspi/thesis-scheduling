<div>
    <section wire:poll.10s
        class="bg-white dark:bg-gray-900 bg-[url('https://flowbite.s3.amazonaws.com/docs/jumbotron/hero-pattern.svg')] dark:bg-[url('https://flowbite.s3.amazonaws.com/docs/jumbotron/hero-pattern-dark.svg')]">
        <div class="py-8 px-4 mx-auto max-w-screen-xl text-center lg:py-16 z-10 relative">
            <span class="text-lg bg-blue-600 rounded-full text-white px-4 py-1.5 me-3">On-Going</span>
            @if ($ongoingSchedule)
                <h1
                    class="mt-4 mb-4 text-4xl font-extrabold tracking-tight leading-none text-gray-900 md:text-5xl lg:text-6xl dark:text-white">
                    {{ $ongoingSchedule->team->name }}: {{ $ongoingSchedule->team->thesis_title }}</h1>

                <p class="mb-8 text-lg font-normal text-gray-500 lg:text-xl sm:px-16 lg:px-48 dark:text-gray-200">

                    @foreach ($ongoingSchedule->team->members as $member)
                        @if ($loop->first)
                            {{ $member->course->code }}-{{ $member->section->name }}:
                        @endif
                        {{ $member->name }}@if(!$loop->last),@endif
                    @endforeach
                </p>
            @else
                <h1
                    class="mt-4 mb-4 text-4xl font-extrabold tracking-tight leading-none text-gray-900 md:text-5xl lg:text-6xl dark:text-white">
                    No schedule</h1>
            @endif
        </div>
        <div
            class="bg-gradient-to-b from-blue-50 to-transparent dark:from-blue-900 w-full h-full absolute top-0 left-0 z-0">
        </div>
    </section>

    <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-12 z-10 relative">
        <div class="text-center mb-8">
            <span class="text-lg bg-orange-600 rounded-full text-white px-4 py-1.5 me-3">Upcoming</span>
        </div>
        <!-- Add alignment classes -->
        <ol class="relative border-s border-gray-400 dark:border-gray-700 ms-auto me-auto max-w-screen-md">
            @forelse ($upcomingSchedules as $upcoming)
                <li class="mb-10 ms-4">
                    <div
                        class="absolute w-3 h-3 bg-gray-500 rounded-full mt-1.5 -start-1.5 border border-white dark:border-gray-900 dark:bg-gray-700">
                    </div>
                    <time class="mb-1 text-xl font-normal leading-none text-gray-500 dark:text-gray-500">{{ \Carbon\Carbon::parse($upcoming->start)->format('F d, Y @ h:i A') }}</time>
                    <h3 class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $upcoming->team->name }}: {{ $upcoming->team->thesis_title }}</h3>
                    <p class="mb-4 text-base font-normal text-gray-500 dark:text-gray-500">
                        @foreach ($upcoming->team->members as $member)
                            @if ($loop->first)
                                {{ $member->course->code }}-{{ $member->section->name }}:
                            @endif
                            {{ $member->name }}@if(!$loop->last),@endif
                        @endforeach
                    </p>
                </li>
            @empty
                <p class="text-center mb-4 text-2xl font-normal text-gray-500 dark:text-gray-400">
                    There are no upcoming schedules at the moment.
                </p>
            @endforelse
        </ol>
    </div>


</div>
