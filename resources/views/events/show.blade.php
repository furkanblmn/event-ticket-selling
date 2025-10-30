@extends('layouts.app')

@section('title', $event->title . ' - Event Ticket Selling System')

@section('content')
    <!-- Breadcrumb -->
    <nav class="text-sm mb-4">
        <ol class="flex items-center space-x-2 text-gray-600">
            <li><a href="{{ route('events.index') }}" class="hover:text-blue-600">Etkinlikler</a></li>
            <li><span class="mx-2">›</span></li>
            <li class="text-gray-900 font-medium">{{ $event->title }}</li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Event Header -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <div class="flex items-start justify-between mb-4">
                    <h1 class="text-3xl font-bold text-gray-900 flex-1">{{ $event->title }}</h1>
                </div>

                <!-- Event Image -->
                <div class="mb-6">
                    <img src="{{ $event->image_url }}" alt="{{ $event->title }}"
                        class="w-full h-96 object-cover rounded-lg shadow-md">
                </div>

                <!-- Event Description -->
                <div class="prose max-w-none">
                    <h2 class="text-xl font-bold text-gray-900 uppercase mb-4">
                        {{ $event->title }}
                    </h2>
                    <div class="text-gray-700 leading-relaxed" id="description">
                        {{ $event->description }}
                    </div>
                </div>
            </div>

            <!-- Event Schedule Section -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Etkinlik Takvimi</h2>

                <!-- Tabs -->
                <div class="flex space-x-4 mb-6 border-b">
                    <button id="list-tab" class="px-4 py-2 font-medium text-white bg-blue-600 rounded-t-lg transition">
                        Liste
                    </button>
                </div>

                <!-- List View -->
                <div id="list-view" class="space-y-4">
                    <div class="border-l-4 border-red-500 pl-4 py-3 hover:bg-gray-50 transition">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4 flex-1">
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-gray-900">
                                        {{ $event->event_date->format('d') }}
                                    </div>
                                    <div class="text-sm text-gray-600">
                                        {{ formatDate($event->event_date, 'MMM') }}
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900 mb-1">{{ $event->title }}</h3>
                                    <span
                                        class="inline-block px-3 py-1 text-xs font-semibold text-white {{ $event->status_color }} rounded-full">
                                        {{ $event->status_text }}
                                    </span>
                                </div>
                            </div>
                            <div class="text-right pr-3">
                                <div class="text-sm font-medium text-gray-900">{{ $event->venue->name }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Calendar View (hidden by default) -->
                <div id="calendar-view" class="hidden">
                    <p class="text-gray-600">Takvim görünümü yakında eklenecek...</p>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-sm p-6 sticky top-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Etkinlik Bilgileri</h3>

                <!-- Event Date & Time -->
                <div class="mb-6">
                    <div class="flex items-center text-gray-600 mb-2">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="font-medium">Tarih ve Saat</span>
                    </div>
                    <p class="text-gray-900 ml-7">
                        {{ formatDate($event->event_date, 'dddd, DD MMMM YYYY') }}
                    </p>
                    <p class="text-gray-900 ml-7">
                        {{ formatDate($event->event_date, 'HH:mm') }}
                    </p>
                </div>

                <!-- Venue -->
                <div class="mb-6">
                    <div class="flex items-center text-gray-600 mb-2">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="font-medium">Mekan</span>
                    </div>
                    <p class="text-gray-900 ml-7 font-semibold">{{ $event->venue->name }}</p>
                    <p class="text-gray-600 ml-7 text-sm">{{ $event->venue->address }}</p>
                </div>

                <!-- Ticket Category Selection -->
                <div class="mb-6">
                    <label for="category" class="block text-gray-700 font-medium mb-2">
                        Bilet Kategorisi Seçin
                    </label>
                    <select id="category" name="category" data-event-id="{{ $event->id }}"
                        {{ $event->isDisabled() ? 'disabled' : '' }}
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent disabled:bg-gray-100 disabled:cursor-not-allowed">
                        <option value="">Kategori Seçiniz</option>
                        @foreach ($event->ticketCategories as $category)
                            @php
                                $availableStock = $event->getAvailableStockForCategory($category->id);
                            @endphp
                            <option value="{{ $category->id }}" data-stock="{{ $availableStock }}"
                                {{ $availableStock <= 0 ? 'disabled' : '' }}>
                                {{ $category->name }} - {{ number_format($category->pivot->price, 2) }} ₺
                                ({{ $availableStock }} koltuk)
                            </option>
                        @endforeach
                    </select>
                </div>

                @if ($event->isDisabled())
                    <!-- Disabled Button with Message -->
                    <div class="text-center">
                        <button disabled
                            class="w-full bg-gray-400 text-white font-bold py-3 px-6 rounded-lg cursor-not-allowed">
                            {{ $event->disabled_message }}
                        </button>
                    </div>
                @else
                    <!-- Buy Ticket Button -->
                    <button id="buy-ticket-btn" onclick="buyTicket()"
                        class="w-full bg-gradient-to-r from-pink-600 to-pink-700 text-white font-bold py-3 px-6 rounded-lg hover:from-pink-700 hover:to-pink-800 transition shadow-md disabled:opacity-50 disabled:cursor-not-allowed">
                        Bilet Satın Al
                    </button>
                @endif

                <!-- Info Text -->
                <p class="text-xs text-gray-500 text-center mt-4">
                    Bilet satın alarak <a href="#" class="text-blue-600 hover:underline">kullanım koşullarını</a>
                    kabul etmiş olursunuz.
                </p>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('frontend/js/event-detail.js') }}"></script>
    @endpush
@endsection
