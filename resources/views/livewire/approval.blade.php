<div>
    <!-- Card header -->
    <div class="items-center justify-between lg:flex">
        <div class="mb-4 lg:mb-0">
            <h1 class="mb-2 text-2xl font-bold text-gray-900 dark:text-white">Approvals</h1>
            <span class="text-base font-normal text-gray-500 dark:text-gray-400">View and manage thesis defense approval
                schedules
                schedules</span>
        </div>
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
                                    Type
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">

                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800">
                            @forelse ($pendingSchedules as $schedule)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="p-4 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <button data-modal-target="approval-modal" data-modal-toggle="approval-modal"
                                            wire:click="showApprovalModal('{{ $schedule->id }}')"
                                            class="font-normal text-blue-600 dark:text-blue-500 hover:underline">{{ $schedule->team->thesis_title }}</button>
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
                                        {{ $schedule::DEFENSE_STATUS[$schedule->type_of_defense] }}
                                    </td>
                                    <td
                                        class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">

                                        @if ($schedule->user_id == auth()->user()->id)
                                            <button id="dropdownMenuIconButton{{ $loop->index }}"
                                                data-dropdown-toggle="dropdownDots{{ $loop->index }}"
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
                                            <div id="dropdownDots{{ $loop->index }}"
                                                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                                    aria-labelledby="dropdownMenuIconButton{{ $loop->index }}">
                                                    <li>
                                                        <a href="#" wire:click="edit('{{ $schedule->id }}')"
                                                            data-modal-target="edit-modal"
                                                            data-modal-toggle="edit-modal"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
                                                    </li>
                                                    <li>
                                                        <a href="#" wire:click="destroy('{{ $schedule->id }}')"
                                                            wire:confirm="You are about to delete scheduled defense. Continue?"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        @endif
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
    {{ $pendingSchedules->links() }}

    <!-- Approval modal -->
    <div id="approval-modal" tabindex="-1" aria-hidden="true" data-modal-backdrop="static" wire:ignore.self
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        {{ $thesisTitle }}
                    </h3>
                    <button type="button" wire:click="clear"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="approval-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4">

                    <dl class="max-w-md text-gray-900 divide-y divide-gray-200 dark:text-white dark:divide-gray-700">
                        <div class="flex flex-col pb-3">
                            <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Team name</dt>
                            <dd class="text-lg font-semibold">{{ $teamName }}</dd>
                        </div>
                        <div class="flex flex-col py-3">
                            <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Members</dt>
                            <dd class="text-lg font-semibold">{!! $teamMembers !!}</dd>
                        </div>
                        <div class="flex flex-col pt-3">
                            <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Panelist</dt>
                            <dd class="text-lg font-semibold">{!! $panelists !!}</dd>
                        </div>
                        <div class="flex flex-col pt-3">
                            <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">When</dt>
                            <dd class="text-lg font-semibold">{{ $start }}</dd>
                        </div>
                        <div class="flex flex-col pt-3">
                            <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Venue name</dt>
                            <dd class="text-lg font-semibold">{{ $venue }}</dd>
                        </div>
                        <div class="flex flex-col pt-3">
                            <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Type</dt>
                            <dd class="text-lg font-semibold">{{ $type }}</dd>
                        </div>
                        {{-- <div class="flex flex-col pt-3">
                            <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Remarks (optional)</dt>
                            <dd class="text-lg font-semibold">
                                <textarea id="message" rows="4" wire:model="remarks"
                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Remarks..."></textarea>
                            </dd>
                        </div> --}}
                    </dl>

                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <x-save-update-button methodName="approve" wire:confirm="You are about to approve a defense schedule. Continue?">Approve</x-save-update-button>
                    <x-save-update-button methodName="decline" wire:confirm="You are about to decline a defense schedule. Continue?" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Decline</x-save-update-button>
                    <div wire:loading wire:target="approve">
                        Loading...please wait.
                    </div>
                    <div wire:loading wire:target="decline">
                        Loading...please wait.
                    </div>
                    {{-- <button data-modal-hide="approval-modal" type="button"
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Decline</button>
                        --}}
                </div>
            </div>
        </div>
    </div>

</div>
