<div>
    <!-- Card header -->
    <div class="items-center justify-between lg:flex">
        <div class="mb-4 lg:mb-0">
            <h1 class="mb-2 text-2xl font-bold text-gray-900 dark:text-white">Defense Schedules</h1>
            <span class="text-base font-normal text-gray-500 dark:text-gray-400">View and manage thesis defense
                schedules</span>
        </div>
        @can('admin.create')
            <div class="items-center sm:flex">
                <div class="flex items-center">
                    <x-primary-button data-modal-target="add-modal" data-modal-toggle="add-modal">
                        Add new schedule
                    </x-primary-button>
                </div>
            </div>
        @endcan
    </div>

    <!-- Table -->
    <div class="flex flex-col mt-6">
        <div class="overflow-x-auto rounded-lg">
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden shadow sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col"
                                    class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                    Thesis Title
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                    Team Name
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                    Members
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                    Panelist
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                    Venue
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                    Start
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                    Status
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                    Type
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">

                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800">
                            @forelse ($schedules as $schedule)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="p-4 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <a href="{{ route('schedule.show', $schedule) }}"
                                            class="font-normal text-blue-600 dark:text-blue-500 hover:underline">{{ $schedule->team->thesis_title }}</a>
                                    </td>
                                    <td
                                        class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                        {{ $schedule->team->name }}
                                    </td>
                                    <td
                                        class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                        <div class="flex -space-x-4 rtl:space-x-reverse">
                                            @foreach ($schedule->team->members as $members)
                                                @if (!empty($members->avatar))
                                                    <img class="w-10 h-10 border-2 border-white rounded-full dark:border-gray-800"
                                                        src="{{ asset('avatar/' . $members->avatar) }}" alt="avatar">
                                                @else
                                                    <img class="w-10 h-10 border-2 border-white rounded-full dark:border-gray-800"
                                                        src="https://ui-avatars.com/api/?name={{ $members->name }}&rounded=true&background=random"
                                                        alt="{{ $members->name }}" title="{{ $members->name }}">
                                                @endif
                                            @endforeach
                                        </div>
                                    </td>
                                    <td
                                        class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                        <div class="flex -space-x-4 rtl:space-x-reverse">
                                            @foreach ($schedule->team->panelists as $panelist)
                                                @if (!empty($panelist->avatar))
                                                    <img class="w-10 h-10 border-2 border-white rounded-full dark:border-gray-800"
                                                        src="{{ asset('avatar/' . $panelist->avatar) }}" alt="avatar">
                                                @else
                                                    <img class="w-10 h-10 border-2 border-white rounded-full dark:border-gray-800"
                                                        src="https://ui-avatars.com/api/?name={{ $panelist->name }}&rounded=true&background=random"
                                                        alt="{{ $panelist->name }}" title="{{ $panelist->name }}">
                                                @endif
                                            @endforeach
                                        </div>
                                    </td>
                                    <td
                                        class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                        {{ $schedule->venue?->name }}
                                    </td>
                                    <td
                                        class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                        {{ \Carbon\Carbon::parse($schedule->start)->format('F j, Y @ h:i A') }}
                                    </td>
                                    <td
                                        class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                        @if (!is_null($schedule->custom_status))
                                            <x-status
                                                statusCode="{{ $schedule->custom_status }}">{{ $schedule::STATUS[$schedule->custom_status] }}</x-status>
                                        @endif
                                        <x-status
                                            statusCode="{{ $schedule->status }}">{{ $schedule::STATUS[$schedule->status] }}</x-status>

                                    </td>
                                    <td
                                        class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                        {{ $schedule::DEFENSE_STATUS[$schedule->type_of_defense] }}
                                    </td>
                                    <td
                                        class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">

                                        @if ($schedule->user_id == auth()->user()->id)
                                            <button id="dropdownMenuIconButtonForAdmin{{ $loop->index }}"
                                                data-dropdown-toggle="dropdownDotsForAdmin{{ $loop->index }}"
                                                class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                                                type="button">
                                                <svg class="w-5 h-5" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                    viewBox="0 0 4 15">
                                                    <path
                                                        d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                                                </svg>
                                            </button>

                                            <!-- Dropdown menu -->
                                            <div id="dropdownDotsForAdmin{{ $loop->index }}"
                                                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                                    aria-labelledby="dropdownMenuIconButtonForAdmin{{ $loop->index }}">
                                                    <li>
                                                        <a href="#" wire:click="edit('{{ $schedule->id }}')"
                                                            data-modal-target="edit-modal"
                                                            data-modal-toggle="edit-modal"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
                                                    </li>
                                                    {{-- <li>
                                                        <a href="#" wire:click="destroy('{{ $schedule->id }}')"
                                                            wire:confirm="You are about to delete scheduled defense. Continue?"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Delete</a>
                                                    </li> --}}
                                                    <li class="border-t border-gray-200">
                                                        <a href="#"
                                                            wire:click="updateScheduleStatus('{{ $schedule->id }}', 'thesis-defended')"
                                                            wire:confirm="You are about to update the status. Continue?"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Thesis
                                                            Defended</a>
                                                    </li>
                                                    <li>
                                                        <a href="#"
                                                            wire:click="updateScheduleStatus('{{ $schedule->id }}', 're-defense')"
                                                            wire:confirm="You are about to update the status. Continue?"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Re-defense</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        @endif

                                        @can('student.update')
                                            <button id="dropdownMenuIconButtonForStudent{{ $loop->index }}"
                                                data-dropdown-toggle="dropdownDotsForAdminStudent{{ $loop->index }}"
                                                class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                                                type="button">
                                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                    fill="currentColor" viewBox="0 0 4 15">
                                                    <path
                                                        d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                                                </svg>
                                            </button>

                                            <!-- Dropdown menu -->
                                            <div id="dropdownDotsForAdminStudent{{ $loop->index }}"
                                                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                                    aria-labelledby="dropdownMenuIconButtonForStudent{{ $loop->index }}">
                                                    <li>
                                                        <a href="#" wire:click="edit('{{ $schedule->id }}')"
                                                            data-modal-target="redefense-or-reschedule-modal"
                                                            data-modal-toggle="redefense-or-reschedule-modal"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            Action</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white"
                                        colspan="7">
                                        No records
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
    {{ $schedules->links() }}

    <!-- Add modal -->
    <div id="add-modal" tabindex="-1" aria-hidden="true" wire:ignore.self
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Create New Schedule
                    </h3>
                    <button type="button" wire:click="clear"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-toggle="add-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form class="p-4 md:p-5">
                    <div class="grid gap-4 mb-4 grid-cols-2">

                        <div class="col-span-2">
                            <label for="type"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Type</label>

                            <select id="type" wire:model.live="type" wire:change="getTeamsByType"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="">Select option</option>
                                @foreach (\App\Models\Schedule::DEFENSE_STATUS as $key => $type)
                                    <option value="{{ $key }}">{{ $type }}</option>
                                @endforeach
                            </select>

                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>

                        
                        <div class="col-span-2">
                            <label for="team"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select
                                Team</label>

                            <select id="team" wire:model.live="team" wire:change="getTeamInfo"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="">Select option</option>
                                @foreach ($teams as $team)
                                    <option value="{{ $team->id }}">{{ $team->name }}
                                        {{ $team->schedule != null ? '(Scheduled on ' . \Carbon\Carbon::parse($team->schedule->start)->format('F j, Y @ h:i A') . ')' : '' }}
                                    </option>
                                @endforeach
                            </select>

                            <x-input-error :messages="$errors->get('team')" class="mt-2" />
                        </div>
                        @if ($team !== '')
                            <div class="col-span-2">
                                <label for="team"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Thesis
                                    Title</label>
                                <input type="text" value="{{ $thesisTitle }}" disabled
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            </div>
                            <div class="col-span-2">
                                <label for="members"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Members</label>
                                <textarea id="members" rows="3" disabled
                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ $teamMembers }}
                                    </textarea>
                            </div>
                            <div class="col-span-2">
                                <label for="members"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Panelists</label>
                                <textarea id="members" rows="3" disabled
                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ $panelists }}
                                    </textarea>
                            </div>

                            <div class="col-span-2">
                                <label for="venue"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Venue</label>

                                <select id="venue" wire:model.live="venue"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">Select option</option>
                                    @foreach ($venues as $venue)
                                        <option value="{{ $venue->id }}">{{ $venue->name }}</option>
                                    @endforeach
                                </select>

                                <x-input-error :messages="$errors->get('venue')" class="mt-2" />
                            </div>

                            <div class="col-span-2">
                                <label for="start"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date/Time</label>
                                <input type="datetime-local" wire:model="start" id="start"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">

                                <x-input-error :messages="$errors->get('start')" class="mt-2" />
                            </div>

                        @endif

                    </div>
                    <x-save-update-button methodName="store">Add new schedule</x-save-update-button>
                    <div wire:loading wire:target="store">
                        Loading...please wait.
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Update modal -->
    <div id="edit-modal" tabindex="-1" aria-hidden="true" wire:ignore.self
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Update Schedule
                    </h3>
                    <button type="button" wire:click="clear"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-toggle="edit-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form class="p-4 md:p-5">
                    <div class="grid gap-4 mb-4 grid-cols-2">

                        <div class="col-span-2">
                            <label for="team"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select
                                Team</label>

                            <select id="team" wire:model.live="team" wire:change="getTeamInfo"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="">Select option</option>
                                @foreach ($teams as $team)
                                    <option value="{{ $team->id }}">{{ $team->name }}
                                        {{ $team->schedule != null ? '(Scheduled on ' . \Carbon\Carbon::parse($team->schedule->start)->format('F j, Y @ h:i A') . ')' : '' }}
                                    </option>
                                @endforeach
                            </select>

                            <x-input-error :messages="$errors->get('team')" class="mt-2" />
                        </div>

                        @if ($team !== '')
                            <div class="col-span-2">
                                <label for="team"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Thesis
                                    Title</label>
                                <input type="text" value="{{ $thesisTitle }}" disabled
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            </div>
                            <div class="col-span-2">
                                <label for="members"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Members</label>
                                <textarea id="members" rows="3" disabled
                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ $teamMembers }}
                                    </textarea>
                            </div>
                            <div class="col-span-2">
                                <label for="members"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Panelists</label>
                                <textarea id="members" rows="3" disabled
                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ $panelists }}
                                    </textarea>
                            </div>

                            <div class="col-span-2">
                                <label for="venue"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Venue</label>

                                <select id="venue" wire:model.live="venue"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">Select option</option>
                                    @foreach ($venues as $venue)
                                        <option value="{{ $venue->id }}">{{ $venue->name }}</option>
                                    @endforeach
                                </select>

                                <x-input-error :messages="$errors->get('venue')" class="mt-2" />
                            </div>

                            <div class="col-span-2">
                                <label for="start"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date/Time</label>
                                <input type="datetime-local" wire:model="start" id="start"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">

                                <x-input-error :messages="$errors->get('start')" class="mt-2" />
                            </div>

                            <div class="col-span-2">
                                <label for="type"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Type</label>

                                <select id="type" wire:model.live="type"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">Select option</option>
                                    @foreach (\App\Models\Schedule::DEFENSE_STATUS as $key => $type)
                                        <option value="{{ $key }}">{{ $type }}</option>
                                    @endforeach
                                </select>

                                <x-input-error :messages="$errors->get('type')" class="mt-2" />
                            </div>
                        @endif

                    </div>
                    <x-save-update-button methodName="update">Update schedule</x-save-update-button>
                    <div wire:loading wire:target="update">
                        Loading...please wait.
                    </div>
                </form>
            </div>
        </div>
    </div>

    @can('student.update')
        <!-- Re-schedule or Re-defense modal -->
        <div id="redefense-or-reschedule-modal" tabindex="-1" aria-hidden="true" wire:ignore.self
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Re-defense or Re-schedule
                        </h3>
                        <button type="button" wire:click="clear"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-toggle="redefense-or-reschedule-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <form class="p-4 md:p-5">
                        <div class="grid gap-4 mb-4 grid-cols-2">

                            <div class="col-span-2">
                                <label for="scheduleType"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Type</label>

                                <select id="scheduleType" wire:model.live="scheduleType"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">Select option</option>
                                    <option value="{{ \App\Models\Schedule::RE_DEFENSE }}">
                                        {{ \App\Models\Schedule::STATUS[4] }}</option>
                                    <option value="{{ \App\Models\Schedule::RE_SCHEDULE }}">
                                        {{ \App\Models\Schedule::STATUS[6] }}</option>
                                </select>

                                <x-input-error :messages="$errors->get('scheduleType')" class="mt-2" />
                            </div>

                            <div class="col-span-2">
                                <label for="team"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Thesis
                                    Title</label>
                                <input type="text" value="{{ $thesisTitle }}" disabled
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            </div>

                            <div class="col-span-2">
                                <label for="team"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Team Name</label>

                                <select id="team" wire:model.live="team" wire:change="getTeamInfo"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">Select option</option>
                                    @foreach ($teams as $team)
                                        <option value="{{ $team->id }}">{{ $team->name }}
                                        </option>
                                    @endforeach
                                </select>

                                <x-input-error :messages="$errors->get('team')" class="mt-2" />
                            </div>

                            <div class="col-span-2">
                                <label for="start"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date/Time</label>
                                <input type="datetime-local" wire:model="start" id="start"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">

                                <x-input-error :messages="$errors->get('start')" class="mt-2" />
                            </div>

                            <div class="col-span-2">
                                <label for="type"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Type</label>

                                <select id="type" wire:model.live="type"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">Select option</option>
                                    @foreach (\App\Models\Schedule::DEFENSE_STATUS as $key => $type)
                                        <option value="{{ $key }}">{{ $type }}</option>
                                    @endforeach
                                </select>

                                <x-input-error :messages="$errors->get('type')" class="mt-2" />
                            </div>

                        </div>
                        <x-save-update-button methodName="reScheduleOrReDefense">Submit for approval</x-save-update-button>
                        <div wire:loading wire:target="reScheduleOrReDefense">
                            Loading...please wait.
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan()
</div>
