<div>
    <!-- Card header -->
    <div class="items-center justify-between lg:flex">
        <div class="mb-4 lg:mb-0">
            <a href="{{ route('schedules.index') }}"
                class="mb-4 inline-flex items-center font-medium text-blue-600 dark:text-blue-500 hover:underline">
                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 12h14M5 12l4-4m-4 4 4 4" />
                </svg>
                Back
            </a>
            <h1 class="mb-2 text-2xl font-bold text-gray-900 dark:text-white">
                {{ $schedule->team->thesis_title }}
            </h1>
            <span class="text-base font-normal text-gray-500 dark:text-gray-400">{{ $schedule->team->name }}</span>
        </div>
    </div>

    <div class="mt-6 mb-4 border-b border-gray-200 dark:border-gray-700" wire:ignore>
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-styled-tab"
            data-tabs-toggle="#default-styled-tab-content"
            data-tabs-active-classes="text-purple-600 hover:text-purple-600 dark:text-purple-500 dark:hover:text-purple-500 border-purple-600 dark:border-purple-500"
            data-tabs-inactive-classes="dark:border-transparent text-gray-500 hover:text-gray-600 dark:text-gray-400 border-gray-100 hover:border-gray-300 dark:border-gray-700 dark:hover:text-gray-300"
            role="tablist">
            <li class="me-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg" id="details-styled-tab"
                    data-tabs-target="#styled-details" type="button" role="tab" aria-controls="details"
                    aria-selected="{{ $isDetailsTabSelected }}">Details</button>
            </li>
            <li class="me-2" role="presentation">
                <button
                    class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                    id="rsc-styled-tab" data-tabs-target="#styled-rsc" type="button" role="tab" aria-controls="rsc"
                    aria-selected="{{ $isRSCTabSelected }}">RSC</button>
            </li>
            <li class="me-2" role="presentation">
                <button
                    class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                    id="manuscript-styled-tab" data-tabs-target="#styled-manuscript" type="button" role="tab"
                    aria-controls="manuscript" aria-selected="{{ $isManuscriptTabSelected }}">Manuscript</button>
            </li>

        </ul>
    </div>
    <div id="default-styled-tab-content" wire:ignore>
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="styled-details" role="tabpanel"
            aria-labelledby="details-tab">

            <dl class="max-w-md text-gray-900 divide-y divide-gray-200 dark:text-white dark:divide-gray-700">
                <div class="flex flex-col pb-3">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Venue</dt>
                    <dd class="text-lg font-semibold">{{ $schedule->venue->name }}</dd>
                </div>
                <div class="flex flex-col py-3">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Start</dt>
                    <dd class="text-lg font-semibold">
                        {{ \Carbon\Carbon::parse($schedule->start)->format('F j, Y @ g:i:s A') }}</dd>
                </div>
                <div class="flex flex-col pt-3">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Status</dt>
                    <dd class="text-lg font-semibold">

                        <x-status
                            statusCode="{{ $schedule->status }}">{{ $schedule::STATUS[$schedule->status] }}</x-status>
                </div>
                <div class="flex flex-col py-3">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Members</dt>
                    <dd class="text-lg font-semibold">
                        @foreach ($schedule->team->members as $member)
                            {{ $member?->name }}@if (!$loop->last)
                                ,
                            @endif
                        @endforeach
                    </dd>
                </div>
                <div class="flex flex-col py-3">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Panelists</dt>
                    <dd class="text-lg font-semibold">
                        @foreach ($schedule->team->panelists as $panelist)
                            {{ $panelist?->name }}@if (!$loop->last)
                                ,
                            @endif
                        @endforeach
                    </dd>
                </div>
                <div class="flex flex-col py-3">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Type of defense</dt>
                    <dd class="text-lg font-semibold">
                        {{ $schedule::DEFENSE_STATUS[$schedule->type_of_defense] }}</dd>
                </div>
                <div class="flex flex-col py-3">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Appovals</dt>
                    <dd class="text-lg font-semibold">
                        <ol
                            class="ml-3 mt-2 relative text-gray-500 border-s border-gray-200 dark:border-gray-700 dark:text-gray-400">

                            @php
                                $approvalStatus = $schedule->team->approvalStatus->sortByDesc('status');
                                $approvedCount = 0;
                            @endphp
                            @foreach ($approvalStatus as $approvalStatus)
                                <li class="mb-10 ms-6">
                                    @if ($approvalStatus->status == \App\Models\Schedule::APPROVED)
                                        @php
                                            $approvedCount += 1;
                                        @endphp
                                        <span
                                            class="absolute flex items-center justify-center w-8 h-8 bg-green-200 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-green-900">
                                            <svg class="w-3.5 h-3.5 text-green-500 dark:text-green-400"
                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 16 12">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M1 5.917 5.724 10.5 15 1.5" />
                                            </svg>
                                        </span>
                                    @else
                                        <span
                                            class="absolute flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-gray-700">
                                            <svg class="w-6 h-6 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd"
                                                    d="M12 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4h-4Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                    @endif
                                    <h3 class="font-medium leading-tight">{{ $approvalStatus->user->name }}</h3>
                                    <p class="text-sm">{{ \App\Models\Schedule::STATUS[$approvalStatus->status] }}</p>
                                </li>
                            @endforeach
                            <li class="ms-6">
                                @if ($approvalStatus->count() == $approvedCount)
                                    <span
                                        class="absolute flex items-center justify-center w-8 h-8 bg-green-100 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-gray-700">
                                        <svg class="w-3.5 h-3.5 text-green-500 dark:text-green-400" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                            viewBox="0 0 18 20">
                                            <path
                                                d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2ZM7 2h4v3H7V2Zm5.7 8.289-3.975 3.857a1 1 0 0 1-1.393 0L5.3 12.182a1.002 1.002 0 1 1 1.4-1.436l1.328 1.289 3.28-3.181a1 1 0 1 1 1.392 1.435Z" />
                                        </svg>
                                    </span>
                                @else
                                    <span
                                        class="absolute flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-gray-700">
                                        <svg class="w-3.5 h-3.5 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                            viewBox="0 0 18 20">
                                            <path
                                                d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2ZM7 2h4v3H7V2Zm5.7 8.289-3.975 3.857a1 1 0 0 1-1.393 0L5.3 12.182a1.002 1.002 0 1 1 1.4-1.436l1.328 1.289 3.28-3.181a1 1 0 1 1 1.392 1.435Z" />
                                        </svg>
                                    </span>
                                @endif
                                <h3 class="font-medium leading-tight">Confirmation</h3>
                                <p class="text-sm">All panelist have approved</p>
                            </li>
                        </ol>
                    </dd>
                </div>
            </dl>

        </div>
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="styled-rsc" role="tabpanel"
            aria-labelledby="rsc-tab">
            @can('secretary.create')
                <x-primary-button data-modal-target="add-rsc-modal" data-modal-toggle="add-rsc-modal">
                    Upload RSC
                </x-primary-button>
            @endcan
            @can('admin.create')
                <x-primary-button data-modal-target="admin-add-rsc-modal" data-modal-toggle="admin-add-rsc-modal">
                    Upload RSC
                </x-primary-button>
            @endcan
            <div class="flex flex-col">
                <div class="overflow-x-auto rounded-lg">
                    <div class="inline-block min-w-full align-middle">
                        <div class="overflow-hidden shadow sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col"
                                            class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                            #
                                        </th>
                                        <th scope="col"
                                            class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                            File name
                                        </th>
                                        <th scope="col"
                                            class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                            Uploaded by
                                        </th>
                                        <th scope="col"
                                            class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                            Uploaded on
                                        </th>
                                        <th scope="col">&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800">
                                    @forelse ($rscs as $rsc)
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <td
                                                class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                                {{ $loop->index + 1 }}
                                            </td>
                                            <td
                                                class="p-4 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">

                                                <form action="{{ route('rsc.show', $rsc) }}" method="post"
                                                    target="_blank">
                                                    @csrf
                                                    <button type="submit"
                                                        class="font-normal text-blue-600 dark:text-blue-500 hover:underline">RSC
                                                        ({{ $rsc::TYPE[$rsc->comment_for] }})
                                                        #{{ $loop->index + 1 }}</button>
                                                </form>
                                            </td>
                                            <td
                                                class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                                {{ $rsc->uploader->name }}
                                            </td>
                                            <td
                                                class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                                {{ \Carbon\Carbon::parse($rsc->created_at)->format('F j, Y g:i:s A') }}
                                            </td>
                                            <td>
                                                @if (!$rsc->is_admin)
                                                    <button id="dropdownMenuIconButton-{{ $loop->index }}"
                                                        data-dropdown-toggle="dropdownDots-{{ $loop->index }}"
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
                                                    <div id="dropdownDots-{{ $loop->index }}"
                                                        class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                                                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                                            aria-labelledby="dropdownMenuIconButton-{{ $loop->index }}">
                                                            @canany(['secretary.read', 'panelist.read'])
                                                                <li>
                                                                    <a href="#" data-modal-target="edit-rsc-modal"
                                                                        data-modal-toggle="edit-rsc-modal"
                                                                        wire:click="editRsc({{ $rsc->id }})"
                                                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
                                                                </li>
                                                            @endcan
                                                            @can('secretary.read')
                                                                <li>
                                                                    <a href="#"
                                                                        wire:confirm="You are about to delete RSC. Continue?"
                                                                        wire:click="deleteRsc({{ $rsc->id }})"
                                                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Delete</a>
                                                                </li>
                                                            @endcan
                                                            @can('student.read')
                                                                <li>
                                                                    <a href="#"
                                                                        wire:click="editRsc({{ $rsc->id }})"
                                                                        data-modal-target="student-view-rsc-modal"
                                                                        data-modal-toggle="student-view-rsc-modal"
                                                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">View
                                                                        details</a>
                                                                </li>
                                                            @endcan
                                                        </ul>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white"
                                                colspan="4">
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
        </div>
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="styled-manuscript" role="tabpanel"
            aria-labelledby="manuscript-tab">
            @canany(['student.create', 'admin.create', 'panelist.create'])
                <x-primary-button data-modal-target="add-manuscript-modal" data-modal-toggle="add-manuscript-modal">
                    Upload manuscript
                </x-primary-button>
            @endcanany
            <div class="flex flex-col">
                <div class="overflow-x-auto rounded-lg">
                    <div class="inline-block min-w-full align-middle">
                        <div class="overflow-hidden shadow sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col"
                                            class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                            #
                                        </th>
                                        <th scope="col"
                                            class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                            File name
                                        </th>
                                        <th scope="col"
                                            class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                            Uploaded by
                                        </th>
                                        <th scope="col"
                                            class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                            Uploaded on
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800">
                                    @forelse ($manuscripts as $manuscript)
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <td
                                                class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                                {{ $loop->index + 1 }}
                                            </td>
                                            <td
                                                class="p-4 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">

                                                <form action="{{ route('manuscript.show', $manuscript->id) }}"
                                                    method="post" target="_blank">
                                                    @csrf
                                                    <button type="submit"
                                                        class="font-normal text-blue-600 dark:text-blue-500 hover:underline">{{ $manuscript->file_name }}</button>
                                                </form>
                                            </td>
                                            <td
                                                class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                                {{ $manuscript->uploader->name }}
                                            </td>
                                            <td
                                                class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                                {{ \Carbon\Carbon::parse($manuscript->created_at)->format('F j, Y g:i:s A') }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white"
                                                colspan="4">
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
        </div>
    </div>

    @can('secretary.create')
        <!-- Upload RSC modal -->
        <div id="add-rsc-modal" tabindex="-1" aria-hidden="true" wire:ignore.self
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-7xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Upload RSC
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-toggle="add-rsc-modal">
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
                        <div class="grid gap-4 mb-6 grid-cols-2">
                            <div>

                                <label for="typeOfDefense"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Type of
                                    Defense*</label>
                                <select id="typeOfDefense" wire:model="typeOfDefense"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">Select option</option>
                                    @foreach (\App\Models\Schedule::DEFENSE_STATUS as $typeOfDefenseKey => $typeOfDefense)
                                        <option value="{{ $typeOfDefenseKey }}"
                                            {{ $schedule->type_of_defense == $typeOfDefenseKey ? 'selected' : '' }}>
                                            {{ $typeOfDefense }}</option>
                                    @endforeach
                                </select>

                                <x-input-error :messages="$errors->get('typeOfDefense')" class="mt-2" />
                            </div>

                            <div>

                                <label for="commentFor"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Comment
                                    for*</label>
                                <select id="commentFor" wire:model="commentFor"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">Select option</option>
                                    @foreach (\App\Models\Rsc::TYPE as $typeKey => $type)
                                        <option value="{{ $typeKey }}">{{ $type }}</option>
                                    @endforeach
                                </select>

                                <x-input-error :messages="$errors->get('commentFor')" class="mt-2" />
                            </div>

                        </div>

                        <div class="grid gap-4 mb-4 grid-cols-3">
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Chapter</label>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Page
                                    No.</label>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Comments
                                    (RSC)*</label>
                            </div>
                            @foreach ($comments as $commentKey => $comment)
                                <div>
                                    <input type="text" id="comments.{{ $commentKey }}.chapter"
                                        wire:model="comments.{{ $commentKey }}.chapter"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                                    @if ($commentKey > 0)
                                        <button type="button" class="text-sm text-red-600"
                                            wire:click="removeComment({{ $commentKey }})">remove</button>
                                    @endif

                                    <x-input-error :messages="$errors->get('comments.' . $commentKey . '.chapter')" class="mt-2" />
                                </div>
                                <div>
                                    <input type="text" id="comments.{{ $commentKey }}.pageNumber"
                                        wire:model="comments.{{ $commentKey }}.pageNumber"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                                    <x-input-error :messages="$errors->get('comments.' . $commentKey . '.pageNumber')" class="mt-2" />
                                </div>
                                <div>
                                    <textarea id="comments.{{ $commentKey }}.comments" rows="3"
                                        wire:model="comments.{{ $commentKey }}.comments"
                                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
                                    <x-input-error :messages="$errors->get('comments.' . $commentKey . '.comments')" class="mt-2" />
                                </div>
                            @endforeach

                        </div>

                        <div class="mb-2">
                            <button type="button" wire:click="addComment"
                                class="px-3 py-2 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">add
                                new comment</button>
                        </div>



                        <x-save-update-button methodName="uploadRsc" wire:loading.attr="disabled" class="mt-6">Upload
                            RSC</x-save-update-button>
                        <!-- Loading Indicator -->
                        <div wire:loading wire:target="uploadRsc,saveDraft">
                            Loading...please wait.
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan

    @can('student.read')
        <!-- Student view RSC modal -->
        <div id="student-view-rsc-modal" tabindex="-1" aria-hidden="true" wire:ignore.self
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-7xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            View RSC details
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-toggle="student-view-rsc-modal">
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
                        <div class="grid gap-4 mb-6 grid-cols-2">
                            <div>

                                <label for="typeOfDefense"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Type of
                                    Defense</label>
                                <select id="typeOfDefense" wire:model="typeOfDefense" disabled
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">Select option</option>
                                    @foreach (\App\Models\Schedule::DEFENSE_STATUS as $typeOfDefenseKey => $typeOfDefense)
                                        <option value="{{ $typeOfDefenseKey }}"
                                            {{ $schedule->type_of_defense == $typeOfDefenseKey ? 'selected' : '' }}>
                                            {{ $typeOfDefense }}</option>
                                    @endforeach
                                </select>

                                <x-input-error :messages="$errors->get('typeOfDefense')" class="mt-2" />
                            </div>

                            <div>

                                <label for="commentFor"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Comment
                                    for</label>
                                <select id="commentFor" wire:model="commentFor" disabled
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">Select option</option>
                                    @foreach (\App\Models\Rsc::TYPE as $typeKey => $type)
                                        <option value="{{ $typeKey }}">{{ $type }}</option>
                                    @endforeach
                                </select>

                                <x-input-error :messages="$errors->get('commentFor')" class="mt-2" />
                            </div>

                        </div>

                        <div class="grid gap-4 mb-4 grid-cols-4">
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Chapter</label>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Page
                                    No.</label>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Comments
                                    (RSC)</label>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Action
                                    taken</label>
                            </div>
                            @foreach ($comments as $commentKey => $comment)
                                <div>
                                    <input type="text" id="comments.{{ $commentKey }}.chapter" disabled read-only
                                        wire:model="comments.{{ $commentKey }}.chapter"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />

                                    <x-input-error :messages="$errors->get('comments.' . $commentKey . '.chapter')" class="mt-2" />
                                </div>
                                <div>
                                    <input type="text" id="comments.{{ $commentKey }}.pageNumber" disabled read-only
                                        wire:model="comments.{{ $commentKey }}.pageNumber"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                                    <x-input-error :messages="$errors->get('comments.' . $commentKey . '.pageNumber')" class="mt-2" />
                                </div>
                                <div>
                                    <textarea id="comments.{{ $commentKey }}.comments" rows="3" disabled read-only
                                        wire:model="comments.{{ $commentKey }}.comments"
                                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
                                    <x-input-error :messages="$errors->get('comments.' . $commentKey . '.comments')" class="mt-2" />
                                </div>
                                <div>
                                    <textarea id="comments.{{ $commentKey }}.action_taken" rows="3"
                                        wire:model="comments.{{ $commentKey }}.action_taken"
                                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
                                    <x-input-error :messages="$errors->get('comments.' . $commentKey . '.action_taken')" class="mt-2" />
                                </div>
                            @endforeach

                        </div>

                        <x-save-update-button methodName="studentUpdateActionTaken" wire:loading.attr="disabled"
                            class="mt-6">Save changes</x-save-update-button>
                        <!-- Loading Indicator -->
                        <div wire:loading wire:target="studentUpdateActionTaken,editRsc">
                            Loading...please wait.
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan

    <!-- Update RSC modal -->
    <div id="edit-rsc-modal" tabindex="-1" aria-hidden="true" wire:ignore.self
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-7xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Edit RSC
                    </h3>
                    <button type="button" wire:click="clear"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-toggle="edit-rsc-modal">
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
                    <div class="grid gap-4 mb-6 grid-cols-2">
                        <div>

                            <label for="typeOfDefense"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Type of
                                Defense*</label>
                            <select id="typeOfDefense" wire:model="typeOfDefense"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="">Select option</option>
                                @foreach (\App\Models\Schedule::DEFENSE_STATUS as $typeOfDefenseKey => $typeOfDefense)
                                    <option value="{{ $typeOfDefenseKey }}"
                                        {{ $schedule->type_of_defense == $typeOfDefenseKey ? 'selected' : '' }}>
                                        {{ $typeOfDefense }}</option>
                                @endforeach
                            </select>

                            <x-input-error :messages="$errors->get('typeOfDefense')" class="mt-2" />
                        </div>

                        <div>

                            <label for="commentFor"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Comment
                                for*</label>
                            <select id="commentFor" wire:model="commentFor"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="">Select option</option>
                                @foreach (\App\Models\Rsc::TYPE as $typeKey => $type)
                                    <option value="{{ $typeKey }}">{{ $type }}</option>
                                @endforeach
                            </select>

                            <x-input-error :messages="$errors->get('commentFor')" class="mt-2" />
                        </div>

                    </div>

                    <div class="grid gap-4 mb-4 grid-cols-3">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Chapter</label>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Page
                                No.</label>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Comments
                                (RSC)*</label>
                        </div>
                        @foreach ($comments as $commentKey => $comment)
                            <div>
                                <input type="text" id="comments.{{ $commentKey }}.chapter"
                                    wire:model="comments.{{ $commentKey }}.chapter"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                                @if ($commentKey > 0)
                                    <button type="button" class="text-sm text-red-600"
                                        wire:confirm="Delete comment?"
                                        wire:click="removeComment({{ $commentKey }})">remove</button>
                                @endif

                                <x-input-error :messages="$errors->get('comments.' . $commentKey . '.chapter')" class="mt-2" />
                            </div>
                            <div>
                                <input type="text" id="comments.{{ $commentKey }}.pageNumber"
                                    wire:model="comments.{{ $commentKey }}.pageNumber"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                                <x-input-error :messages="$errors->get('comments.' . $commentKey . '.pageNumber')" class="mt-2" />
                            </div>
                            <div>
                                <textarea id="comments.{{ $commentKey }}.comments" rows="3"
                                    wire:model="comments.{{ $commentKey }}.comments"
                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
                                <x-input-error :messages="$errors->get('comments.' . $commentKey . '.comments')" class="mt-2" />
                            </div>
                        @endforeach

                    </div>

                    <div class="mb-2">
                        <button type="button" wire:click="addComment"
                            class="px-3 py-2 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">add
                            new comment</button>
                    </div>



                    <x-save-update-button methodName="updateRsc" wire:loading.attr="disabled" class="mt-6">Upload
                        RSC</x-save-update-button>
                    <!-- Loading Indicator -->
                    <div wire:loading wire:target="updateRsc,editRsc">
                        Loading...please wait.
                    </div>
                </form>
            </div>
        </div>
    </div>

    @can('admin.create')
        {{-- Admin can upload only RSC file --}}
        <div id="admin-add-rsc-modal" tabindex="-1" aria-hidden="true" wire:ignore.self
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Upload RSC
                        </h3>
                        <button type="button" wire:click="clear"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-toggle="admin-add-rsc-modal">
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
                        <div class="mb-4">
                            <input wire:model="rscForAdmin" type="file">
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">PDF, DOCX, DOC
                            </p>

                            <x-input-error :messages="$errors->get('rscForAdmin')" class="mt-2" />

                        </div>

                        <x-save-update-button methodName="uploadRSCForAdmin" wire:loading.attr="disabled">Upload
                            RSC</x-save-update-button>
                        <!-- Loading Indicator -->
                        <div wire:loading>
                            Loading...please wait.
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan

    @canany(['student.create', 'admin.create', 'panelist.create'])
        <!-- Upload manuscript modal -->
        <div id="add-manuscript-modal" tabindex="-1" aria-hidden="true" wire:ignore.self
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Upload manuscript
                        </h3>
                        <button type="button" wire:click="clear"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-toggle="add-manuscript-modal">
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
                        <div class="mb-4">
                            <input wire:model="manuscript" type="file">
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">PDF, DOCX, DOC
                            </p>

                            <x-input-error :messages="$errors->get('manuscript')" class="mt-2" />

                        </div>

                        <x-save-update-button methodName="uploadManuscript" wire:loading.attr="disabled">Upload
                            manuscript</x-save-update-button>
                        <!-- Loading Indicator -->
                        <div wire:loading>
                            Loading...please wait.
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcanany
</div>
