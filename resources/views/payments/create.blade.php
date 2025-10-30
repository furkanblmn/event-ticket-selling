@extends('layouts.app')

@section('title', 'Ödeme - ' . $event->title)

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Ödeme Bilgileri</h1>
            <div class="text-sm text-gray-600">
                <span>{{ $event->title }}</span>
                <span class="mx-2">•</span>
                <span>{{ $event->venue->name }}</span>
                <span class="mx-2">•</span>
                <span>{{ formatDate($event->event_date, 'DD MMMM YYYY HH:mm') }}</span>
            </div>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('payments.store') }}">
            @csrf

            <input type="hidden" name="event_id" value="{{ $event->id }}">
            <input type="hidden" name="ticket_category_id" value="{{ $category->id }}">

            @foreach ($seats as $seat)
                <input type="hidden" name="seats[]" value="{{ $seat->id }}">
            @endforeach

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Form -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Customer Information -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Müşteri Bilgileri</h2>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Ad <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="customer_name" name="customer_name"
                                    value="{{ old('customer_name') }}" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            <div>
                                <label for="customer_surname" class="block text-sm font-medium text-gray-700 mb-2">
                                    Soyad <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="customer_surname" name="customer_surname"
                                    value="{{ old('customer_surname') }}" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="customer_email" class="block text-sm font-medium text-gray-700 mb-2">
                                E-posta <span class="text-red-500">*</span>
                            </label>
                            <input type="email" id="customer_email" name="customer_email"
                                value="{{ old('customer_email') }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <div class="mt-4">
                            <label for="customer_phone" class="block text-sm font-medium text-gray-700 mb-2">
                                Telefon <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" id="customer_phone" name="customer_phone"
                                value="{{ old('customer_phone') }}" placeholder="05555555555" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>

                    <!-- Payment Information -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Kart Bilgileri</h2>

                        <div class="mb-4">
                            <label for="cc_number" class="block text-sm font-medium text-gray-700 mb-2">
                                Kart Numarası <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="cc_number" name="cc_number" value="{{ old('cc_number') }}"
                                maxlength="16" placeholder="1111111111111111" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label for="cc_exp_month" class="block text-sm font-medium text-gray-700 mb-2">
                                    Ay <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="cc_exp_month" name="cc_exp_month"
                                    value="{{ old('cc_exp_month') }}" maxlength="2" placeholder="11" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            <div>
                                <label for="cc_exp_year" class="block text-sm font-medium text-gray-700 mb-2">
                                    Yıl <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="cc_exp_year" name="cc_exp_year" value="{{ old('cc_exp_year') }}"
                                    maxlength="2" placeholder="28" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            <div>
                                <label for="cc_cvv" class="block text-sm font-medium text-gray-700 mb-2">
                                    CVV <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="cc_cvv" name="cc_cvv" value="{{ old('cc_cvv') }}"
                                    maxlength="3" placeholder="111" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-sm p-6 sticky top-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Sipariş Özeti</h3>

                        <div class="space-y-3 mb-4 pb-4 border-b">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Etkinlik</span>
                                <span class="font-medium">{{ $event->title }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Kategori</span>
                                <span class="font-medium">{{ $category->name }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Bilet Adedi</span>
                                <span class="font-medium">{{ count($seats) > 0 ? count($seats) : 1 }}</span>
                            </div>
                            @if (count($seats) > 0)
                                <div class="text-sm">
                                    <span class="text-gray-600 block mb-1">Koltuklar:</span>
                                    <div class="flex flex-wrap gap-1">
                                        @foreach ($seats as $seat)
                                            <span
                                                class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">{{ $seat->seat_number }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="flex justify-between items-center mb-6">
                            <span class="text-lg font-bold text-gray-900">Toplam Tutar</span>
                            <span class="text-2xl font-bold text-blue-600">{{ number_format($totalAmount, 2) }} ₺</span>
                        </div>

                        <button type="submit"
                            class="w-full bg-gradient-to-r from-pink-600 to-pink-700 text-white font-bold py-3 px-6 rounded-lg hover:from-pink-700 hover:to-pink-800 transition shadow-md">
                            Ödemeyi Tamamla
                        </button>

                        <p class="text-xs text-gray-500 text-center mt-4">
                            Ödemenizi tamamlayarak <a href="#" class="text-blue-600 hover:underline">kullanım
                                koşullarını</a> kabul etmiş olursunuz.
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script src="{{ asset('frontend/js/payment-form.js') }}"></script>
    @endpush
@endsection
