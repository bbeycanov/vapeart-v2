<?php

namespace Database\Seeders;

use App\Services\Settings;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $svc = app(Settings::class);

        $svc->set('site.title', [
            'az' => 'VapeArt Baku',
            'en' => 'VapeArt Baku',
            'ru' => 'VapeArt Baku',
        ]);

        $svc->set('site.description', [
            'az' => 'VapeArt Baku - Bakıda elektron siqaretlər, vape cihazları, snus və premium tütün məhsulları mağazası. Pulsuz çatdırılma, keyfiyyət zəmanəti.',
            'en' => 'VapeArt Baku - Electronic cigarettes, vape devices, snus and premium tobacco products store in Baku. Free delivery, quality guarantee.',
            'ru' => 'VapeArt Baku - Магазин электронных сигарет, вейп устройств, снюса и премиальных табачных изделий в Баку. Бесплатная доставка, гарантия качества.',
        ]);

        $svc->set('site.keywords', [
            'az' => 'vape, elektron siqaret, snus, tütün, vape baku, elfbar, vozol, hqd, nikotin',
            'en' => 'vape, electronic cigarette, snus, tobacco, vape baku, elfbar, vozol, hqd, nicotine',
            'ru' => 'вейп, электронная сигарета, снюс, табак, вейп баку, elfbar, vozol, hqd, никотин',
        ]);

        $svc->set('site.og_image', '/storefront/images/og-image.jpg');

        $svc->set('site.email', [
            'az' => 'info@vapeartbaku.com',
            'en' => 'info@vapeartbaku.com',
            'ru' => 'info@vapeartbaku.com',
        ]);

        $svc->set('site.phone', [
            'az' => '+1 246-345-0695',
            'en' => '+1 246-345-0695',
            'ru' => '+1 246-345-0695',
        ]);

        $svc->set('site.address', [
            'az' => '1418 River Drive, Suite 35 Cottonhall, CA 9622 United States',
            'en' => '1418 River Drive, Suite 35 Cottonhall, CA 9622 United States',
            'ru' => '1418 River Drive, Suite 35 Cottonhall, CA 9622 United States',
        ]);

        $svc->set('facebook', [
            'az' => 'https://www.facebook.com',
            'en' => 'https://www.facebook.com',
            'ru' => 'https://www.facebook.com',
        ]);

        $svc->set('instagram', [
            'az' => 'https://www.instagram.com',
            'en' => 'https://www.instagram.com',
            'ru' => 'https://www.instagram.com',
        ]);

        $svc->set('twitter', [
            'az' => 'https://www.twitter.com',
            'en' => 'https://www.twitter.com',
            'ru' => 'https://www.twitter.com',
        ]);

        $svc->set('linkedin', [
            'az' => 'https://www.linkedin.com',
            'en' => 'https://www.linkedin.com',
            'ru' => 'https://www.linkedin.com',
        ]);

        $svc->set('youtube', [
            'az' => 'https://www.youtube.com',
            'en' => 'https://www.youtube.com',
            'ru' => 'https://www.youtube.com',
        ]);

        $svc->set('pinterest', [
            'az' => 'https://www.pinterest.com',
            'en' => 'https://www.pinterest.com',
            'ru' => 'https://www.pinterest.com',
        ]);

        $svc->set('tiktok', [
            'az' => 'https://www.tiktok.com',
            'en' => 'https://www.tiktok.com',
            'ru' => 'https://www.tiktok.com',
        ]);

        // Age Verification Modal - Boolean value (not translatable)
        $svc->set('age_verification_enabled', true);
    }
}
