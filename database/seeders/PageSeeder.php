<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // About Us Page
        Page::updateOrCreate(
            ['slug' => 'about-us'],
            [
                'template' => 'default',
                'title' => [
                    'az' => 'Haqqımızda',
                    'en' => 'About Us',
                    'ru' => 'О нас'
                ],
                'excerpt' => [
                    'az' => 'Vape Art Premium - Bakıda peşəkar vape və tütün məhsulları mağazası',
                    'en' => 'Vape Art Premium - Professional vape and tobacco shop in Baku',
                    'ru' => 'Vape Art Premium - Профессиональный магазин вейпов и табачных изделий в Баку'
                ],
                'body' => [
                    'az' => '<p><strong>Vape Art Premium</strong> elektron siqaretlər, snus nikotin paketləri, qəlyan tütünü, sarma tütünü, siqarlar və premium alışqanlar təklif edən ixtisaslaşmış mağazadır. Mağazamız müştəri seçimlərinə uyğun keyfiyyətli məhsullar təqdim etməyi hədəfləyir.</p>

<h3>Məhsul Kateqoriyaları</h3>
<ul>
<li><strong>Birdəfəlik e-siqaretlər</strong> - Elfbar, Vozol, HQD, Plonq brendləri</li>
<li><strong>Duz nikotinli mayelər</strong> - 10ml və 30ml həcmlərdə</li>
<li><strong>SNUS məhsulları</strong> - Fedrs, Siberia, Odens, Iceberg, VELO</li>
<li><strong>Qəlyan və sarma tütünü</strong></li>
<li><strong>Siqarlar və sigarillolar</strong></li>
<li><strong>Premium alışqanlar</strong> - Clipper və Zippo brendləri</li>
</ul>

<h3>Mağaza Ünvanları</h3>
<p><strong>Gənclik filialı:</strong> Akademik Həsən Əliyev 117<br>
<strong>28 May filialı:</strong> Dilara Əliyeva küçəsi 225</p>

<p>Mağazamız yerində konsultasiya xidməti göstərir və sifarişləri Wolt platforması vasitəsilə çatdırır.</p>

<p><strong>İş saatları:</strong> Hər gün 11:00-23:00</p>',
                    'en' => '<p><strong>Vape Art Premium</strong> is a specialized retail store offering electronic cigarettes, nicotine pouches (snus), hookah tobacco, rolling tobacco, cigars, and premium lighters. Our store aims to provide quality products aligned with customer preferences.</p>

<h3>Product Categories</h3>
<ul>
<li><strong>Disposable e-cigarettes</strong> - Elfbar, Vozol, HQD, Plonq brands</li>
<li><strong>Salt nicotine liquids</strong> - 10ml and 30ml volumes</li>
<li><strong>SNUS products</strong> - Fedrs, Siberia, Odens, Iceberg, VELO</li>
<li><strong>Hookah and rolling tobacco</strong></li>
<li><strong>Cigars and cigarillos</strong></li>
<li><strong>Premium lighters</strong> - Clipper and Zippo brands</li>
</ul>

<h3>Store Locations</h3>
<p><strong>Ganjlik branch:</strong> Akademik Hasan Aliyev 117<br>
<strong>28 May branch:</strong> Dilara Aliyeva Street 225</p>

<p>Our store provides in-store consultation and delivers orders through the Wolt platform.</p>

<p><strong>Working hours:</strong> Daily 11:00-23:00</p>',
                    'ru' => '<p><strong>Vape Art Premium</strong> — это специализированный магазин, предлагающий электронные сигареты, никотиновые пакетики (снюс), кальянный табак, табак для самокруток, сигары и премиальные зажигалки. Мы продаём только оригинальную продукцию известных брендов.</p>

<h3>Категории товаров</h3>
<ul>
<li><strong>Одноразовые электронные сигареты</strong> - бренды Elfbar, Vozol, HQD, Plonq</li>
<li><strong>Солевые никотиновые жидкости</strong> - объёмы 10мл и 30мл</li>
<li><strong>SNUS продукция</strong> - Fedrs, Siberia, Odens, Iceberg, VELO</li>
<li><strong>Кальянный и табак для самокруток</strong></li>
<li><strong>Сигары и сигариллы</strong></li>
<li><strong>Премиальные зажигалки</strong> - бренды Clipper и Zippo</li>
</ul>

<h3>Адреса магазинов</h3>
<p><strong>Филиал Гянджлик:</strong> Академика Гасана Алиева 117<br>
<strong>Филиал 28 Мая:</strong> улица Дилары Алиевой 225</p>

<p>Наш магазин предоставляет консультации на месте и доставляет заказы через платформу Wolt.</p>

<p><strong>Часы работы:</strong> Ежедневно 11:00-23:00</p>'
                ],
                'meta_title' => [
                    'az' => 'Haqqımızda | VapeArt Baku',
                    'en' => 'About Us | VapeArt Baku',
                    'ru' => 'О нас | VapeArt Baku'
                ],
                'meta_description' => [
                    'az' => 'Vape Art Premium - Bakıda elektron siqaretlər, snus, qəlyan tütünü və premium alışqanlar təklif edən ixtisaslaşmış mağaza.',
                    'en' => 'Vape Art Premium - Specialized store in Baku offering electronic cigarettes, snus, hookah tobacco and premium lighters.',
                    'ru' => 'Vape Art Premium - Специализированный магазин в Баку, предлагающий электронные сигареты, снюс, кальянный табак и премиальные зажигалки.'
                ],
                'is_active' => true,
                'sort_order' => 1,
            ]
        );

        // Delivery Page
        Page::updateOrCreate(
            ['slug' => 'delivery'],
            [
                'template' => 'default',
                'title' => [
                    'az' => 'Çatdırılma',
                    'en' => 'Delivery',
                    'ru' => 'Доставка'
                ],
                'excerpt' => [
                    'az' => 'Çatdırılma şərtləri və qaydaları',
                    'en' => 'Delivery terms and conditions',
                    'ru' => 'Условия и правила доставки'
                ],
                'body' => [
                    'az' => '<p>Məhsullar kuryer xidməti vasitəsilə çatdırılır.</p>

<h3>Çatdırılma Şərtləri</h3>
<ul>
<li><strong>Pulsuz çatdırılma:</strong> 150 AZN-dən yuxarı sifarişlər şəhər daxilində yaxın məsafələrə pulsuz çatdırılır.</li>
<li><strong>Şəhərdənkənar çatdırılma:</strong> Məsafəyə görə ödənişlidir.</li>
<li><strong>Eyni gün çatdırılma:</strong> Saat 11:00-17:30 arasında verilən sifarişlər eyni gün çatdırılır.</li>
</ul>

<p>Çatdırılma ilə bağlı suallarınız üçün bizimlə əlaqə saxlayın.</p>',
                    'en' => '<p>Products are delivered via courier service.</p>

<h3>Delivery Terms</h3>
<ul>
<li><strong>Free delivery:</strong> Orders over 150 AZN are delivered free within the city for nearby distances.</li>
<li><strong>Out-of-city delivery:</strong> Charged based on distance.</li>
<li><strong>Same-day delivery:</strong> Orders placed between 11:00-17:30 are delivered the same day.</li>
</ul>

<p>Contact us for any questions regarding delivery.</p>',
                    'ru' => '<p>Товары доставляются курьерской службой.</p>

<h3>Условия доставки</h3>
<ul>
<li><strong>Бесплатная доставка:</strong> Заказы свыше 150 AZN в пределах города на близкие расстояния доставляются бесплатно.</li>
<li><strong>Доставка за город:</strong> Оплачивается в зависимости от расстояния.</li>
<li><strong>Доставка в тот же день:</strong> Заказы, оформленные с 11:00 до 17:30, доставляются в тот же день.</li>
</ul>

<p>Свяжитесь с нами по любым вопросам, касающимся доставки.</p>'
                ],
                'meta_title' => [
                    'az' => 'Çatdırılma | VapeArt Baku',
                    'en' => 'Delivery | VapeArt Baku',
                    'ru' => 'Доставка | VapeArt Baku'
                ],
                'meta_description' => [
                    'az' => 'VapeArt Baku çatdırılma şərtləri. 150 AZN-dən yuxarı sifarişlərə pulsuz çatdırılma.',
                    'en' => 'VapeArt Baku delivery terms. Free delivery for orders over 150 AZN.',
                    'ru' => 'Условия доставки VapeArt Baku. Бесплатная доставка для заказов свыше 150 AZN.'
                ],
                'is_active' => true,
                'sort_order' => 2,
            ]
        );

        // Payment Methods Page
        Page::updateOrCreate(
            ['slug' => 'payment-methods'],
            [
                'template' => 'default',
                'title' => [
                    'az' => 'Ödəniş üsulları',
                    'en' => 'Payment Methods',
                    'ru' => 'Способы оплаты'
                ],
                'excerpt' => [
                    'az' => 'Mövcud ödəniş üsulları',
                    'en' => 'Available payment methods',
                    'ru' => 'Доступные способы оплаты'
                ],
                'body' => [
                    'az' => '<h3>Ödəniş Üsulları</h3>

<ul>
<li><strong>Qapıda ödəniş:</strong> Məhsul ünvanınıza çatdırıldıqda nağd ödəniş edə bilərsiniz.</li>
<li><strong>Mağazada ödəniş:</strong> Fiziki mağazamızda nağd və ya kart terminalı ilə ödəniş edə bilərsiniz.</li>
<li><strong>Taksit:</strong> Bir kart vasitəsi ilə öz qiymətinə aylara bölüb, əlavə faiz ödəmədən əldə edə bilərsiniz.</li>
</ul>',
                    'en' => '<h3>Payment Methods</h3>

<ul>
<li><strong>Cash on Delivery:</strong> Pay in cash when the product arrives at your address.</li>
<li><strong>In-Store Payment:</strong> Pay with cash or card terminal at our physical store location.</li>
<li><strong>Installment Plans:</strong> Divide your purchase into monthly installments without additional interest charges using a card.</li>
</ul>',
                    'ru' => '<h3>Способы оплаты</h3>

<ul>
<li><strong>Оплата при доставке:</strong> Оплатите наличными при получении товара по вашему адресу.</li>
<li><strong>Оплата в магазине:</strong> Оплатите наличными или картой через терминал в нашем магазине.</li>
<li><strong>Рассрочка:</strong> Разделите покупку на ежемесячные платежи без дополнительных процентов с помощью карты.</li>
</ul>'
                ],
                'meta_title' => [
                    'az' => 'Ödəniş üsulları | VapeArt Baku',
                    'en' => 'Payment Methods | VapeArt Baku',
                    'ru' => 'Способы оплаты | VapeArt Baku'
                ],
                'meta_description' => [
                    'az' => 'VapeArt Baku ödəniş üsulları - nağd, kart və taksit seçimləri.',
                    'en' => 'VapeArt Baku payment methods - cash, card and installment options.',
                    'ru' => 'Способы оплаты VapeArt Baku - наличные, карта и рассрочка.'
                ],
                'is_active' => true,
                'sort_order' => 3,
            ]
        );

        // Guarantee Page
        Page::updateOrCreate(
            ['slug' => 'guarantee'],
            [
                'template' => 'default',
                'title' => [
                    'az' => 'Zəmanət',
                    'en' => 'Guarantee',
                    'ru' => 'Гарантия'
                ],
                'excerpt' => [
                    'az' => 'Zəmanət şərtləri',
                    'en' => 'Warranty terms',
                    'ru' => 'Условия гарантии'
                ],
                'body' => [
                    'az' => '<h3>Zəmanət Şərtləri</h3>

<p>Bütün Vape cihazları satın alındığı tarixdən <strong>2 həftə ərzində</strong> zəmanət verilir.</p>

<p>Zəmanət istismar şərtlərinə uyğun olaraq <strong>istehsal qüsurlarını</strong> əhatə edir.</p>

<p>Zəmanət müddəti ərzində hər hansı bir problem yaşasanız, mağazamıza müraciət edə bilərsiniz.</p>',
                    'en' => '<h3>Warranty Terms</h3>

<p>All Vape devices are guaranteed for <strong>2 weeks</strong> from the date of purchase.</p>

<p>The warranty covers <strong>manufacturing defects</strong> under normal operating conditions.</p>

<p>If you experience any issues during the warranty period, please contact our store.</p>',
                    'ru' => '<h3>Условия гарантии</h3>

<p>На все Vape устройства предоставляется гарантия <strong>2 недели</strong> с даты покупки.</p>

<p>Гарантия распространяется на <strong>производственные дефекты</strong> при соблюдении условий эксплуатации.</p>

<p>Если у вас возникнут какие-либо проблемы в течение гарантийного срока, обратитесь в наш магазин.</p>'
                ],
                'meta_title' => [
                    'az' => 'Zəmanət | VapeArt Baku',
                    'en' => 'Guarantee | VapeArt Baku',
                    'ru' => 'Гарантия | VapeArt Baku'
                ],
                'meta_description' => [
                    'az' => 'VapeArt Baku zəmanət şərtləri. Bütün Vape cihazlarına 2 həftə zəmanət.',
                    'en' => 'VapeArt Baku warranty terms. 2 week warranty on all Vape devices.',
                    'ru' => 'Условия гарантии VapeArt Baku. 2 недели гарантии на все Vape устройства.'
                ],
                'is_active' => true,
                'sort_order' => 4,
            ]
        );
    }
}
