<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    protected static int $counter = 1;

    public function definition(): array
    {
        $imagesPath = public_path('front/images');

        $images = is_dir($imagesPath)
            ? collect(scandir($imagesPath))
                ->reject(fn ($file) => in_array($file, ['.', '..', '', 'ahmed.png']))
                ->filter(fn ($file) => preg_match('/\.(jpg|jpeg|png|webp)$/i', $file))
                ->values()
            : collect();

        return [
            'name'        => 'منتج ' . self::$counter++,
            'description' => $this->faker->randomElement(['جميل', 'رائع', 'مميز', 'خفيف', 'سريع', 'قوي']),
            'price'       => $this->faker->randomFloat(2, 50, 1000),
            'old_price'   => $this->faker->optional()->randomFloat(2, 50, 1200),
            'image'       => $images->isNotEmpty()
                                ? 'front/images/' . $images->random()
                                : 'front/images/default.jpg',
            'category'    => $this->faker->randomElement(['البقالة', 'الفواكه', 'الخضروات', 'اللحوم', 'الألبان', 'المنظفات']),
            'code'        => $this->faker->numerify(str_repeat('#', 13)),
            'size'        => $this->faker->randomElement(['S', 'M', 'L', 'XL']),
            'quantity'    => $this->faker->numberBetween(1, 100),
            'company_id'  => Company::inRandomOrder()->value('id'),
        ];
    }
}
