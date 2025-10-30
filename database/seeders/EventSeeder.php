<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $events = [
            [
                'venue_id' => 1,
                'title' => 'Sezen Aksu Konseri',
                'description' => 'Türk Pop Müziğinin kraliçesi Sezen Aksu, unutulmaz bir konser ile sizlerle! 
                En sevilen şarkılarını seslendireceği bu özel gecede, izleyenlere duygusal anlar ve coşku dolu dakikalar yaşatacak. 
                Müzik dolu bir geceye hazır olun.',
                'image_url' => 'https://images.unsplash.com/photo-1470229722913-7c0e2dbbafd3?w=800',
                'event_date' => now()->addDays(15)->setTime(20, 0),
            ],
            [
                'venue_id' => 2,
                'title' => 'Cem Yılmaz Stand-Up',
                'description' => 'Cem Yılmaz\'ın yeni gösterisi ile kahkaha dolu bir gece! 
                Gündelik hayatın içinden gözlemleri, hiciv dolu esprileri ve eşsiz sahne enerjisiyle izleyicilere unutulmaz anlar yaşatacak. 
                Türkiye\'nin en çok konuşulan komedyeninden yepyeni bir performans!',
                'image_url' => 'https://images.unsplash.com/photo-1585699324551-f6c309eedeca?w=800',
                'event_date' => now()->addDays(20)->setTime(21, 0),
            ],
            [
                'venue_id' => 4,
                'title' => 'Teoman Akustik Konser',
                'description' => 'Rock müziğin güçlü sesi Teoman, bu kez akustik bir konserle sahnede! 
                En sevilen parçalarını sade ama etkileyici bir atmosferde seslendirecek. 
                Şehrin en özel mekânlarından birinde gerçekleşecek bu performans, müzikseverlerin kaçırmak istemeyeceği bir deneyim olacak.',
                'image_url' => 'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=800',
                'event_date' => now()->addDays(25)->setTime(20, 30),
            ],
            [
                'venue_id' => 3,
                'title' => 'Dune: Part Two - Film Gösterimi',
                'description' => 'Denis Villeneuve\'nin efsanevi bilim kurgu serisinin devam filmi Dune: Part Two büyük ekranda! 
                Görsel şöleni, derin hikayesi ve etkileyici oyunculuklarıyla yılın en çok beklenen filmi sinema tutkunlarını büyüleyecek.',
                'image_url' => 'https://images.unsplash.com/photo-1536440136628-849c177e76a1?w=800',
                'event_date' => now()->addDays(30)->setTime(19, 0),
            ],
            [
                'venue_id' => 2,
                'title' => 'Tarkan Konseri',
                'description' => 'Mega Star Tarkan, en sevilen şarkılarıyla sahnede! 
                Muhteşem sahne şovu, dansları ve canlı performansıyla dinleyicilere unutulmaz bir gece yaşatacak. 
                Bu enerji dolu konseri kaçırmayın!',
                'image_url' => 'https://images.unsplash.com/photo-1514320291840-2e0a9bf2a9ae?w=800',
                'event_date' => now()->addDays(35)->setTime(21, 0),
            ],
            [
                'venue_id' => 1,
                'title' => 'Devlet Tiyatroları - Hamlet',
                'description' => 'Shakespeare\'in ölümsüz eseri Hamlet, modern yorumuyla yeniden sahnede. 
                Güçlü oyuncu kadrosu, çağdaş sahne tasarımı ve etkileyici atmosferiyle izleyicileri klasik tiyatronun büyüsüne davet ediyor.',
                'image_url' => 'https://images.unsplash.com/photo-1503095396549-807759245b35?w=800',
                'event_date' => now()->addDays(40)->setTime(20, 0),
            ],
            [
                'venue_id' => 4,
                'title' => 'İstanbul Senfoni Orkestrası',
                'description' => 'Dünya çapında solistlerle klasik müziğin büyüsüne kapılın. 
                İstanbul Senfoni Orkestrası, seçkin repertuvarı ve kusursuz icrası ile sanatseverlere unutulmaz bir müzik ziyafeti sunacak. 
                Klasik müzik tutkunları için eşsiz bir akşam!',
                'image_url' => 'https://images.unsplash.com/photo-1519683384663-34c6d29471b7?w=800',
                'event_date' => now()->addDays(45)->setTime(19, 30),
            ],
            [
                'venue_id' => 2,
                'title' => 'Bale Gösterisi - Kuğu Gölü',
                'description' => 'Çaykovski\'nin başyapıtı Kuğu Gölü, büyüleyici koreografisiyle yeniden sahnede. 
                Zarif danslar, dramatik müzik ve görkemli kostümlerle bale sanatının en etkileyici örneklerinden biri sizi bekliyor.',
                'image_url' => 'https://images.unsplash.com/photo-1518834107812-67b0b7c58434?w=800',
                'event_date' => now()->addDays(50)->setTime(20, 0),
            ],
            [
                'venue_id' => 5,
                'title' => 'Oppenheimer - Özel Gösterim',
                'description' => 'Christopher Nolan\'ın Oscar ödüllü filmi Oppenheimer, sinemaseverlerle özel bir gösterimde buluşuyor. 
                Görsel açıdan büyüleyici bu yapım, tarihin en kritik anlarından birine derin bir bakış sunuyor.',
                'image_url' => 'https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?w=800',
                'event_date' => now()->addDays(55)->setTime(20, 30),
            ],
            [
                'venue_id' => 3,
                'title' => 'Yeşilçam Klasikleri Maratonu',
                'description' => 'Türk sinemasının unutulmaz filmleri arka arkaya! 
                Hababam Sınıfı\'ndan Selvi Boylum Al Yazmalım\'a kadar birçok klasik, sinema perdesinde nostaljik bir yolculuk sunacak.',
                'image_url' => 'https://images.unsplash.com/photo-1478720568477-152d9b164e26?w=800',
                'event_date' => now()->addDays(60)->setTime(18, 0),
            ],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
}
