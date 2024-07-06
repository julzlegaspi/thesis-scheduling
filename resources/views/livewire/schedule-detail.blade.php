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
                @if ($isHappeningNowStatus === 'true')
                    <span
                        class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400">Happening
                        now</span>
                @endif
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
            Schedule details will show here and approval process timeline...
        </div>
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="styled-rsc" role="tabpanel"
            aria-labelledby="rsc-tab">
            <p class="text-sm text-gray-500 dark:text-gray-400">This is some placeholder content the <strong
                    class="font-medium text-gray-800 dark:text-white">Dashboard tab's associated content</strong>.
                Clicking another tab will toggle the visibility of this one for the next. The tab JavaScript swaps
                classes to control the content visibility and styling.</p>
        </div>
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="styled-manuscript" role="tabpanel"
            aria-labelledby="manuscript-tab">
            @canany(['secretary.create', 'admin.create'])
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
                                                {{ \Carbon\Carbon::parse($manuscript->created_at)->format('F j Y g:i:s A') }}
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

    @canany(['secretary.create', 'admin.create'])
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
