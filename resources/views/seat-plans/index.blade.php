@extends('layouts.app')

@section('title', 'Koltuk Seçimi - ' . $event->title)

@section('content')
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $event->title }}</h1>
            <div class="flex items-center justify-between text-sm text-gray-600">
                <div>
                    <span>{{ $event->venue->name }}</span>
                    <span class="mx-2">•</span>
                    <span>{{ formatDate($event->event_date, 'DD MMMM YYYY HH:mm') }}</span>
                </div>
                <div class="text-right">
                    <div class="font-semibold text-gray-900">{{ $category->name }}</div>
                    <div class="text-blue-600 font-bold">{{ number_format($category->pivot->price, 2) }} ₺</div>
                </div>
            </div>
            @if (count($bookedSeatIds) > 0)
                <div class="mt-3 text-sm text-red-600">
                    <strong>Dolu Koltuklar:</strong> {{ count($bookedSeatIds) }} adet
                </div>
            @endif
        </div>

        <!-- Selection Mode -->
        <div class="bg-white rounded-lg shadow-sm mb-6">
            <div class="border-b border-gray-200">
                <div class="flex">
                    <button id="auto-tab" onclick="switchMode('auto')"
                        class="flex-1 px-6 py-3 text-center font-medium border-b-2 border-transparent hover:text-blue-600 transition">
                        Otomatik Seçim
                    </button>
                    <button id="manual-tab" onclick="switchMode('manual')"
                        class="flex-1 px-6 py-3 text-center font-medium border-b-2 border-transparent text-blue-600 transition">
                        Harita Üzerinden Seçim
                    </button>
                </div>
            </div>

            <!-- Auto Selection Panel -->
            <div id="auto-panel" class="hidden p-6">
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Kaç Adet Bilet?</label>
                    <select id="auto-ticket-count"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @for ($i = 1; $i <= 10; $i++)
                            <option value="{{ $i }}">{{ $i }} Bilet</option>
                        @endfor
                    </select>
                </div>
                <button onclick="autoSelectSeats()"
                    class="w-full bg-blue-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-blue-700 transition">
                    Otomatik Seç
                </button>
            </div>

            <!-- Manual Selection Panel -->
            <div id="manual-panel" class="p-6">
                <!-- Zoom Controls -->
                <div class="flex justify-end mb-4 space-x-2">
                    <button onclick="zoomOut()" title="Uzaklaştır"
                        class="p-2 border border-gray-300 rounded-lg hover:bg-gray-100 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                        </svg>
                    </button>
                    <button onclick="resetZoom()" title="Sıfırla (Zoom ve Seçimleri Temizle)"
                        class="p-2 border border-gray-300 rounded-lg hover:bg-gray-100 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </button>
                    <button onclick="zoomIn()" title="Yakınlaştır"
                        class="p-2 border border-gray-300 rounded-lg hover:bg-gray-100 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </button>
                </div>

                <!-- Seat Map -->
                <div class="seat-map-wrapper bg-gradient-to-b from-gray-100 to-gray-50 rounded-lg p-5 overflow-auto">
                    <!-- Stage -->
                    <div class="text-center mb-8">
                        <div
                            class="inline-block bg-gradient-to-r from-gray-700 to-gray-600 px-48 py-3 rounded-lg text-white font-bold text-lg shadow-lg">
                            SAHNE
                        </div>
                    </div>

                    <!-- Seats Grid -->
                    <div id="seat-map" class="space-y-8">
                        @php
                            $seatsBySection = $seats->groupBy('section')->sortKeys();
                            $topSections = ['A', 'B'];
                            $bottomSections = ['C', 'D'];
                        @endphp

                        <!-- Üst Bölüm -->
                        <div class="flex justify-center gap-8">
                            @foreach ($topSections as $section)
                                @if (isset($seatsBySection[$section]))
                                    @php $sectionSeats = $seatsBySection[$section]; @endphp
                                    <div class="text-center">
                                        <div class="text-xs font-bold text-gray-600 mb-2">BÖLÜM {{ $section }}</div>
                                        <div class="space-y-1">
                                            @php
                                                $seatsByRow = $sectionSeats->groupBy('row')->sortKeys();
                                            @endphp

                                            @foreach ($seatsByRow as $row => $rowSeats)
                                                <div class="flex items-center space-x-1">
                                                    <div class="flex space-x-0.5">
                                                        @php
                                                            $sortedRowSeats = $rowSeats->sortBy(function ($seat) {
                                                                $parts = explode('-', $seat->seat_number);
                                                                return (int) end($parts);
                                                            });
                                                        @endphp
                                                        @foreach ($sortedRowSeats as $seat)
                                                            @php
                                                                $isBooked = in_array($seat->id, $bookedSeatIds);
                                                                $isAvailable =
                                                                    $seat->ticket_category_id == $category->id;
                                                                $isDisabled = $isBooked || !$isAvailable;

                                                                if ($isBooked) {
                                                                    $colorClass = 'bg-red-500 cursor-not-allowed';
                                                                } elseif (!$isAvailable) {
                                                                    $colorClass =
                                                                        'bg-gray-300 cursor-not-allowed opacity-50';
                                                                } else {
                                                                    $colorClass = 'bg-blue-400 hover:bg-blue-500';
                                                                }
                                                            @endphp
                                                            <button type="button" onclick="toggleSeat({{ $seat->id }})"
                                                                data-seat-id="{{ $seat->id }}"
                                                                data-available="{{ $isAvailable ? '1' : '0' }}"
                                                                class="seat-button w-5 h-5 rounded-sm transition-all duration-150 {{ $colorClass }}"
                                                                {{ $isDisabled ? 'disabled' : '' }}
                                                                title="{{ $seat->seat_number }}{{ !$isAvailable ? ' - ' . $seat->category->name : '' }}">
                                                            </button>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <!-- Alt Bölüm -->
                        <div class="flex justify-center gap-4">
                            @foreach ($bottomSections as $section)
                                @if (isset($seatsBySection[$section]))
                                    @php $sectionSeats = $seatsBySection[$section]; @endphp
                                    <div class="text-center">
                                        <div class="text-xs font-bold text-gray-600 mb-2">BÖLÜM {{ $section }}</div>
                                        <div class="space-y-1">
                                            @php
                                                $seatsByRow = $sectionSeats->groupBy('row')->sortKeys();
                                            @endphp

                                            @foreach ($seatsByRow as $row => $rowSeats)
                                                <div class="flex items-center space-x-1">
                                                    <div class="flex space-x-0.5">
                                                        @php
                                                            $sortedRowSeats = $rowSeats->sortBy(function ($seat) {
                                                                $parts = explode('-', $seat->seat_number);
                                                                return (int) end($parts);
                                                            });
                                                        @endphp
                                                        @foreach ($sortedRowSeats as $seat)
                                                            @php
                                                                $isBooked = in_array($seat->id, $bookedSeatIds);
                                                                $isAvailable =
                                                                    $seat->ticket_category_id == $category->id;
                                                                $isDisabled = $isBooked || !$isAvailable;

                                                                if ($isBooked) {
                                                                    $colorClass = 'bg-red-500 cursor-not-allowed';
                                                                } elseif (!$isAvailable) {
                                                                    $colorClass =
                                                                        'bg-gray-300 cursor-not-allowed opacity-50';
                                                                } else {
                                                                    $colorClass = 'bg-blue-400 hover:bg-blue-500';
                                                                }
                                                            @endphp
                                                            <button type="button"
                                                                onclick="toggleSeat({{ $seat->id }})"
                                                                data-seat-id="{{ $seat->id }}"
                                                                data-available="{{ $isAvailable ? '1' : '0' }}"
                                                                class="seat-button w-5 h-5 rounded-sm transition-all duration-150 {{ $colorClass }}"
                                                                {{ $isDisabled ? 'disabled' : '' }}
                                                                title="{{ $seat->seat_number }}{{ !$isAvailable ? ' - ' . $seat->category->name : '' }}">
                                                            </button>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Legend -->
                <div class="flex justify-center space-x-6 mt-4 text-sm">
                    <div class="flex items-center">
                        <div class="w-5 h-5 bg-blue-400 rounded-sm mr-2"></div>
                        <span>Mevcut</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-5 h-5 bg-green-500 rounded-sm mr-2"></div>
                        <span>Seçili</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-5 h-5 bg-red-500 rounded-sm mr-2"></div>
                        <span>Dolu</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-5 h-5 bg-gray-300 rounded-sm mr-2 opacity-50"></div>
                        <span>Satın Alınamaz</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Selected Seats & Total -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="font-bold text-gray-900">Seçili Koltuklar</h3>
                    <p id="selected-count" class="text-sm text-gray-600">0 koltuk seçildi</p>
                </div>
                <div class="text-right">
                    <div class="text-sm text-gray-600">Toplam Tutar</div>
                    <div id="total-amount" class="text-2xl font-bold text-blue-600">0.00 ₺</div>
                </div>
            </div>

            <form id="payment-form" method="GET" action="{{ route('payments.create') }}">
                <input type="hidden" name="event_id" value="{{ $event->id }}">
                <input type="hidden" name="ticket_category_id" value="{{ $category->id }}">
                <div id="selected-seats-container"></div>

                <button type="submit" id="continue-btn" disabled
                    class="w-full bg-pink-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-pink-700 transition disabled:bg-gray-300 disabled:cursor-not-allowed">
                    Ödemeye Geç
                </button>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            const pricePerSeat = {{ $category->pivot->price }};
            const bookedSeats = @json($bookedSeatIds);
        </script>
        <script src="{{ asset('frontend/js/seat-plan.js') }}"></script>
    @endpush
@endsection
