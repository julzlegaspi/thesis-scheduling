<button {{ $attributes->merge(['type' => 'submit', 'class' => 'text-white bg-orange-500 hover:bg-orange-800 focus:ring-4 focus:ring-orange-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-orange-600 dark:hover:bg-orange-700 focus:outline-none dark:focus:ring-orange-800']) }}>
    {{ $slot }}
</button>