<div>
    <!-- Card header -->
    <div class="items-center justify-between lg:flex">
        <div class="mb-4 lg:mb-0">
            <h1 class="mb-2 text-2xl font-bold text-gray-900 dark:text-white">Complete your profile</h1>
            <span class="text-base font-normal text-gray-500 dark:text-gray-400">Please complete your profile to get
                started</span>
        </div>
    </div>

    <div class="grid gap-4 mb-4 grid-cols-2 mt-6">
        <div class="col-span-2">

            <label for="course" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Course</label>
            <select id="course" wire:model="course"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="">Select option</option>
                @foreach ($courses as $course)
                    <option value="{{ $course->id }}">{{ $course->code }} - {{ $course->name }}
                    </option>
                @endforeach
            </select>

            <x-input-error :messages="$errors->get('course')" class="mt-2" />
        </div>

        <div class="col-span-2">

            <label for="section" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Section</label>
            <select id="section" wire:model="section"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="">Select option</option>
                @foreach ($sections as $section)
                    <option value="{{ $section->id }}">{{ $section->name }}
                    </option>
                @endforeach
            </select>

            <x-input-error :messages="$errors->get('section')" class="mt-2" />
        </div>
    </div>

    <x-save-update-button methodName="store">Complete profile</x-save-update-button>
    <div wire:loading wire:target="store">
        Loading...please wait.
    </div>
</div>
