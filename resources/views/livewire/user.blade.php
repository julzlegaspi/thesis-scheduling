<div>
    <!-- Card header -->
    <div class="items-center justify-between lg:flex">
        <div class="mb-4 lg:mb-0">
            <h1 class="mb-2 text-2xl font-bold text-gray-900 dark:text-white">Users</h1>
            <span class="text-base font-normal text-gray-500 dark:text-gray-400">Manage users</span>
        </div>
        <div class="items-center sm:flex">
            <div class="flex items-center">
                <x-primary-button data-popover-target="popover-bottom" data-popover-placement="bottom"
                    data-modal-target="import-user-modal" data-modal-toggle="import-user-modal">
                    Upload from CSV
                </x-primary-button>
                <div data-popover id="popover-bottom" role="tooltip"
                    class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                    <div
                        class="px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700">
                        <h3 class="font-semibold text-gray-900 dark:text-white">Information</h3>
                    </div>
                    <div class="px-3 py-2">
                        <p>Only users specified in the CSV are allowed to register for this system.</p>
                    </div>
                    <div data-popper-arrow></div>
                </div>
                <x-primary-button data-modal-target="add-modal" data-modal-toggle="add-modal">
                    Add new user
                </x-primary-button>
            </div>
        </div>
    </div>
    <!-- Table -->
    <div class="flex flex-col mt-6">
        <div class="overflow-x-auto rounded-lg">
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden shadow sm:rounded-lg">
                    {{-- <input type="text" wire:model.live="search" placeholder="Search users..." class="block w-full px-3 py-2 mb-4 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" /> --}}
                    <div class="flex items-center space-x-2 mb-2">
                        <input type="text" wire:model.live="search" id="search" placeholder="Search users..."
                            wire:keyup="clearSorting"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">


                        <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown" title="Filter"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            type="button">
                            <svg class="w-6 h-6 text-white-800 dark:text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M5.05 3C3.291 3 2.352 5.024 3.51 6.317l5.422 6.059v4.874c0 .472.227.917.613 1.2l3.069 2.25c1.01.742 2.454.036 2.454-1.2v-7.124l5.422-6.059C21.647 5.024 20.708 3 18.95 3H5.05Z" />
                            </svg>
                        </button>

                        <!-- Dropdown menu -->
                        <div id="dropdown"
                            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                            <div class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                                <div>Filter</div>
                            </div>
                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                aria-labelledby="dropdownDefaultButton">
                                <li>
                                    <a href="#" wire:click="filterByAdminUsers"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">By
                                        Admin</a>
                                </li>
                                <li>
                                    <a href="#" wire:click="filterBySecretaryUsers"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">By
                                        Secretary</a>
                                </li>
                                <li>
                                    <a href="#" wire:click="filterByStudentUsers"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">By
                                        Students</a>
                                </li>
                                <li>
                                    <a href="#" data-modal-target="section-modal"
                                        data-modal-toggle="section-modal"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">By
                                        Section</a>
                                </li>
                                <li>
                                    <a href="#" data-modal-target="panelist-modal"
                                        data-modal-toggle="panelist-modal"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">By
                                        Panelist</a>
                                </li>
                                <li>
                                    <a href="#" data-modal-target="expert-modal" data-modal-toggle="expert-modal"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">By
                                        Experts</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div wire:loading
                        wire:target="filterByAdminUsers,sortBySection,sortByPanelist,filterBySecretaryUsers,filterByExpertUsers,filterByStudentUsers">
                        Loading...
                    </div>
                    @if (
                        $sortBySectionId != '' or
                            $panelistType != '' or
                            $filterByAdmin != false or
                            $filterBySecretary != false or
                            $expertType != '' or
                            $filterByStudent != false)
                        <span id="badge-dismiss-yellow" wire:click="clearSorting"
                            class="cursor-pointer inline-flex items-center px-2 py-1 me-2 mb-2 text-sm font-medium text-yellow-800 bg-yellow-100 rounded dark:bg-yellow-900 dark:text-yellow-300">
                            Clear filter
                            <button type="button"
                                class="inline-flex items-center p-1 ms-2 text-sm text-yellow-400 bg-transparent rounded-sm hover:bg-yellow-200 hover:text-yellow-900 dark:hover:bg-yellow-800 dark:hover:text-yellow-300"
                                data-dismiss-target="#badge-dismiss-yellow" aria-label="Remove">
                                <svg class="w-2 h-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Clear filter</span>
                            </button>
                        </span>
                    @endif

                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col"
                                    class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                    Name
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                    Email
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                    Program and Section
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                    Role
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                    Teams belongs to
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800">
                            @forelse ($users as $userKey => $user)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="p-4 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <x-data-link-button data-modal-target="edit-modal" wire:key={{ $userKey }}
                                            wire:click="edit('{{ $user->id }}')"
                                            data-modal-toggle="edit-modal">{{ ucwords($user->name) }}</x-data-link-button>
                                    </td>
                                    <td
                                        class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                        {{ $user->email }}
                                    </td>
                                    <td
                                        class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                        {{ $user->course?->code }} - {{ $user->section?->name }}
                                    </td>
                                    <td
                                        class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">

                                        <span
                                            class="bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">{{ $user->is_panel_chair ? ucfirst($user->roles()->pluck('name')[0]) . '*' : ucfirst($user->roles()->pluck('name')[0]) }}</span>
                                    </td>
                                    <td
                                        class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                        @foreach ($user->teams as $team)
                                            {{ $team->name }}@if (!$loop->last)
                                                ,
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white"
                                            colspan="3">
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
        {{ $users->links() }}

        <!-- Add modal -->
        <div wire:ignore.self id="add-modal" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Create New User
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
                                <label for="name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                                <input type="text" wire:model="name" id="name"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">

                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div class="col-span-2">
                                <label for="email"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                                <input type="email" wire:model="email" id="email"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">

                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <div class="col-span-2">

                                <label for="role"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Role</label>
                                <select id="role" wire:model.live="role" wire:change="checkRole"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">Select option</option>
                                    @foreach ($roles as $userRole)
                                        <option value="{{ $userRole->name }}">{{ ucfirst($userRole->name) }}
                                        </option>
                                    @endforeach
                                </select>

                                <x-input-error :messages="$errors->get('role')" class="mt-2" />
                            </div>

                            @if ($role === 'panelist')
                                <div class="col-span-2">

                                    <input id="isPanelChair" type="checkbox" wire:model.defer="isPanelChair"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="isPanelChair"
                                        class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Panel
                                        chairman</label>

                                    <x-input-error :messages="$errors->get('role')" class="mt-2" />
                                </div>
                            @endif

                            @if ($role === 'student')

                                <div class="col-span-2">

                                    <label for="course"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Program</label>
                                    <select id="course" wire:model="course" wire:change="getSections"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option value="">Select option</option>
                                        @foreach ($courses as $course)
                                            <option value="{{ $course->id }}">{{ $course->code }} -
                                                {{ $course->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <x-input-error :messages="$errors->get('course')" class="mt-2" />
                                </div>

                                @if (!empty($sections))

                                    <div class="col-span-2">

                                        <label for="section"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Section</label>
                                        <select id="section" wire:model="section"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                            <option value="">Select option</option>
                                            @foreach ($sections as $section)
                                                <option value="{{ $section['id'] }}">{{ $section['name'] }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <x-input-error :messages="$errors->get('section')" class="mt-2" />
                                    </div>

                                @endif

                            @endif


                            <div class="col-span-2">
                                <label for="password"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                                <input type="password" wire:model="password" id="password"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">

                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <div class="col-span-2">
                                <label for="password_confirmation"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password
                                    confirmation</label>
                                <input type="password" wire:model="password_confirmation" id="password_confirmation"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">

                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>

                        </div>
                        <x-save-update-button methodName="store">Add new user</x-save-update-button>
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
                            Edit Section
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
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                                <input type="text" wire:model="name" id="name"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">

                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div class="col-span-2">
                                <label for="email"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                                <input type="email" wire:model="email" id="email"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">

                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <div class="col-span-2">

                                <label for="role"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Role</label>
                                <select id="role" wire:model.live="role" wire:change="checkRole"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">Select option</option>
                                    @foreach ($roles as $userRole)
                                        <option value="{{ $userRole->name }}">{{ ucfirst($userRole->name) }}
                                        </option>
                                    @endforeach
                                </select>

                                <x-input-error :messages="$errors->get('role')" class="mt-2" />
                            </div>

                            @if ($role === 'panelist')
                                <div class="col-span-2">

                                    <input id="isPanelChair" type="checkbox" wire:model.defer="isPanelChair"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="isPanelChair"
                                        class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Panel
                                        chairman</label>

                                    <x-input-error :messages="$errors->get('role')" class="mt-2" />
                                </div>
                            @endif

                            @if ($role === 'student')

                                <div class="col-span-2">

                                    <label for="course"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Course</label>
                                    <select id="course" wire:model="course" wire:change="getSections"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option value="">Select option</option>
                                        @foreach ($courses as $course)
                                            <option value="{{ $course->id }}">{{ $course->code }} -
                                                {{ $course->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <x-input-error :messages="$errors->get('course')" class="mt-2" />
                                </div>

                                @if (!empty($sections))

                                    <div class="col-span-2">

                                        <label for="section"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Section</label>
                                        <select id="section" wire:model="section"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                            <option value="">Select option</option>
                                            @foreach ($sections as $section)
                                                <option value="{{ $section['id'] }}">{{ $section['name'] }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <x-input-error :messages="$errors->get('section')" class="mt-2" />
                                    </div>

                                @endif
                            @endif

                            <div class="col-span-2">
                                <label for="password"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                                <input type="password" wire:model="password" id="password"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">

                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <div class="col-span-2">
                                <label for="password_confirmation"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password
                                    confirmation</label>
                                <input type="password" wire:model="password_confirmation" id="password_confirmation"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">

                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>

                        </div>
                        <x-save-update-button methodName="update">Update</x-save-update-button>
                        {{-- <x-delete-button wire:click="destroy('{{ $user?->id }}')"
                            wire:confirm="You are about to delete user {{ $name }}. Continue?">Delete
                            user</x-delete-button> --}}
                        <div wire:loading wire:target="update">
                            Loading...please wait.
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <!-- Section sort modal -->
        <div id="section-modal" tabindex="-1" aria-hidden="true" wire:ignore.self
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Filter by Section
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-toggle="section-modal">
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

                                <label for="course"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Course and
                                    Section</label>
                                <select id="course" wire:model="sortBySectionId" wire:change="sortBySection"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="0,0">Select option</option>
                                    @foreach ($courses as $course)
                                        <optgroup label="{{ $course->name }}">
                                            @foreach ($course->sections as $section)
                                                <option value="{{ $course->id }},{{ $section->id }}">
                                                    {{ $course->code }} -
                                                    {{ $section->name }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                                <div wire:loading wire:target="sortBySection">
                                    Loading...
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Panelist sort modal -->
        <div id="panelist-modal" tabindex="-1" aria-hidden="true" wire:ignore.self
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Filter by Panelist
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-toggle="panelist-modal">
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

                                <label for="sortPanelist"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Panelist</label>
                                <select id="sortPanelist" wire:model="panelistType" wire:change="sortByPanelist"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">Select option</option>
                                    <option value="chair">Panel chairman</option>
                                    <option value="member">Panel member</option>
                                </select>
                                <div wire:loading wire:target="sortByPanelist">
                                    Loading...
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Expert sort modal -->
        <div id="expert-modal" tabindex="-1" aria-hidden="true" wire:ignore.self
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Filter by Expert
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-toggle="expert-modal">
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

                                <label for="sortPanelist"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Panelist</label>
                                <select id="sortPanelist" wire:model="expertType" wire:change="filterByExpertUsers"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">Select option</option>
                                    <option value="capa">CAPA</option>
                                    <option value="consultant">Consultant</option>
                                    <option value="grammarian">Grammarian</option>
                                </select>
                                <div wire:loading wire:target="filterByExpertUsers">
                                    Loading...
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Import user modal -->
        <div id="import-user-modal" tabindex="-1" aria-hidden="true" wire:ignore.self
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Upload users from a CSV
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-toggle="import-user-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-4 md:p-5">
                        <div class="grid gap-4 mb-4 grid-cols-2">

                            <div class="col-span-2">

                                <label for="csvFile"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Upload CSV
                                    file</label>
                                <input wire:model="csvFile"
                                    class="mb-2 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                    id="csvFile" type="file">
                                <p class="mb-5">
                                    <a href="{{ asset('/users-template.csv') }}"
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Download
                                        template</a>
                                    @if (file_exists(storage_path('app/uploads/temp-users.csv')))
                                        or
                                        <a href="{{ route('download.temp.users') }}"
                                            class="m-0 p-0 font-medium text-blue-600 dark:text-blue-500 hover:underline">View
                                            allowed users</a>
                                    @endif
                                </p>


                                <x-save-update-button methodName="uploadCsv" wire:loading.attr="disabled">Upload
                                    CSV</x-save-update-button>
                                <x-input-error :messages="$errors->get('csvFile')" />
                                @if (file_exists(storage_path('app/uploads/temp-users.csv')))
                                    <p class="text-xs">*re-uploading will overwrite the existing.</p>
                                @endif
                                <div wire:loading wire:target="uploadCsv">
                                    Loading...
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
