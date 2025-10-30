@extends('layouts.app')

@section('title', 'Tüm Etkinlikler - Event Ticket Selling System')

@section('content')
    @if ($searchTerm)
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <span class="text-gray-700">
                        <strong>"{{ $searchTerm }}"</strong> için <strong>{{ $events->count() }}</strong> sonuç bulundu
                    </span>
                </div>
                <a href="{{ route('events.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    Aramayı Temizle
                </a>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-sm">
        <table class="min-w-full table-auto">
            <thead class="bg-blue-300 border-b">
                <tr>
                    <th class="text-left px-6 py-3 text-sm font-semibold text-gray-700">Etkinlik</th>
                    <th class="text-left px-6 py-3 text-sm font-semibold text-gray-700">Mekan</th>
                    <th class="text-left px-6 py-3 text-sm font-semibold text-gray-700">Tarih</th>
                </tr>
            </thead>
            <tbody>
                @forelse($events as $event)
                    <tr class="border-b hover:bg-gray-50 transition cursor-pointer"
                        onclick="window.location='{{ route('events.show', $event->id) }}'">
                        <td class="flex items-center px-6 py-4">
                            <div class="flex-shrink-0 w-16 h-16 mr-4">
                                <img src="{{ $event->image_url }}" alt="{{ $event->title }}"
                                    class="w-full h-full object-cover rounded">
                            </div>
                            <div>
                                <h3 class="text-base font-semibold text-gray-900 hover:text-blue-600">
                                    {{ $event->title }}
                                </h3>
                                <span
                                    class="inline-block mt-1 px-3 py-1 text-xs font-semibold text-white {{ $event->status_color }} rounded-full">
                                    {{ $event->status_text }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            <div>{{ $event->venue->name }}</div>
                            <div class="text-xs text-gray-500">{{ $event->venue->address }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            {{ formatDate($event->event_date, 'ddd, DD/MM/YYYY') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-8 text-center text-gray-500">
                            @if ($searchTerm)
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-400 mb-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="text-lg font-medium mb-1">Aradığınız kriterlere uygun etkinlik bulunamadı</p>
                                    <p class="text-sm">Farklı anahtar kelimeler deneyebilirsiniz</p>
                                </div>
                            @else
                                Henüz etkinlik bulunmamaktadır.
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
