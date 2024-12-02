<div>
    <!-- Card header -->
    <div class="items-center justify-between lg:flex">
        <div class="mb-4 lg:mb-0">
            <h1 class="mb-2 text-2xl font-bold text-gray-900 dark:text-white">Teams and Titles</h1>
            <span class="text-base font-normal text-gray-500 dark:text-gray-400">Manage teams and thesis title</span>
        </div>
        @can('admin.create')
            <div class="items-center sm:flex">
                <div class="flex items-center">
                    <a href="{{ route('teams.and.titles.create') }}"
                        class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add
                        new team</a>
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
                                    Team Name
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                    Members
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                    Thesis Title
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                    Experts
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                    Panelist
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800">
                            @forelse ($teams as $team)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="p-4 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <a href="{{ route('teams.and.titles.edit', $team) }}"
                                            class="font-normal text-blue-600 dark:text-blue-500 hover:underline">{{ $team->name }}</a>
                                    </td>
                                    <td
                                        class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                        <div class="flex -space-x-4 rtl:space-x-reverse">
                                            @foreach ($team->members as $member)
                                                @if (!empty($member->avatar))
                                                    <img class="w-10 h-10 border-2 border-white rounded-full dark:border-gray-800"
                                                        src="{{ asset('avatar/' . $member->avatar) }}" alt="avatar">
                                                @else
                                                    <img class="w-10 h-10 border-2 border-white rounded-full dark:border-gray-800"
                                                        src="https://ui-avatars.com/api/?name={{ $member->name }}&rounded=true&background=random"
                                                        alt="{{ $member->name }}" title="{{ $member->name }}">
                                                @endif
                                            @endforeach
                                        </div>
                                    </td>

                                    <td
                                        class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                        {{ $team->thesis_title }}
                                    </td>

                                    <td
                                        class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                        <div class="flex -space-x-4 rtl:space-x-reverse">
                                            @if (!is_null($team->capa_id))
                                                <img class="w-10 h-10 border-2 border-white rounded-full dark:border-gray-800"
                                                    src="https://ui-avatars.com/api/?name={{ $team->capa->name }}&rounded=true&background=random"
                                                    alt="{{ $team->capa->name }}" title="{{ $team->capa->name }}">
                                            @endif
                                            @if (!is_null($team->consultant_id))
                                                <img class="w-10 h-10 border-2 border-white rounded-full dark:border-gray-800"
                                                    src="https://ui-avatars.com/api/?name={{ $team->consultant->name }}&rounded=true&background=random"
                                                    alt="{{ $team->consultant->name }}"
                                                    title="{{ $team->consultant->name }}">
                                            @endif
                                            @if (!is_null($team->grammarian_id))
                                                <img class="w-10 h-10 border-2 border-white rounded-full dark:border-gray-800"
                                                    src="https://ui-avatars.com/api/?name={{ $team->grammarian->name }}&rounded=true&background=random"
                                                    alt="{{ $team->grammarian->name }}"
                                                    title="{{ $team->grammarian->name }}">
                                            @endif
                                        </div>
                                    </td>
                                    <td
                                        class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                        <div class="flex -space-x-4 rtl:space-x-reverse">
                                            @foreach ($team->panelists as $panelist)
                                                @if (!empty($panelist->avatar))
                                                    <img class="w-10 h-10 border-2 border-white rounded-full dark:border-gray-800"
                                                        src="{{ asset('avatar/' . $panelist->avatar) }}"
                                                        alt="avatar">
                                                @else
                                                    <img class="w-10 h-10 border-2 border-white rounded-full dark:border-gray-800"
                                                        src="https://ui-avatars.com/api/?name={{ $panelist->name }}&rounded=true&background=random"
                                                        alt="{{ $panelist->name }}" title="{{ $panelist->name }}">
                                                @endif
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="pt-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white"
                                        colspan="3">
                                        @can('admin.create')
                                            <a href="{{ route('teams.and.titles.create') }}"
                                                class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add
                                                new team</a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{ $teams->links() }}

    @can('admin.create')
        <!-- Add modal -->
        <div id="add-modal" tabindex="-1" aria-hidden="true" wire:ignore.self
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Create New Team
                        </h3>
                        <button type="button" wire:click="clear"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-toggle="add-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <form class="p-4 md:p-5">
                        <div class="grid gap-4 mb-4 grid-cols-2">
                            <div class="col-span-2">
                                <label for="name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Team Name</label>
                                <input type="text" wire:model="name" id="name"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">

                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div class="col-span-2">
                                <label for="thesisTitle"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Thesis
                                    Title</label>
                                <input type="text" wire:model="thesisTitle" id="thesisTitle"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">

                                <x-input-error :messages="$errors->get('thesisTitle')" class="mt-2" />
                            </div>

                            <div class="col-span-2" wire:ignore>
                                <label for="courseAndSection"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Course - Year &
                                    Section</label>
                                <select wire:model="courseAndSection" wire:change="getMembers"
                                    style="width: 100%;height:50px;" id="courseAndSection">
                                    <option value=""></option>
                                    @foreach ($courses as $course)
                                        <optgroup label="{{ $course->name }}">
                                            @foreach ($course->sections as $section)
                                                <option value="{{ $section->id }}">{{ $course->code }} -
                                                    {{ $section->name }}</option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach

                                </select>

                                <x-input-error :messages="$errors->get('courseAndSection')" class="mt-2" />
                            </div>


                            <div class="col-span-2" wire:ignore>
                                <label for="members"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Members</label>
                                <select wire:model.live="members" style="width: 100%;height:50px;" id="members">
                                    <option value=""></option>
                                    @foreach ($members as $member)
                                        <option value="{{ $section['id'] }}">{{ $member['name'] }}</option>
                                    @endforeach

                                </select>

                                <x-input-error :messages="$errors->get('members')" class="mt-2" />

                            </div>


                            {{-- <div class="col-span-2">
                                <label for="panelists"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Panelists</label>

                                @foreach ($panelists as $panelistKey => $panelist)
                                    <div class="flex item-center mt-2">
                                        <select id="panelists.{{ $panelistKey }}"
                                            wire:model="panelists.{{ $panelistKey }}"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                            <option value="">Select panelist</option>
                                            @if ($loop->first)
                                                @foreach ($panelistChairUsers as $panelistChair)
                                                    <option value="{{ $panelistChair->id }}">{{ $panelistChair->name }}
                                                    </option>
                                                @endforeach
                                            @else
                                                @foreach ($panelistMemberUsers as $panelistMember)
                                                    <option value="{{ $panelistMember->id }}">{{ $panelistMember->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <button type="button" title="Remove panelist"
                                            wire:click="removePanelist('{{ $panelistKey }}')"
                                            wire:confirm="Remove panelist?">
                                            <svg style="cursor: pointer;" class="w-8 h-8 text-red-800 dark:text-white"
                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd"
                                                    d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                    <x-input-error :messages="$errors->get('panelists.' . $panelistKey)" />
                                    @if ($panelistKey === 0)
                                        <div class="flex items-center">
                                            <input disabled checked id="disabled-checked-checkbox" type="checkbox"
                                                value=""
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="disabled-checked-checkbox"
                                                class="ms-2 text-xs font-medium text-gray-400 dark:text-gray-500">Default
                                                panel
                                                chairman
                                            </label>
                                        </div>
                                    @endif
                                @endforeach
                                @if (count($panelists) < 3)
                                    <button type="button" wire:click='addPanelist'
                                        class="mt-2 px-3 py-2 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">add
                                        panelist</button>
                                @endif
                            </div> --}}


                        </div>
                        <x-save-update-button methodName="store" class="mt-5">Create new team</x-save-update-button>
                        <div wire:loading wire:target="store">
                            Loading...please wait.
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit modal -->
        <div id="edit-modal" tabindex="-1" aria-hidden="true" data-modal-backdrop="static" wire:ignore.self
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Edit Team
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
                                <label for="name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Team Name</label>
                                <input type="text" wire:model="name" id="name"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">

                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div class="col-span-2">
                                <label for="thesisTitle"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Thesis
                                    Title</label>
                                <input type="text" wire:model="thesisTitle" id="thesisTitle"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">

                                <x-input-error :messages="$errors->get('thesisTitle')" class="mt-2" />
                            </div>

                            <div class="col-span-2">
                                <label for="members"
                                    class="block text-sm font-medium text-gray-900 dark:text-white">Members</label>

                                @foreach ($members as $memberKey => $member)
                                    <div class="flex item-center mt-2">
                                        <select id="members.{{ $memberKey }}"
                                            wire:model.live="members.{{ $memberKey }}"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                            <option value="">Select member</option>
                                            @foreach ($studentUsers as $courseName => $students)
                                                <optgroup label="{{ $courseName }}">
                                                    @foreach ($students as $student)
                                                        <option value="{{ $student->id }}">{{ $student->name }} -
                                                            {{ $student->section->name }}
                                                        </option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                        <button type="button" title="Remove member"
                                            wire:click="removeMember('{{ $memberKey }}')"
                                            wire:confirm="Remove member?">
                                            <svg style="cursor: pointer;" class="w-8 h-8 text-red-800 dark:text-white"
                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd"
                                                    d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                    <x-input-error :messages="$errors->get('members.' . $memberKey)" />
                                @endforeach
                                <button type="button" wire:click='addMember'
                                    class="mt-2 px-3 py-2 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">add
                                    member</button>
                            </div>

                            <div class="col-span-2">
                                <label for="panelists"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Panelists</label>

                                @foreach ($panelists as $panelistKey => $panelist)
                                    <div class="flex item-center mt-2">
                                        <select id="panelists.{{ $panelistKey }}"
                                            wire:model="panelists.{{ $panelistKey }}"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                            <option value="">Select panelist</option>
                                            @if ($loop->first)
                                                @foreach ($panelistChairUsers as $panelistChair)
                                                    <option value="{{ $panelistChair->id }}">{{ $panelistChair->name }}
                                                    </option>
                                                @endforeach
                                            @else
                                                @foreach ($panelistMemberUsers as $panelistMember)
                                                    <option value="{{ $panelistMember->id }}">{{ $panelistMember->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <button type="button" title="Remove panelist"
                                            wire:click="removePanelist('{{ $panelistKey }}')"
                                            wire:confirm="Remove panelist?">
                                            <svg style="cursor: pointer;" class="w-8 h-8 text-red-800 dark:text-white"
                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd"
                                                    d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                    <x-input-error :messages="$errors->get('panelists.' . $panelistKey)" />
                                    @if ($panelistKey === 0)
                                        <div class="flex items-center">
                                            <input disabled checked id="disabled-checked-checkbox" type="checkbox"
                                                value=""
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="disabled-checked-checkbox"
                                                class="ms-2 text-xs font-medium text-gray-400 dark:text-gray-500">Default
                                                panel
                                                chairman
                                            </label>
                                        </div>
                                    @endif
                                @endforeach
                                @if (count($panelists) < 3)
                                    <button type="button" wire:click='addPanelist'
                                        class="mt-2 px-3 py-2 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">add
                                        panelist</button>
                                @endif
                            </div>

                        </div>
                        <x-save-update-button methodName="update">Update</x-save-update-button>

                        {{-- <x-delete-button wire:click="destroy('{{ $id }}')"
                            wire:confirm="You are about to delete team {{ $name }}. Continue?">Delete
                            team</x-delete-button> --}}
                        <div wire:loading wire:target="update">
                            Loading...please wait.
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan
</div>
