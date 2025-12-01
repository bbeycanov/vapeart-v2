<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Menu;
use App\Enums\MenuPosition;
use Illuminate\Database\Seeder;

class AttachProductsToSidebarMenusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all sidebar menus (including children)
        $sidebarMenus = Menu::where('position', MenuPosition::SIDEBAR->value)
            ->where('is_active', true)
            ->get();

        if ($sidebarMenus->isEmpty()) {
            $this->command->warn('No sidebar menus found. Please create sidebar menus first.');
            return;
        }

        // Get all active products
        $products = Product::where('is_active', true)->get();

        if ($products->isEmpty()) {
            $this->command->warn('No active products found.');
            return;
        }

        $this->command->info("Found {$sidebarMenus->count()} sidebar menus and {$products->count()} products.");

        $attachedCount = 0;

        // Attach each product to 1-3 random sidebar menus
        foreach ($products as $product) {
            // Random number of menus to attach (1-3)
            $numberOfMenus = rand(1, min(3, $sidebarMenus->count()));
            
            // Get random sidebar menus
            $randomMenus = $sidebarMenus->random($numberOfMenus);
            
            // Get current menu IDs (to avoid duplicates)
            $currentMenuIds = $product->menus()
                ->where('position', MenuPosition::SIDEBAR->value)
                ->pluck('menus.id')
                ->toArray();
            
            // Get new menu IDs to attach
            $newMenuIds = $randomMenus->pluck('id')->toArray();
            
            // Merge with existing sidebar menus (keep featured menus)
            $allMenuIds = array_unique(array_merge($currentMenuIds, $newMenuIds));
            
            // Get featured menu IDs to preserve them
            $featuredMenuIds = $product->menus()
                ->where('position', MenuPosition::FEATURED->value)
                ->pluck('menus.id')
                ->toArray();
            
            // Merge all menu IDs (featured + sidebar)
            $finalMenuIds = array_unique(array_merge($featuredMenuIds, $allMenuIds));
            
            // Sync menus
            $product->menus()->sync($finalMenuIds);
            
            $attachedCount++;
        }

        $this->command->info("Successfully attached {$attachedCount} products to sidebar menus.");
    }
}

