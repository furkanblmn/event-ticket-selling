<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sipariş Onayı</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .email-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }

        .email-header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }

        .email-header .success-icon {
            font-size: 48px;
            margin-bottom: 10px;
        }

        .email-body {
            padding: 30px 20px;
        }

        .order-number {
            background-color: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .order-number strong {
            color: #667eea;
            font-size: 18px;
        }

        .event-details {
            margin-bottom: 30px;
        }

        .event-image {
            width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .event-title {
            font-size: 20px;
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
        }

        .event-info {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
            color: #666;
        }

        .event-info svg {
            width: 18px;
            height: 18px;
            margin-right: 8px;
            flex-shrink: 0;
        }

        .ticket-details {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .ticket-details h3 {
            margin-top: 0;
            margin-bottom: 15px;
            font-size: 18px;
            color: #333;
        }

        .ticket-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e0e0e0;
        }

        .ticket-item:last-child {
            border-bottom: none;
        }

        .ticket-label {
            color: #666;
        }

        .ticket-value {
            font-weight: 600;
            color: #333;
        }

        .price-total {
            background-color: #667eea;
            color: white;
            padding: 15px;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 18px;
            font-weight: 600;
            margin-top: 20px;
        }

        .customer-info {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #e0e0e0;
        }

        .customer-info h3 {
            margin-top: 0;
            margin-bottom: 15px;
            font-size: 18px;
            color: #333;
        }

        .info-row {
            margin-bottom: 10px;
        }

        .info-label {
            color: #666;
            font-size: 14px;
        }

        .info-value {
            color: #333;
            font-weight: 500;
        }

        .email-footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #666;
            font-size: 14px;
        }

        .email-footer p {
            margin: 5px 0;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="email-header">
            <div class="success-icon">✓</div>
            <h1>Siparişiniz Onaylandı!</h1>
        </div>

        <div class="email-body">
            <div class="order-number">
                <strong>Bilet Bilgi Numarası:</strong> {{ formatOrderNumber($order->id) }}
            </div>

            <p>Merhaba {{ $order->name }} {{ $order->surname }},</p>
            <p>Bilet siparişiniz başarıyla oluşturuldu. Aşağıda sipariş detaylarınızı bulabilirsiniz.</p>

            @php
                $firstTicket = $order->tickets->first();
                $event = $firstTicket->event;
            @endphp

            <div class="event-details">
                @if ($event->image_url)
                    <img src="{{ $event->image_url }}" alt="{{ $event->title }}" class="event-image">
                @endif

                <h2 class="event-title">{{ $event->title }}</h2>

                <div class="event-info">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span>{{ formatDate($event->event_date) }}</span>
                </div>

                <div class="event-info">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span>{{ $event->venue->name }}</span>
                </div>
            </div>

            <div class="ticket-details">
                <h3>Bilet Detayları</h3>

                <div class="ticket-item">
                    <span class="ticket-label">Kategori</span>
                    <span class="ticket-value">{{ $firstTicket->category->name }}</span>
                </div>

                <div class="ticket-item">
                    <span class="ticket-label">Bilet Sayısı</span>
                    <span class="ticket-value">{{ $order->tickets->count() }} Adet</span>
                </div>

                @if ($firstTicket->seat_id)
                    <div class="ticket-item">
                        <span class="ticket-label">Koltuklar</span>
                        <span class="ticket-value">
                            @foreach ($order->tickets as $ticket)
                                {{ $ticket->seat->seat_number }}{{ !$loop->last ? ', ' : '' }}
                            @endforeach
                        </span>
                    </div>
                @endif

                <div class="ticket-item">
                    <span class="ticket-label">Bilet Fiyatı</span>
                    <span class="ticket-value">₺{{ number_format($firstTicket->price, 2, ',', '.') }}</span>
                </div>

                <div class="price-total">
                    <span>Toplam Tutar</span>
                    <span>₺{{ number_format($order->payment->total_amount, 2, ',', '.') }}</span>
                </div>
            </div>

            <div class="customer-info">
                <h3>Müşteri Bilgileri</h3>
                <div class="info-row">
                    <div class="info-label">Ad Soyad</div>
                    <div class="info-value">{{ $order->name }} {{ $order->surname }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">E-posta</div>
                    <div class="info-value">{{ $order->email }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Telefon</div>
                    <div class="info-value">{{ $order->phone }}</div>
                </div>
            </div>
        </div>

        <div class="email-footer">
            <p><strong>Etkinlik günü biletlerinizi yanınızda bulundurmayı unutmayın!</strong></p>
            <p>Herhangi bir sorunuz olursa bizimle <a href="mailto:bilgi@bilet-sistemi.com">bilgi@bilet-sistemi.com</a>
                adresi üzerinden iletişime geçebilirsiniz.</p>
            <p>&copy; {{ date('Y') }} Bilet Sistemi. Tüm hakları saklıdır.</p>
        </div>
    </div>
</body>

</html>
