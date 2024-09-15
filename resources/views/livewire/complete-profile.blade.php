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

            <label for="courseAndSection" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Course and Section</label>
            <select id="courseAndSection" wire:model="courseAndSection"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="">Select option</option>
                @foreach ($courses as $course)
                    <optgroup label="{{ $course->name }}">
                        @foreach ($course->sections as $section)
                            <option value="{{$course->id}},{{$section->id}}">{{ $course->code }} - {{ $section->name }}</option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>

            <x-input-error :messages="$errors->get('courseAndSection')" class="mt-2" />
        </div>

    </div>

    <x-save-update-button methodName="store">Complete profile</x-save-update-button>
    <div wire:loading wire:target="store">
        Loading...please wait.
    </div>
</div>
