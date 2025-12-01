<?php

namespace Database\Seeders;

use App\Enums\DiscountType;
use App\Models\Discount;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating discounts...');

        DB::beginTransaction();
        try {
            // Create percentage discount
            $percentageDiscount = Discount::create([
                'name' => [
                    'en' => 'Summer Sale - 20% Off',
                    'az' => 'Yay Endirimi - 20% Endirim',
                    'ru' => 'Летняя распродажа - скидка 20%',
                ],
                'code' => 'SUMMER20',
                'type' => DiscountType::PERCENTAGE->value,
                'amount' => 20,
                'start_date' => now()->subDays(5),
                'end_date' => now()->addDays(30),
                'usage_limit' => null,
                'used_count' => 0,
                'is_active' => true,
                'sort_order' => 1,
            ]);

            // Create fixed discount
            $fixedDiscount = Discount::create([
                'name' => [
                    'en' => 'Special Offer - 50 AZN Off',
                    'az' => 'Xüsusi Təklif - 50 AZN Endirim',
                    'ru' => 'Специальное предложение - скидка 50 AZN',
                ],
                'code' => 'SPECIAL50',
                'type' => DiscountType::FIXED->value,
                'amount' => 50,
                'start_date' => now()->subDays(2),
                'end_date' => now()->addDays(45),
                'usage_limit' => 100,
                'used_count' => 0,
                'is_active' => true,
                'sort_order' => 2,
            ]);

            // Create another percentage discount
            $bigSaleDiscount = Discount::create([
                'name' => [
                    'en' => 'Black Friday - 30% Off',
                    'az' => 'Qara Cümə - 30% Endirim',
                    'ru' => 'Черная пятница - скидка 30%',
                ],
                'code' => 'BLACKFRIDAY30',
                'type' => DiscountType::PERCENTAGE->value,
                'amount' => 30,
                'start_date' => now()->subDays(1),
                'end_date' => now()->addDays(60),
                'usage_limit' => null,
                'used_count' => 0,
                'is_active' => true,
                'sort_order' => 3,
            ]);

            $this->command->info('Discounts created successfully.');

            // Get active products
            $products = Product::where('is_active', true)->get();

            if ($products->isEmpty()) {
                $this->command->warn('No active products found to attach to discounts.');
                DB::commit();
                return;
            }

            $this->command->info(sprintf('Found %d active products. Attaching to discounts...', $products->count()));

            // Attach products to discounts
            // First discount gets 30% of products
            $firstDiscountProducts = $products->random((int)($products->count() * 0.3));
            $percentageDiscount->products()->sync($firstDiscountProducts->pluck('id')->toArray());
            $this->command->info(sprintf('Attached %d products to "%s" discount.', $firstDiscountProducts->count(), $percentageDiscount->getTranslation('name', 'en')));

            // Second discount gets 25% of products (some may overlap)
            $secondDiscountProducts = $products->random((int)($products->count() * 0.25));
            $fixedDiscount->products()->sync($secondDiscountProducts->pluck('id')->toArray());
            $this->command->info(sprintf('Attached %d products to "%s" discount.', $secondDiscountProducts->count(), $fixedDiscount->getTranslation('name', 'en')));

            // Third discount gets 20% of products
            $thirdDiscountProducts = $products->random((int)($products->count() * 0.2));
            $bigSaleDiscount->products()->sync($thirdDiscountProducts->pluck('id')->toArray());
            $this->command->info(sprintf('Attached %d products to "%s" discount.', $thirdDiscountProducts->count(), $bigSaleDiscount->getTranslation('name', 'en')));

            DB::commit();
            $this->command->info('Discount seeder completed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('Failed to seed discounts: ' . $e->getMessage());
            $this->command->error($e->getTraceAsString());
        }
    }
}

