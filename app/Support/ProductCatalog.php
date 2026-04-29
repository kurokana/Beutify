<?php

namespace App\Support;

use Illuminate\Support\Collection;

class ProductCatalog
{
    /**
     * @return array<int, array<string, mixed>>
     */
    public static function all(): array
    {
        return [
            1 => [
                'id' => 1,
                'name' => 'Hydrating Serum',
                'brand' => 'Somethinc',
                'price' => 89000,
                'emoji' => '🧴',
                'category' => 'Serum',
                'variant' => 'Serum wajah untuk kulit lembap',
                'skin' => 'Kulit kering dan normal',
                'size' => '30 ml',
                'ingredients' => 'Hyaluronic Acid, Ceramide, Aloe Vera',
                'desc' => 'Hydrating Serum membantu menjaga kelembapan kulit, memperkuat skin barrier, dan membuat kulit tampak lebih sehat.',
            ],
            2 => [
                'id' => 2,
                'name' => 'Toner',
                'brand' => 'Avoskin',
                'price' => 75000,
                'emoji' => '💧',
                'category' => 'Toner',
                'variant' => 'Toner menyegarkan untuk harian',
                'skin' => 'Kulit kusam',
                'size' => '100 ml',
                'ingredients' => 'Niacinamide, Licorice Extract, Green Tea',
                'desc' => 'Toner membantu menyegarkan kulit dan membuat wajah tampak lebih cerah.',
            ],
            3 => [
                'id' => 3,
                'name' => 'Sunscreen',
                'brand' => 'Azarine',
                'price' => 99000,
                'emoji' => '☀️',
                'category' => 'Sunscreen',
                'variant' => 'Sunscreen ringan untuk harian',
                'skin' => 'Semua jenis kulit',
                'size' => '50 ml',
                'ingredients' => 'UV Filter, Centella Asiatica, Vitamin E',
                'desc' => 'Sunscreen melindungi kulit dari paparan sinar UVA dan UVB.',
            ],
            4 => [
                'id' => 4,
                'name' => 'Facial Wash',
                'brand' => 'Wardah',
                'price' => 55000,
                'emoji' => '🫧',
                'category' => 'Cleanser',
                'variant' => 'Pembersih wajah lembut',
                'skin' => 'Kulit berminyak dan kombinasi',
                'size' => '100 ml',
                'ingredients' => 'Tea Tree, Gentle Foam, Chamomile',
                'desc' => 'Facial Wash membersihkan wajah dari minyak, debu, dan kotoran tanpa membuat kulit terasa kering.',
            ],
        ];
    }

    /**
     * @return array<string, mixed>|null
     */
    public static function find(int $id): ?array
    {
        return self::all()[$id] ?? null;
    }

    public static function search(string $query): Collection
    {
        $query = strtolower($query);

        return collect(self::all())->filter(function (array $product) use ($query): bool {
            if ($query === '') {
                return true;
            }

            return str_contains(strtolower($product['name']), $query)
                || str_contains(strtolower($product['brand']), $query)
                || str_contains(strtolower($product['category']), $query);
        })->values();
    }
}
