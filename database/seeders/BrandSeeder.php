<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            ['slug' => 'uomo', 'name' => ['en' => 'UOMO', 'az' => 'UOMO', 'ru' => 'UOMO'], 'logo_url' => 'https://logo.clearbit.com/uomo.com'],
            ['slug' => 'nike', 'name' => ['en' => 'Nike', 'az' => 'Nike', 'ru' => 'Nike'], 'logo_url' => 'https://logo.clearbit.com/nike.com'],
            ['slug' => 'adidas', 'name' => ['en' => 'Adidas', 'az' => 'Adidas', 'ru' => 'Adidas'], 'logo_url' => 'https://logo.clearbit.com/adidas.com'],
            ['slug' => 'puma', 'name' => ['en' => 'Puma', 'az' => 'Puma', 'ru' => 'Puma'], 'logo_url' => 'https://logo.clearbit.com/puma.com'],
            ['slug' => 'reebok', 'name' => ['en' => 'Reebok', 'az' => 'Reebok', 'ru' => 'Reebok'], 'logo_url' => 'https://logo.clearbit.com/reebok.com'],
            ['slug' => 'under-armour', 'name' => ['en' => 'Under Armour', 'az' => 'Under Armour', 'ru' => 'Under Armour'], 'logo_url' => 'https://logo.clearbit.com/underarmour.com'],
            ['slug' => 'converse', 'name' => ['en' => 'Converse', 'az' => 'Converse', 'ru' => 'Converse'], 'logo_url' => 'https://logo.clearbit.com/converse.com'],
            ['slug' => 'vans', 'name' => ['en' => 'Vans', 'az' => 'Vans', 'ru' => 'Vans'], 'logo_url' => 'https://logo.clearbit.com/vans.com'],
            ['slug' => 'new-balance', 'name' => ['en' => 'New Balance', 'az' => 'New Balance', 'ru' => 'New Balance'], 'logo_url' => 'https://logo.clearbit.com/newbalance.com'],
            ['slug' => 'asics', 'name' => ['en' => 'ASICS', 'az' => 'ASICS', 'ru' => 'ASICS'], 'logo_url' => 'https://logo.clearbit.com/asics.com'],
            ['slug' => 'fila', 'name' => ['en' => 'Fila', 'az' => 'Fila', 'ru' => 'Fila'], 'logo_url' => 'https://logo.clearbit.com/fila.com'],
            ['slug' => 'champion', 'name' => ['en' => 'Champion', 'az' => 'Champion', 'ru' => 'Champion'], 'logo_url' => 'https://logo.clearbit.com/champion.com'],
            ['slug' => 'levis', 'name' => ['en' => 'Levi\'s', 'az' => 'Levi\'s', 'ru' => 'Levi\'s'], 'logo_url' => 'https://logo.clearbit.com/levi.com'],
            ['slug' => 'calvin-klein', 'name' => ['en' => 'Calvin Klein', 'az' => 'Calvin Klein', 'ru' => 'Calvin Klein'], 'logo_url' => 'https://logo.clearbit.com/calvinklein.com'],
            ['slug' => 'tommy-hilfiger', 'name' => ['en' => 'Tommy Hilfiger', 'az' => 'Tommy Hilfiger', 'ru' => 'Tommy Hilfiger'], 'logo_url' => 'https://logo.clearbit.com/tommy.com'],
            ['slug' => 'ralph-lauren', 'name' => ['en' => 'Ralph Lauren', 'az' => 'Ralph Lauren', 'ru' => 'Ralph Lauren'], 'logo_url' => 'https://logo.clearbit.com/ralphlauren.com'],
            ['slug' => 'gucci', 'name' => ['en' => 'Gucci', 'az' => 'Gucci', 'ru' => 'Gucci'], 'logo_url' => 'https://logo.clearbit.com/gucci.com'],
            ['slug' => 'prada', 'name' => ['en' => 'Prada', 'az' => 'Prada', 'ru' => 'Prada'], 'logo_url' => 'https://logo.clearbit.com/prada.com'],
            ['slug' => 'versace', 'name' => ['en' => 'Versace', 'az' => 'Versace', 'ru' => 'Versace'], 'logo_url' => 'https://logo.clearbit.com/versace.com'],
            ['slug' => 'armani', 'name' => ['en' => 'Armani', 'az' => 'Armani', 'ru' => 'Armani'], 'logo_url' => 'https://logo.clearbit.com/armani.com'],
            ['slug' => 'diesel', 'name' => ['en' => 'Diesel', 'az' => 'Diesel', 'ru' => 'Diesel'], 'logo_url' => 'https://logo.clearbit.com/diesel.com'],
            ['slug' => 'hugo-boss', 'name' => ['en' => 'Hugo Boss', 'az' => 'Hugo Boss', 'ru' => 'Hugo Boss'], 'logo_url' => 'https://logo.clearbit.com/hugoboss.com'],
            ['slug' => 'lacoste', 'name' => ['en' => 'Lacoste', 'az' => 'Lacoste', 'ru' => 'Lacoste'], 'logo_url' => 'https://logo.clearbit.com/lacoste.com'],
            ['slug' => 'polo', 'name' => ['en' => 'Polo', 'az' => 'Polo', 'ru' => 'Polo'], 'logo_url' => 'https://logo.clearbit.com/ralphlauren.com'],
            ['slug' => 'zara', 'name' => ['en' => 'Zara', 'az' => 'Zara', 'ru' => 'Zara'], 'logo_url' => 'https://logo.clearbit.com/zara.com'],
            ['slug' => 'hm', 'name' => ['en' => 'H&M', 'az' => 'H&M', 'ru' => 'H&M'], 'logo_url' => 'https://logo.clearbit.com/hm.com'],
            ['slug' => 'uniqlo', 'name' => ['en' => 'Uniqlo', 'az' => 'Uniqlo', 'ru' => 'Uniqlo'], 'logo_url' => 'https://logo.clearbit.com/uniqlo.com'],
            ['slug' => 'gap', 'name' => ['en' => 'Gap', 'az' => 'Gap', 'ru' => 'Gap'], 'logo_url' => 'https://logo.clearbit.com/gap.com'],
            ['slug' => 'forever-21', 'name' => ['en' => 'Forever 21', 'az' => 'Forever 21', 'ru' => 'Forever 21'], 'logo_url' => 'https://logo.clearbit.com/forever21.com'],
            ['slug' => 'pull-and-bear', 'name' => ['en' => 'Pull & Bear', 'az' => 'Pull & Bear', 'ru' => 'Pull & Bear'], 'logo_url' => 'https://logo.clearbit.com/pullandbear.com'],
            ['slug' => 'bershka', 'name' => ['en' => 'Bershka', 'az' => 'Bershka', 'ru' => 'Bershka'], 'logo_url' => 'https://logo.clearbit.com/bershka.com'],
            ['slug' => 'stradivarius', 'name' => ['en' => 'Stradivarius', 'az' => 'Stradivarius', 'ru' => 'Stradivarius'], 'logo_url' => 'https://logo.clearbit.com/stradivarius.com'],
            ['slug' => 'mango', 'name' => ['en' => 'Mango', 'az' => 'Mango', 'ru' => 'Mango'], 'logo_url' => 'https://logo.clearbit.com/mango.com'],
            ['slug' => 'massimo-dutti', 'name' => ['en' => 'Massimo Dutti', 'az' => 'Massimo Dutti', 'ru' => 'Massimo Dutti'], 'logo_url' => 'https://logo.clearbit.com/massimodutti.com'],
            ['slug' => 'cos', 'name' => ['en' => 'COS', 'az' => 'COS', 'ru' => 'COS'], 'logo_url' => 'https://logo.clearbit.com/cos.com'],
            ['slug' => 'superdry', 'name' => ['en' => 'Superdry', 'az' => 'Superdry', 'ru' => 'Superdry'], 'logo_url' => 'https://logo.clearbit.com/superdry.com'],
            ['slug' => 'ellesse', 'name' => ['en' => 'Ellesse', 'az' => 'Ellesse', 'ru' => 'Ellesse'], 'logo_url' => 'https://logo.clearbit.com/ellesse.com'],
            ['slug' => 'kappa', 'name' => ['en' => 'Kappa', 'az' => 'Kappa', 'ru' => 'Kappa'], 'logo_url' => 'https://logo.clearbit.com/kappa.com'],
            ['slug' => 'umbro', 'name' => ['en' => 'Umbro', 'az' => 'Umbro', 'ru' => 'Umbro'], 'logo_url' => 'https://logo.clearbit.com/umbro.com'],
            ['slug' => 'diadora', 'name' => ['en' => 'Diadora', 'az' => 'Diadora', 'ru' => 'Diadora'], 'logo_url' => 'https://logo.clearbit.com/diadora.com'],
            ['slug' => 'lotto', 'name' => ['en' => 'Lotto', 'az' => 'Lotto', 'ru' => 'Lotto'], 'logo_url' => 'https://logo.clearbit.com/lotto.com'],
            ['slug' => 'joma', 'name' => ['en' => 'Joma', 'az' => 'Joma', 'ru' => 'Joma'], 'logo_url' => 'https://logo.clearbit.com/joma.com'],
            ['slug' => 'mizuno', 'name' => ['en' => 'Mizuno', 'az' => 'Mizuno', 'ru' => 'Mizuno'], 'logo_url' => 'https://logo.clearbit.com/mizuno.com'],
            ['slug' => 'saucony', 'name' => ['en' => 'Saucony', 'az' => 'Saucony', 'ru' => 'Saucony'], 'logo_url' => 'https://logo.clearbit.com/saucony.com'],
            ['slug' => 'brooks', 'name' => ['en' => 'Brooks', 'az' => 'Brooks', 'ru' => 'Brooks'], 'logo_url' => 'https://logo.clearbit.com/brooksrunning.com'],
            ['slug' => 'skechers', 'name' => ['en' => 'Skechers', 'az' => 'Skechers', 'ru' => 'Skechers'], 'logo_url' => 'https://logo.clearbit.com/skechers.com'],
            ['slug' => 'clarks', 'name' => ['en' => 'Clarks', 'az' => 'Clarks', 'ru' => 'Clarks'], 'logo_url' => 'https://logo.clearbit.com/clarks.com'],
            ['slug' => 'ecco', 'name' => ['en' => 'ECCO', 'az' => 'ECCO', 'ru' => 'ECCO'], 'logo_url' => 'https://logo.clearbit.com/ecco.com'],
            ['slug' => 'timberland', 'name' => ['en' => 'Timberland', 'az' => 'Timberland', 'ru' => 'Timberland'], 'logo_url' => 'https://logo.clearbit.com/timberland.com'],
            ['slug' => 'cat', 'name' => ['en' => 'CAT', 'az' => 'CAT', 'ru' => 'CAT'], 'logo_url' => 'https://logo.clearbit.com/cat.com'],
            ['slug' => 'dr-martens', 'name' => ['en' => 'Dr. Martens', 'az' => 'Dr. Martens', 'ru' => 'Dr. Martens'], 'logo_url' => 'https://logo.clearbit.com/drmartens.com'],
            ['slug' => 'red-wing', 'name' => ['en' => 'Red Wing', 'az' => 'Red Wing', 'ru' => 'Red Wing'], 'logo_url' => 'https://logo.clearbit.com/redwingshoes.com'],
            ['slug' => 'wolverine', 'name' => ['en' => 'Wolverine', 'az' => 'Wolverine', 'ru' => 'Wolverine'], 'logo_url' => 'https://logo.clearbit.com/wolverine.com'],
            ['slug' => 'merrell', 'name' => ['en' => 'Merrell', 'az' => 'Merrell', 'ru' => 'Merrell'], 'logo_url' => 'https://logo.clearbit.com/merrell.com'],
            ['slug' => 'salomon', 'name' => ['en' => 'Salomon', 'az' => 'Salomon', 'ru' => 'Salomon'], 'logo_url' => 'https://logo.clearbit.com/salomon.com'],
            ['slug' => 'the-north-face', 'name' => ['en' => 'The North Face', 'az' => 'The North Face', 'ru' => 'The North Face'], 'logo_url' => 'https://logo.clearbit.com/thenorthface.com'],
            ['slug' => 'columbia', 'name' => ['en' => 'Columbia', 'az' => 'Columbia', 'ru' => 'Columbia'], 'logo_url' => 'https://logo.clearbit.com/columbia.com'],
            ['slug' => 'patagonia', 'name' => ['en' => 'Patagonia', 'az' => 'Patagonia', 'ru' => 'Patagonia'], 'logo_url' => 'https://logo.clearbit.com/patagonia.com'],
            ['slug' => 'arc-teryx', 'name' => ['en' => 'Arc\'teryx', 'az' => 'Arc\'teryx', 'ru' => 'Arc\'teryx'], 'logo_url' => 'https://logo.clearbit.com/arcteryx.com'],
            ['slug' => 'marmot', 'name' => ['en' => 'Marmot', 'az' => 'Marmot', 'ru' => 'Marmot'], 'logo_url' => 'https://logo.clearbit.com/marmot.com'],
            ['slug' => 'mammut', 'name' => ['en' => 'Mammut', 'az' => 'Mammut', 'ru' => 'Mammut'], 'logo_url' => 'https://logo.clearbit.com/mammut.com'],
            ['slug' => 'jack-wolfskin', 'name' => ['en' => 'Jack Wolfskin', 'az' => 'Jack Wolfskin', 'ru' => 'Jack Wolfskin'], 'logo_url' => 'https://logo.clearbit.com/jack-wolfskin.com'],
            ['slug' => 'berghaus', 'name' => ['en' => 'Berghaus', 'az' => 'Berghaus', 'ru' => 'Berghaus'], 'logo_url' => 'https://logo.clearbit.com/berghaus.com'],
            ['slug' => 'lowa', 'name' => ['en' => 'Lowa', 'az' => 'Lowa', 'ru' => 'Lowa'], 'logo_url' => 'https://logo.clearbit.com/lowa.com'],
            ['slug' => 'la-sportiva', 'name' => ['en' => 'La Sportiva', 'az' => 'La Sportiva', 'ru' => 'La Sportiva'], 'logo_url' => 'https://logo.clearbit.com/lasportiva.com'],
            ['slug' => 'scarpa', 'name' => ['en' => 'Scarpa', 'az' => 'Scarpa', 'ru' => 'Scarpa'], 'logo_url' => 'https://logo.clearbit.com/scarpa.com'],
            ['slug' => 'five-ten', 'name' => ['en' => 'Five Ten', 'az' => 'Five Ten', 'ru' => 'Five Ten'], 'logo_url' => 'https://logo.clearbit.com/fiveten.com'],
            ['slug' => 'evolv', 'name' => ['en' => 'Evolv', 'az' => 'Evolv', 'ru' => 'Evolv'], 'logo_url' => 'https://logo.clearbit.com/evolvsports.com'],
            ['slug' => 'black-diamond', 'name' => ['en' => 'Black Diamond', 'az' => 'Black Diamond', 'ru' => 'Black Diamond'], 'logo_url' => 'https://logo.clearbit.com/blackdiamondequipment.com'],
            ['slug' => 'petzl', 'name' => ['en' => 'Petzl', 'az' => 'Petzl', 'ru' => 'Petzl'], 'logo_url' => 'https://logo.clearbit.com/petzl.com'],
            ['slug' => 'grivel', 'name' => ['en' => 'Grivel', 'az' => 'Grivel', 'ru' => 'Grivel'], 'logo_url' => 'https://logo.clearbit.com/grivel.com'],
            ['slug' => 'camp', 'name' => ['en' => 'CAMP', 'az' => 'CAMP', 'ru' => 'CAMP'], 'logo_url' => 'https://logo.clearbit.com/camp-usa.com'],
            ['slug' => 'edelrid', 'name' => ['en' => 'Edelrid', 'az' => 'Edelrid', 'ru' => 'Edelrid'], 'logo_url' => 'https://logo.clearbit.com/edelrid.de'],
            ['slug' => 'beal', 'name' => ['en' => 'Beal', 'az' => 'Beal', 'ru' => 'Beal'], 'logo_url' => 'https://logo.clearbit.com/beal-planet.com'],
            ['slug' => 'metolius', 'name' => ['en' => 'Metolius', 'az' => 'Metolius', 'ru' => 'Metolius'], 'logo_url' => 'https://logo.clearbit.com/metoliusclimbing.com'],
            ['slug' => 'trango', 'name' => ['en' => 'Trango', 'az' => 'Trango', 'ru' => 'Trango'], 'logo_url' => 'https://logo.clearbit.com/trango.com'],
            ['slug' => 'wild-country', 'name' => ['en' => 'Wild Country', 'az' => 'Wild Country', 'ru' => 'Wild Country'], 'logo_url' => 'https://logo.clearbit.com/wildcountry.co.uk'],
            ['slug' => 'dmm', 'name' => ['en' => 'DMM', 'az' => 'DMM', 'ru' => 'DMM'], 'logo_url' => 'https://logo.clearbit.com/dmmclimbing.com'],
            ['slug' => 'kong', 'name' => ['en' => 'Kong', 'az' => 'Kong', 'ru' => 'Kong'], 'logo_url' => 'https://logo.clearbit.com/kong.it'],
            ['slug' => 'singing-rock', 'name' => ['en' => 'Singing Rock', 'az' => 'Singing Rock', 'ru' => 'Singing Rock'], 'logo_url' => 'https://logo.clearbit.com/singingrock.com'],
            ['slug' => 'lanex', 'name' => ['en' => 'Lanex', 'az' => 'Lanex', 'ru' => 'Lanex'], 'logo_url' => 'https://logo.clearbit.com/lanex.cz'],
            ['slug' => 'climbing-technology', 'name' => ['en' => 'Climbing Technology', 'az' => 'Climbing Technology', 'ru' => 'Climbing Technology'], 'logo_url' => 'https://logo.clearbit.com/climbingtechnology.com'],
            ['slug' => 'mad-rock', 'name' => ['en' => 'Mad Rock', 'az' => 'Mad Rock', 'ru' => 'Mad Rock'], 'logo_url' => 'https://logo.clearbit.com/madrock.com'],
            ['slug' => 'organic', 'name' => ['en' => 'Organic', 'az' => 'Organic', 'ru' => 'Organic'], 'logo_url' => 'https://logo.clearbit.com/organicclimbing.com'],
            ['slug' => 'boreal', 'name' => ['en' => 'Boreal', 'az' => 'Boreal', 'ru' => 'Boreal'], 'logo_url' => 'https://logo.clearbit.com/boreal.com'],
            ['slug' => 'tenaya', 'name' => ['en' => 'Tenaya', 'az' => 'Tenaya', 'ru' => 'Tenaya'], 'logo_url' => 'https://logo.clearbit.com/tenayausa.com'],
            ['slug' => 'unparallel', 'name' => ['en' => 'Unparallel', 'az' => 'Unparallel', 'ru' => 'Unparallel'], 'logo_url' => 'https://logo.clearbit.com/unparallelclimbing.com'],
            ['slug' => 'butora', 'name' => ['en' => 'Butora', 'az' => 'Butora', 'ru' => 'Butora'], 'logo_url' => 'https://logo.clearbit.com/butora.com'],
            ['slug' => 'ocun', 'name' => ['en' => 'Ocun', 'az' => 'Ocun', 'ru' => 'Ocun'], 'logo_url' => 'https://logo.clearbit.com/ocun.cz'],
            ['slug' => 'red-chili', 'name' => ['en' => 'Red Chili', 'az' => 'Red Chili', 'ru' => 'Red Chili'], 'logo_url' => 'https://logo.clearbit.com/redchili.de'],
        ];

        foreach ($brands as $index => $brandData) {
            // Brand verilerini hazırla
            $name = $brandData['name']['en'];
            $slug = $brandData['slug'];
            $logoUrl = $brandData['logo_url'] ?? null;
            
            $data = [
                'slug' => $slug,
                'name' => $brandData['name'],
                'description' => [
                    'en' => "Premium quality products from {$name}",
                    'az' => "{$name} markasından premium keyfiyyətli məhsullar",
                    'ru' => "Продукция премиум-качества от {$name}"
                ],
                'meta_title' => [
                    'en' => "{$name} - Premium Products",
                    'az' => "{$name} - Premium Məhsullar",
                    'ru' => "{$name} - Премиум Продукция"
                ],
                'meta_description' => [
                    'en' => "Discover the latest collection from {$name}.",
                    'az' => "{$name} markasından ən son kolleksiyanı kəşf edin.",
                    'ru' => "Откройте для себя последнюю коллекцию от {$name}."
                ],
                'social_links' => [
                    'facebook' => "https://facebook.com/{$slug}",
                    'instagram' => "https://instagram.com/{$slug}",
                    'twitter' => "https://twitter.com/{$slug}",
                ],
                'website' => "https://{$slug}.example.com",
                'is_active' => true,
            ];

            // Brand'i oluştur veya güncelle
            $brand = Brand::updateOrCreate(['slug' => $slug], $data);

            // Logo ekle (internetten indir)
            if ($logoUrl && !$brand->hasMedia('logo')) {
                try {
                    // Logo URL'inden indir ve media library'ye ekle
                    $brand->addMediaFromUrl($logoUrl)
                        ->toMediaCollection('logo');
                    
                    $this->command->info("✓ Logo indirildi: {$name}");
                } catch (\Exception $e) {
                    // Logo indirme başarısız olursa, placeholder logo kullan
                    $fallbackLogoUrl = $this->getPlaceholderLogo($name, $index);
                    try {
                        $brand->addMediaFromUrl($fallbackLogoUrl)
                            ->toMediaCollection('logo');
                        $this->command->warn("⚠ Logo indirilemedi, placeholder kullanıldı: {$name}");
                    } catch (\Exception $e2) {
                        Log::warning("Brand logo indirilemedi: {$slug} - {$e2->getMessage()}");
                        $this->command->error("✗ Logo indirilemedi: {$name}");
                    }
                }
            }
        }
    }

    /**
     * Placeholder logo URL'i oluştur
     */
    private function getPlaceholderLogo(string $name, int $index): string
    {
        // Farklı renklerde placeholder logolar oluştur
        $colors = [
            ['bg' => '3498db', 'text' => 'ffffff'], // Mavi
            ['bg' => 'e74c3c', 'text' => 'ffffff'], // Kırmızı
            ['bg' => '2ecc71', 'text' => 'ffffff'], // Yeşil
            ['bg' => 'f39c12', 'text' => 'ffffff'], // Turuncu
            ['bg' => '9b59b6', 'text' => 'ffffff'], // Mor
            ['bg' => '1abc9c', 'text' => 'ffffff'], // Turkuaz
            ['bg' => '34495e', 'text' => 'ffffff'], // Koyu gri
        ];
        
        $color = $colors[$index % count($colors)];
        $initial = strtoupper(substr($name, 0, 1));
        
        return "https://via.placeholder.com/300x150/{$color['bg']}/{$color['text']}?text={$initial}";
    }
}
