# 🎫 Bilet Satış Sistemi

Modern ve kullanıcı dostu bir online bilet satış platformu. Konser, tiyatro, sinema ve diğer etkinlikler için bilet satışı yapmanızı sağlar.

## 📋 İçindekiler

- [Özellikler](#-özellikler)
- [Teknolojiler](#-teknolojiler)
- [Kurulum](#-kurulum)
- [Kullanım](#-kullanım)
- [Mail Yapılandırması](#-mail-yapılandırması)
- [Veritabanı Yapısı](#-veritabanı-yapısı)
- [Önemli Notlar](#-önemli-notlar)

## ✨ Özellikler

### 🎯 Temel Özellikler

- **Etkinlik Yönetimi**
  - Etkinlik listeleme ve detay sayfaları
  - Tarih ve mekan bilgileri
  - Etkinlik durumu (Satışta, Tükendi, Tarihi Geçmiş)
  - Etkinlik görselleri
  
- **Gelişmiş Arama**
  - Etkinlik başlığı, açıklama, mekan adı ve adrese göre arama
  - Gerçek zamanlı arama sonuçları
  
- **Koltuk Seçimi**
  - İnteraktif koltuk haritası
  - Manuel ve otomatik koltuk seçimi
  - Zoom in/out özelliği
  - Gerçek zamanlı müsaitlik kontrolü
  - Kategori bazlı koltuk gösterimi
  
- **Bilet Kategorileri**
  - VIP
  - Genel Giriş
  - Öğrenci
  - Balkon
  - Her etkinlik için özelleştirilebilir fiyatlandırma
  
- **Ödeme Sistemi**
  - Kredi kartı ile ödeme (simülasyon)
  - Müşteri bilgileri formu
  - Otomatik form validasyonu
  - Başarılı ödeme onay sayfası
  
- **Stok Yönetimi**
  - Gerçek zamanlı stok takibi
  - Kategori bazlı stok kontrolü
  - Soft delete desteği (iptal edilen biletler stoka geri döner)
  - Database constraint ile çift satış önleme
  
- **E-posta Bildirimleri**
  - Asenkron mail gönderimi (Queue sistemi)
  - Sipariş onay maili
  - Bilet detayları
  - Modern ve responsive mail tasarımı
  - 3 deneme ve 10 saniye backoff ile otomatik yeniden deneme

## 🛠 Teknolojiler

### Backend
- **PHP 8.3+** - Backend dili
- **Laravel 12.x** - PHP Framework
- **MySQL** - Veritabanı

### Frontend
- **Blade Template Engine** - View katmanı
- **Tailwind CSS** - Styling (CDN)
- **Vanilla JavaScript** - İnteraktif özellikler

### Diğer
- **Carbon** - Tarih işlemleri (Türkçe lokalizasyon)
- **Laravel Mail** - E-posta gönderimi
- **Laravel Queue** - Asenkron işlemler (Mail)
- **Eloquent ORM** - Veritabanı işlemleri

## 📦 Kurulum

### Gereksinimler

- PHP >= 8.3
- Composer
- MySQL >= 8.0
- Node.js & NPM (opsiyonel)

### Adım 1: Projeyi Klonlayın

```bash
git clone https://github.com/furkanblmn/event-ticket-selling.git
cd event-ticket-selling
```

### Adım 2: Bağımlılıkları Yükleyin

```bash
composer install
```

### Adım 3: Ortam Değişkenlerini Ayarlayın

`.env.example` dosyasını `.env` olarak kopyalayın:

```bash
cp .env.example .env
```

`.env` dosyasında veritabanı ayarlarınızı yapın:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bilet_sistemi
DB_USERNAME=root
DB_PASSWORD=your_password
```

### Adım 4: Veritabanını Oluşturun

MySQL'de yeni bir veritabanı oluşturun:

```sql
CREATE DATABASE bilet_sistemi CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### Adım 5: Projeyi Başlatın (Tek Komut)

```bash
php artisan app:set
```

Bu komut şunları yapar:
- ✅ Uygulama için benzersiz bir key oluşturur
- ✅ Tüm migration'ları çalıştırır
- ✅ Veritabanını örnek verilerle doldurur (seeders)
- ✅ Cache'leri temizler (config, cache, route, view)
- ✅ Queue worker'ı başlatır (opsiyonel, kullanıcıya sorar)
- ✅ Projeyi kullanıma hazır hale getirir

**Queue worker'ı otomatik başlatmak istemiyorsanız:**

```bash
php artisan app:set --skip-queue
```

**Alternatif olarak manuel kurulum:**

```bash
php artisan key:generate
php artisan migrate:fresh --seed
php artisan config:clear
php artisan queue:work &
```

### Adım 6: Geliştirme Sunucusunu Başlatın

```bash
php artisan serve
```

Uygulama şu adreste çalışacaktır: `http://localhost:8000`

### Adım 7: Queue Worker Durumu (Opsiyonel)

Eğer `app:set` komutu çalıştırılırken queue worker'ı başlatmadıysanız, mail gönderimlerinin çalışması için queue worker'ı manuel olarak başlatmanız gerekir.

**Yeni bir terminal penceresinde:**

```bash
php artisan queue:work
```

**Veya arka planda çalıştırmak için:**

```bash
php artisan queue:work --daemon &
```

**Queue worker'ın çalışıp çalışmadığını kontrol etmek için:**

```bash
# Process listesini kontrol edin
ps aux | grep "queue:work"

# Veya bir test maili gönderin ve jobs tablosunu kontrol edin
php artisan tinker
>>> App\Models\Order::first()->email;
```

**Production ortamında** Supervisor kullanmanız önerilir.

## 🚀 Kullanım

### 1. Etkinlik Listeleme

Ana sayfa (`/`) tüm etkinlikleri listeler. Arama çubuğunu kullanarak etkinlik, mekan veya sanatçı araması yapabilirsiniz.

### 2. Etkinlik Detayı

Bir etkinliğe tıkladığınızda:
- Etkinlik detaylarını görebilirsiniz
- Bilet kategorisi seçebilirsiniz
- Her kategorinin fiyat ve stok durumunu görebilirsiniz

### 3. Koltuk Seçimi

"Bilet Al" butonuna tıkladıktan sonra:
- Koltuk haritasında yeşil koltuklar müsait
- Gri koltuklar dolu
- Açık gri koltuklar başka kategoriye ait
- Manuel seçim: Koltuklara tıklayarak seçim yapın
- Otomatik seçim: Bilet sayısı girerek otomatik seçim yaptırın
- Zoom: +/- butonları ile haritayı büyütüp küçültebilirsiniz

### 4. Ödeme

Koltukları seçtikten sonra:
- Müşteri bilgilerini girin
- Kredi kartı bilgilerini girin (test amaçlı)
- Ödemeyi tamamlayın

### 5. Sipariş Onayı

Başarılı ödeme sonrası:
- Sipariş özeti görüntülenir
- E-posta adresinize onay maili gönderilir

## 📧 Mail Yapılandırması

### Mail Ayarları

Sistem asenkron mail gönderimi kullanır. Mail gönderimleri queue sistemine eklenir ve arka planda işlenir.

#### Queue Yapılandırması

`.env` dosyasında queue ayarlarını yapın:

```env
QUEUE_CONNECTION=database
```

#### Mailtrap Kullanımı

Test amaçlı mail gönderimleri için [Mailtrap](https://mailtrap.io):

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-mailtrap-username
MAIL_PASSWORD=your-mailtrap-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@bilet-sistemi.com
MAIL_FROM_NAME="${APP_NAME}"
```

Değişiklikleri uygulamak için:

```bash
php artisan config:clear
```

#### Queue Worker'ı Çalıştırma

Mail gönderimleri için queue worker'ın çalışıyor olması gerekir:

```bash
# Development ortamı için
php artisan queue:work

# Arka planda çalıştırma
php artisan queue:work --daemon &

# Belirli bir queue için
php artisan queue:work --queue=default,emails
```


## 🗄️ Veritabanı Yapısı

### Ana Tablolar

- **venues** - Etkinlik mekanları
- **events** - Etkinlikler
- **ticket_categories** - Bilet kategorileri
- **seats** - Koltuklar
- **orders** - Müşteri siparişleri
- **tickets** - Satılan biletler
- **payments** - Ödeme bilgileri
- **event_ticket_category** - Pivot tablo (etkinlik-kategori-fiyat)
- **jobs** - Queue işleri (mail gönderimleri vb.)
- **failed_jobs** - Başarısız queue işleri

### İlişkiler

```
venues 1 ──────→ * events
events * ──────→ * ticket_categories (pivot: event_ticket_category)
events 1 ──────→ * tickets
venues 1 ──────→ * seats
seats  1 ──────→ * tickets
orders 1 ──────→ * tickets
orders 1 ──────→ 1 payments
ticket_categories 1 ──────→ * tickets
```

### Örnek Veriler (Seeders)

Sistem şu örnek verilerle birlikte gelir:

**Mekanlar:**
- Zorlu PSM
- İş Sanat
- Cemal Reşit Rey
- Açıkhava Tiyatrosu

**Etkinlikler:**
- Sezen Aksu Konseri
- Teoman Konseri
- Tarkan Konseri
- Cem Yılmaz Stand-up
- Hamlet (Tiyatro)
- Kuğu Gölü (Bale)
- Film Gösterimleri

**Kategoriler:**
- VIP
- Genel Giriş
- Öğrenci
- Balkon

Her kategori için **40 koltuk** (4 section × 4 row × 10 seat)

## 📝 Önemli Notlar

### Stok Yönetimi

Sistem **gerçek zamanlı stok hesaplama** kullanır:

- ✅ Her kategori için maksimum 40 koltuk
- ✅ Satılan biletler `tickets` tablosundan sayılır
- ✅ Kalan stok = 40 - satılan bilet
- ✅ Soft delete: İptal edilen biletler stoka geri döner

### Çift Satış Önleme

- ✅ Backend'de koltuk müsaitlik kontrolü
- ✅ Database'de unique constraint (`event_id` + `seat_id`)
- ✅ Race condition koruması

### Tarih Formatı

Sistem Türkçe tarih formatı kullanır:
- "30 Ekim 2025 Perşembe - 20:00"

### Kod Standartları

- ✅ PHPDoc blokları
- ✅ Return type hints
- ✅ Camel case naming
- ✅ SOLID prensipleri
- ✅ Clean code practices

## 🎨 Özelleştirme

### Koltuk Sayısını Değiştirme

`app/Models/Event.php` dosyasında:

```php
public const SEATS_PER_CATEGORY = 40; // İstediğiniz sayıya değiştirin
```

Ardından seeder'ları güncelleyin ve veritabanını sıfırlayın:

```bash
php artisan app:set
```

### Yeni Bilet Kategorisi Ekleme

1. `database/seeders/TicketCategorySeeder.php` dosyasına yeni kategori ekleyin
2. `database/seeders/SeatSeeder.php` dosyasında section mapping ekleyin
3. `database/seeders/EventTicketCategorySeeder.php` dosyasında fiyatlandırma ekleyin

### Mail Template Özelleştirme

`resources/views/emails/order-confirmation.blade.php` dosyasını düzenleyin.

## 🐛 Sorun Giderme

### "Stock is 0 but tickets are available"

```bash
php artisan app:set
```

### "Duplicate seat purchase"

```bash
# Duplicate kayıtları temizle
php artisan tinker
# Tinker'da:
DB::table('tickets')->whereNotNull('seat_id')->groupBy('event_id', 'seat_id')->havingRaw('COUNT(*) > 1')->delete();
```

### "Mail not sending"

1. Queue worker'ın çalıştığından emin olun: `php artisan queue:work`
2. `.env` dosyasında mail ayarlarını kontrol edin
3. Queue connection'ını kontrol edin: `QUEUE_CONNECTION=database`
4. Config cache'i temizleyin: `php artisan config:clear`
5. Log dosyalarını kontrol edin:
   - `storage/logs/laravel.log` - Genel loglar
   - `jobs` tablosu - Bekleyen işler
   - `failed_jobs` tablosu - Başarısız işler

### "Queue jobs not processing"

```bash
# Queue worker'ı yeniden başlatın
php artisan queue:restart

# Failed jobs'ları yeniden deneyin
php artisan queue:retry all

# Failed jobs'ları temizleyin
php artisan queue:flush
```

## 📄 Lisans

Bu proje eğitim amaçlıdır.
