<div>
    <!-- Card header -->
    <div class="items-center justify-between lg:flex">
        <div class="mb-4 lg:mb-0">
            <a href="{{ route('teams.and.titles.index') }}"
                class="mb-4 inline-flex items-center font-medium text-blue-600 dark:text-blue-500 hover:underline">
                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 12h14M5 12l4-4m-4 4 4 4" />
                </svg>
                Back
            </a>
            <h1 class="mb-2 text-2xl font-bold text-gray-900 dark:text-white">Create Team and Thesis Title</h1>
            <span class="text-base font-normal text-gray-500 dark:text-gray-400">Create teams, title, and assign members
                and panelists</span>
        </div>
    </div>

    <form class="mt-5">
        <div class="grid gap-4 mb-4 grid-cols-2">
            <div class="col-span-2">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Team
                    Name</label>
                <input type="text" wire:model="name" id="name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">

                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="col-span-2">
                <label for="thesisTitle" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Thesis
                    Title</label>
                <input type="text" wire:model="thesisTitle" id="thesisTitle"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">

                <x-input-error :messages="$errors->get('thesisTitle')" class="mt-2" />
            </div>

            <div class="col-span-2" wire:ignore>
                <label for="courseAndSection"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Course - Year &
                    Section</label>
                <select wire:model="courseAndSection" wire:change="getMembers" style="width: 100%;height:50px;"
                    id="courseAndSection">
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

            <div class="col-span-2">
                <label for="members"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Members</label>
                <select id="members" multiple
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    @foreach ($courseAndSectionUsers as $member)
                        <option value="{{ $member['id'] }}">{{ $member['name'] }}</option>
                    @endforeach
                </select>

                <x-input-error :messages="$errors->get('members')" class="mt-2" />
            </div>

        </div>
        <x-save-update-button methodName="store" class="mt-5">Create new team</x-save-update-button>
        <div wire:loading wire:target="store">
            Loading...please wait.
        </div>
    </form>
</div>


@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            //Course and Section
            $('#courseAndSection').select2({
                placeholder: 'Select option'
            });
            $('#courseAndSection').on('change', function(e) {
                var data = $('#courseAndSection').select2("val");
                @this.set('courseAndSection', data);
                Livewire.dispatch('course-change')
            });
            //Memebers
            // $('#members').select2({
            //     placeholder: 'Select option'
            // });

            Livewire.on('showMembers', (event) => {
                alert(event)
            })

            // $('#members').on('change', function(e) {
            //     var data = $('#members').select2("val");
            //     @this.set('members', data);
            // });
        });
    </script>
@endpush
