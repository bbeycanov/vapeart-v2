<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        Branch::create([
            'slug' => 'genclik-filiali',
            'name' => [
                'az' => 'Gənclik filialı',
                'en' => 'Gənclik Branch',
                'ru' => 'Филиал Гянджлик'
            ],
            'address' => [
                'az' => 'Akedemik Həsən Əliyev 117',
                'en' => 'Academic Hasan Aliyev 117',
                'ru' => 'Академик Гасан Алиев 117'
            ],
            'phone' => '+994508530313',
            'email' => 'vapeartbaku@gmail.com',
            'whatsapp' => '994508530313',
            'working_hours' => [
                'az' => 'Hərgün - 11:00-23:00',
                'en' => 'Everyday - 11:00-23:00',
                'ru' => 'Каждый день - 11:00-23:00'
            ],
            'description' => [
                'az' => 'Vape Art Premium - Gənclik filialı. Geniş məhsul çeşidimiz və peşəkar xidmətimizlə sizə xidmət göstəririk.',
                'en' => 'Vape Art Premium - Gənclik branch. We serve you with our wide product range and professional service.',
                'ru' => 'Vape Art Premium - Филиал Гянджлик. Мы обслуживаем вас нашим широким ассортиментом продукции и профессиональным сервисом.'
            ],
            'latitude' => 40.403551,
            'longitude' => 49.854286,
            'meta_title' => [
                'az' => 'Gənclik Filialı - Vape Art Premium',
                'en' => 'Gənclik Branch - Vape Art Premium',
                'ru' => 'Филиал Гянджлик - Vape Art Premium'
            ],
            'meta_description' => [
                'az' => 'Gənclik filialı - Vape Art Premium. Akedemik Həsən Əliyev 117 ünvanında yerləşir.',
                'en' => 'Gənclik branch - Vape Art Premium. Located at Academic Hasan Aliyev 117.',
                'ru' => 'Филиал Гянджлик - Vape Art Premium. Расположен по адресу Академик Гасан Алиев 117.'
            ],
            'is_active' => true,
            'sort_order' => 1,
        ]);

        Branch::create([
            'slug' => '28-may-filiali',
            'name' => [
                'az' => '28 May filialı',
                'en' => '28 May Branch',
                'ru' => 'Филиал 28 Мая'
            ],
            'address' => [
                'az' => 'Dilarə Əliyeva 225',
                'en' => 'Dilara Aliyeva 225',
                'ru' => 'Дилара Алиева 225'
            ],
            'phone' => '+994508281110',
            'email' => 'vapeartbaku@gmail.com',
            'whatsapp' => '994508281110',
            'working_hours' => [
                'az' => 'Hərgün - 11:00-23:00',
                'en' => 'Everyday - 11:00-23:00',
                'ru' => 'Каждый день - 11:00-23:00'
            ],
            'description' => [
                'az' => 'Bol Buxar Vape shop - 28 May filialı. Geniş məhsul çeşidimizlə sizə xidmət göstəririk.',
                'en' => 'Bol Buxar Vape shop - 28 May branch. We serve you with our wide product range.',
                'ru' => 'Bol Buxar Vape shop - Филиал 28 Мая. Мы обслуживаем вас нашим широким ассортиментом продукции.'
            ],
            'latitude' => 40.3776589,
            'longitude' => 49.8449164,
            'meta_title' => [
                'az' => '28 May Filialı - Bol Buxar Vape shop',
                'en' => '28 May Branch - Bol Buxar Vape shop',
                'ru' => 'Филиал 28 Мая - Bol Buxar Vape shop'
            ],
            'meta_description' => [
                'az' => '28 May filialı - Bol Buxar Vape shop. Dilarə Əliyeva 225 ünvanında yerləşir.',
                'en' => '28 May branch - Bol Buxar Vape shop. Located at Dilara Aliyeva 225.',
                'ru' => 'Филиал 28 Мая - Bol Buxar Vape shop. Расположен по адресу Дилара Алиева 225.'
            ],
            'is_active' => true,
            'sort_order' => 2,
        ]);
    }
}
