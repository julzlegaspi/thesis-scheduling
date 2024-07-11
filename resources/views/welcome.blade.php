<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.4.7/flowbite.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset("cspc-bg.jpg") }}');">
    <div class="flex items-center justify-center min-h-screen bg-gray-900 bg-opacity-50">
        <div class="text-center text-white p-8 rounded-lg bg-opacity-75 bg-gray-800">
            <h1 class="text-5xl font-bold mb-4">Thesis Defense Scheduling</h1>
            <p class="text-lg mb-6">Simplifying the Scheduling of Your Thesis Defense</p>
            <a href="{{ route('login') }}" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-full">Get Started</a>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.4.7/flowbite.min.js"></script>
</body>
</html>
