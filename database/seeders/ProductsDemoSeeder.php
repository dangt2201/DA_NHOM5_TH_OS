<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;

class ProductsDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cat_nam = Category::where('slug', 'giay-nam')->firstOrFail();
        $cat_nu  = Category::where('slug', 'giay-nu')->firstOrFail();
        $cat_pk  = Category::where('slug', 'phu-kien')->firstOrFail();


        $brands = [
            'nike'     => Brand::firstOrCreate(['slug' => 'nike'], ['name' => 'Nike', 'is_active' => true]),
            'adidas'   => Brand::firstOrCreate(['slug' => 'adidas'], ['name' => 'Adidas', 'is_active' => true]),
            'puma'     => Brand::firstOrCreate(['slug' => 'puma'], ['name' => 'Puma', 'is_active' => true]),
            'vans'     => Brand::firstOrCreate(['slug' => 'vans'], ['name' => 'Vans', 'is_active' => true]),
            'converse' => Brand::firstOrCreate(['slug' => 'converse'], ['name' => 'Converse', 'is_active' => true]),
            'new-balance' => Brand::firstOrCreate(['slug' => 'new-balance'], ['name' => 'New Balance', 'is_active' => true]),
            'crep-protect' => Brand::firstOrCreate(['slug' => 'crep-protect'], ['name' => 'Crep Protect', 'is_active' => true]),
            'reebok'   => Brand::firstOrCreate(['slug' => 'reebok'], ['name' => 'Reebok', 'is_active' => true]),
        ];

        $products = [
            // 1-10
            ['Nike Air Force 1 Low White', 'nike-af1-white', 3500000, 2890000, $cat_nam, $brands['nike']],
            ['Nike Dunk Low Panda', 'dunk-low-panda', 3800000, 2990000, $cat_nam, $brands['nike']],
            ['Puma Suede Classic Red', 'puma-suede-red', 2300000, 1150000, $cat_nu, $brands['puma']],
            ['Adidas Stan Smith Women', 'stan-smith-women', 2500000, 1990000, $cat_nu, $brands['adidas']],
            ['Vans Old Skool Black', 'vans-old-skool', 1650000, 1350000, $cat_nam, $brands['vans']],
            ['Converse Chuck 70 High', 'chuck-70-high', 2200000, 1790000, $cat_nam, $brands['converse']],
            ['New Balance 550 White Green', 'nb-550-green', 4200000, 3490000, $cat_nam, $brands['new-balance']],
            ['Adidas Ultraboost 22', 'ultraboost-22', 4800000, 3990000, $cat_nam, $brands['adidas']],
            ['Nike Blazer Mid 77', 'blazer-mid-77', 3400000, 2790000, $cat_nam, $brands['nike']],
            ['Reebok Classic Leather', 'reebok-classic', 2400000, 1890000, $cat_nam, $brands['reebok']],

            // 11-20
            ['Nike Air Jordan 1 Low', 'jordan-1-low', 4500000, null, $cat_nam, $brands['nike']],
            ['Adidas NMD R1', 'nmd-r1', 4200000, 3490000, $cat_nam, $brands['adidas']],
            ['Puma RS-X', 'puma-rs-x', 3200000, 2490000, $cat_nam, $brands['puma']],
            ['Vans Authentic', 'vans-authentic', 1550000, null, $cat_nam, $brands['vans']],
            ['Converse Run Star Hike', 'run-star-hike', 2600000, 2190000, $cat_nu, $brands['converse']],
            ['New Balance 327', 'nb-327', 3600000, 2990000, $cat_nam, $brands['new-balance']],
            ['Nike React Element 55', 'react-55', 3800000, 2990000, $cat_nam, $brands['nike']],
            ['Adidas Superstar', 'superstar', 2800000, 2290000, $cat_nam, $brands['adidas']],
            ['Puma Cali', 'puma-cali', 2500000, 1890000, $cat_nu, $brands['puma']],
            ['Vans Slip-On Checkerboard', 'vans-slipon', 1700000, 1390000, $cat_nu, $brands['vans']],

            // 21-30
            ['Chai vệ sinh Crep Protect', 'crep-cure', 450000, null, $cat_pk, $brands['crep-protect']],
            ['Vớ Nike Cushioned 3 Đôi', 'vo-nike-3pack', 350000, 280000, $cat_pk, $brands['nike']],
            ['Nike Zoom Fly 5', 'zoom-fly-5', 4800000, 3990000, $cat_nam, $brands['nike']],
            ['Adidas Forum Low', 'forum-low', 3200000, 2590000, $cat_nam, $brands['adidas']],
            ['Puma Future Rider', 'future-rider', 2800000, 2190000, $cat_nam, $brands['puma']],
            ['New Balance 574 Grey', 'nb-574', 3200000, null, $cat_nam, $brands['new-balance']],
            ['Converse One Star', 'one-star', 1900000, 1490000, $cat_nu, $brands['converse']],
            ['Nike Air Max 270', 'air-max-270', 4200000, 3490000, $cat_nam, $brands['nike']],
            ['Adidas Ozweego', 'ozweego', 3500000, 2790000, $cat_nam, $brands['adidas']],
            ['Puma Mirage Sport', 'mirage-sport', 2900000, 2290000, $cat_nam, $brands['puma']],

            // 31-40
            ['Nike Air Max 90', 'air-max-90', 3900000, 3190000, $cat_nam, $brands['nike']],
            ['Adidas Yeezy Boost 350 V2', 'yeezy-350', 6500000, 5490000, $cat_nam, $brands['adidas']],
            ['Puma Speedcat', 'speedcat', 2700000, 2190000, $cat_nam, $brands['puma']],
            ['Vans Era', 'vans-era', 1600000, null, $cat_nam, $brands['vans']],
            ['Converse All Star Ox', 'all-star-ox', 1500000, 1190000, $cat_nu, $brands['converse']],
            ['New Balance 990v5', 'nb-990v5', 5500000, 4490000, $cat_nam, $brands['new-balance']],
            ['Nike SB Dunk Low', 'sb-dunk-low', 3600000, 2890000, $cat_nam, $brands['nike']],
            ['Adidas Samba', 'samba', 2700000, 2190000, $cat_nam, $brands['adidas']],
            ['Puma Suede 50', 'puma-suede-50', 2400000, 1890000, $cat_nu, $brands['puma']],
            ['Vans SK8-Hi', 'sk8-hi', 1800000, 1490000, $cat_nam, $brands['vans']],

            // 41-50
            ['Nike Cortez', 'cortez', 2800000, 2290000, $cat_nu, $brands['nike']],
            ['Adidas Gazelle', 'gazelle', 2600000, 2090000, $cat_nam, $brands['adidas']],
            ['New Balance 327 Women', 'nb-327-women', 3400000, 2790000, $cat_nu, $brands['new-balance']],
            ['Converse Pro Leather', 'pro-leather', 2100000, 1690000, $cat_nam, $brands['converse']],
            ['Nike Pegasus 40', 'pegasus-40', 4200000, 3490000, $cat_nam, $brands['nike']],
            ['Adidas ZX 750', 'zx-750', 3100000, 2490000, $cat_nam, $brands['adidas']],
            ['Puma Clyde Court', 'clyde-court', 3500000, 2790000, $cat_nam, $brands['puma']],
            ['Vans Half Cab', 'half-cab', 1900000, 1590000, $cat_nam, $brands['vans']],
            ['Reebok Club C', 'club-c', 2300000, 1890000, $cat_nam, $brands['reebok']],
            ['Túi đựng giày Sneaker', 'tui-dung-giay', 250000, 199000, $cat_pk, $brands['crep-protect']],
        ];

           $createdCount = 0;
        // Tạo sản phẩm
        foreach ($products as $i => $p) {
            [$name, $slug, $price, $sale, $cat, $brand] = $p;
            
            // MÔ TẢ ĐƠN GIẢN - CHỈ 1 DÒNG
            $description = $name . ' - Chính hãng 100%. Bảo hành 6 tháng. Đổi trả trong 7 ngày.';

            $product = Product::updateOrCreate(
                ['slug' => $slug],
                [
                    'category_id'   => $cat->id,
                    'brand_id'      => $brand->id,
                    'name'          => $name,
                    'sku'           => 'SP' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                    'img_thumbnail' => null,
                    'price'         => $price,
                    'price_sale'    => $sale,
                    'description'   => $description,  // Mô tả đơn giản
                    'is_active'     => true,
                ]
            );
            
            $createdCount++;
            
        }
     
    }
}
