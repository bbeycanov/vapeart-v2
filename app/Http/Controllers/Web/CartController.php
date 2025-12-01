<?php

namespace App\Http\Controllers\Web;

use App\Models\Product;
use App\Models\Branch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;

class CartController extends Controller
{
    /**
     * @param string $locale
     * @return Factory|View
     */
    public function index(string $locale): Factory|View
    {
        app()->setLocale($locale);
        $branches = Branch::where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->map(function ($branch) {
                return [
                    'id' => $branch->id,
                    'name' => $branch->getTranslation('name', app()->getLocale()),
                    'address' => $branch->getTranslation('address', app()->getLocale()),
                    'phone' => $branch->phone,
                    'whatsapp' => $branch->whatsapp,
                ];
            });
        return view('pages.carts.index', compact('branches'));
    }
    
    /**
     * @param string $locale
     * @return JsonResponse
     */
    public function getBranches(string $locale): JsonResponse
    {
        app()->setLocale($locale);
        $branches = Branch::where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->map(function ($branch) {
                return [
                    'id' => $branch->id,
                    'name' => $branch->getTranslation('name', app()->getLocale()),
                    'address' => $branch->getTranslation('address', app()->getLocale()),
                    'phone' => $branch->phone,
                    'whatsapp' => $branch->whatsapp,
                ];
            });
        
        return response()->json([
            'success' => true,
            'branches' => $branches
        ]);
    }

    /**
     * @param string $locale
     * @param Request $request
     * @return JsonResponse
     */
    public function add(string $locale, Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'sometimes|integer|min:1'
        ]);

        app()->setLocale($locale);

        $product = Product::with(['brand', 'media'])->findOrFail($request->product_id);
        $quantity = $request->input('quantity', 1);
        
        // Burada cart logic'i implement edilecek
        // Şimdilik sadece success response döndürüyoruz
        // Frontend'de localStorage kullanılıyor
        
        return response()->json([
            'success' => true,
            'message' => __('Product added to cart successfully'),
            'product' => [
                'id' => $product->id,
                'name' => $product->getTranslation('name', app()->getLocale()),
                'slug' => $product->slug,
                'price' => $product->price,
                'currency' => $product->currency ?? 'AZN',
                'image' => $product->getFirstMediaUrl('thumbnail') ?: $product->getFirstMediaUrl('images'),
                'url' => route('products.show', [app()->getLocale(), $product->slug]),
                'quantity' => $quantity,
            ]
        ]);
    }
}

