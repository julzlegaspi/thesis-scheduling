<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.5.3/flowbite.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .hero-bg {
            background-image: url('{{ asset('cspc-bg.jpg') }}');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>

<body class="bg-gray-100">

    <!-- Full Page Hero Section -->
    <section class="hero-bg h-screen flex items-center justify-center text-center text-white">
        <div class="container mx-auto px-4">
            <h1 class="text-5xl font-bold mb-6">DEFENDEASE: THESIS DEFENSE
                SCHEDULING</h1>
            <p class="text-lg mb-8">Efficiently Manage and Schedule Your Thesis Defenses</p>
            <a href="{{ route('login') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-6 rounded">Get
                Started</a>
        </div>
    </section>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.5.3/flowbite.min.js"></script>
</body>

</html>
