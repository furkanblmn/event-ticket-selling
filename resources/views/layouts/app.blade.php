<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Event Ticket Selling System - Etkinlik Bilet Satış')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('frontend/css/app.css') }}">
</head>

<body class="bg-gray-100">
    <!-- Header -->
    <header class="bg-gradient-to-r from-blue-700 to-blue-900 text-white">
        <div class="container mx-auto px-4">
            <!-- Main Navigation -->
            <div class="flex items-center justify-between py-4">
                <div class="flex items-center space-x-8">
                    <a href="/" class="text-2xl font-bold">
                        <span class="italic">Event Ticket</span>
                        <div class="text-xs">Selling System</div>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <form action="{{ route('events.index') }}" method="GET" class="flex items-center">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Etkinlik, sanatçı ya da mekan arayın"
                            class="h-11 px-4 rounded-l-lg text-gray-800 w-80 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <button type="submit"
                            class="h-11 px-4 bg-blue-600 text-white rounded-r-lg hover:bg-blue-700 transition flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-6">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-12 py-8">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; {{ date('Y') }} Event Ticket Selling System. Tüm hakları saklıdır.</p>
        </div>
    </footer>


    @stack('scripts')
</body>

</html>
