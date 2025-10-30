@extends('layouts.app')

@section('title', 'Ödeme Başarılı')

@section('content')
    <div class="max-w-3xl mx-auto">
        <!-- Success Message -->
        <div class="bg-white rounded-lg shadow-sm p-8 text-center mb-6">
            <div class="mb-4">
                <svg class="w-20 h-20 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Biletiniz Başarıyla Oluşturuldu!</h1>
            <p class="text-gray-600 mb-6">
                Bilet detayları e-posta adresinize gönderilmiştir.
            </p>
            <div class="inline-block bg-blue-50 px-6 py-3 rounded-lg">
                <div class="text-sm text-gray-600">Bilet Bilgi Numarası</div>
                <div class="text-2xl font-bold text-blue-600">{{ formatOrderNumber($order->id) }}</div>
            </div>
        </div>

        <!-- Order Details -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Bilet Detayları</h2>

            <!-- Event Info -->
            <div class="mb-6 pb-6 border-b">
                <div class="flex items-start space-x-4">
                    <img src="{{ $order->tickets->first()->event->image_url }}"
                        alt="{{ $order->tickets->first()->event->title }}" class="w-24 h-24 object-cover rounded-lg">
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-gray-900">{{ $order->tickets->first()->event->title }}</h3>
                        <div class="text-sm text-gray-600 mt-2 space-y-1">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ formatDate($order->tickets->first()->event->event_date, 'DD MMMM YYYY, dddd - HH:mm') }}
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                {{ $order->tickets->first()->event->venue->name }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tickets -->
            <div class="mb-6 pb-6 border-b">
                <h3 class="font-bold text-gray-900 mb-3">Biletler</h3>
                <div class="space-y-2">
                    @foreach ($order->tickets as $ticket)
                        <div class="flex items-center justify-between bg-gray-50 rounded-lg p-3">
                            <div>
                                <div class="font-medium text-gray-900">{{ $ticket->category->name }}</div>
                                @if ($ticket->seat)
                                    <div class="text-sm text-gray-600">Koltuk: {{ $ticket->seat->seat_number }}</div>
                                @else
                                    <div class="text-sm text-gray-600">Genel Giriş</div>
                                @endif
                            </div>
                            <div class="text-lg font-bold text-gray-900">
                                {{ number_format($ticket->price, 2) }} ₺
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Customer Info -->
            <div class="mb-6 pb-6 border-b">
                <h3 class="font-bold text-gray-900 mb-3">Müşteri Bilgileri</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex">
                        <span class="text-gray-600 w-32">Ad Soyad:</span>
                        <span class="font-medium">{{ $order->name }} {{ $order->surname }}</span>
                    </div>
                    <div class="flex">
                        <span class="text-gray-600 w-32">E-posta:</span>
                        <span class="font-medium">{{ $order->email }}</span>
                    </div>
                    <div class="flex">
                        <span class="text-gray-600 w-32">Telefon:</span>
                        <span class="font-medium">{{ $order->phone }}</span>
                    </div>
                </div>
            </div>

            <!-- Payment Info -->
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-gray-900">Ödeme Bilgileri</h3>
                    <span class="inline-block bg-green-100 text-green-800 text-xs font-semibold px-3 py-1 rounded-full">
                        Ödeme Alındı
                    </span>
                </div>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Kart Numarası:</span>
                        <span class="font-medium">**** **** **** {{ $order->payment->cc_number }}</span>
                    </div>
                    <div class="flex justify-between pt-3 border-t">
                        <span class="text-lg font-bold text-gray-900">Toplam Tutar:</span>
                        <span
                            class="text-2xl font-bold text-blue-600">{{ number_format($order->payment->total_amount, 2) }}
                            ₺</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex space-x-4">
            <a href="{{ route('events.index') }}"
                class="flex-1 text-center bg-gray-100 text-gray-800 font-bold py-3 px-6 rounded-lg hover:bg-gray-200 transition">
                Etkinliklere Dön
            </a>
            <button onclick="window.print()"
                class="flex-1 bg-blue-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-blue-700 transition">
                Yazdır
            </button>
        </div>
    </div>
@endsection
