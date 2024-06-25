<button {{ $attributes->merge(['type' => 'button', 'class' => 'font-medium text-blue-600 dark:text-blue-500 hover:underline']) }}>
    {{ $slot }}
</button>