<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Gallery;
use App\Models\ProductVariant;
use App\Models\Discount;
use App\Models\DiscountProductVariant;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    private $brandModel                  = null;
    private $categoryModel               = null;
    private $productModel                = null;
    private $galleryModel                = null;
    private $productVariantModel         = null;
    private $discountModel               = null;
    private $discountProductVariantModel = null;

    public function __construct(
        Brand                  $brandModel, 
        Category               $categoryModel,
        Product                $productModel,
        Gallery                $galleryModel,
        ProductVariant         $productVariant,
        Discount               $discountModel,
        DiscountProductVariant $discountProductVariant
        )
    {
        $this->brandModel                  = $brandModel;
        $this->categoryModel               = $categoryModel;
        $this->productModel                = $productModel;
        $this->galleryModel                = $galleryModel;
        $this->productVariantModel         = $productVariant;
        $this->discountModel               = $discountModel;
        $this->discountProductVariantModel = $discountProductVariant;
    }

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->brandModel::factory(10)->create();
        $this->categoryModel::factory(3)->create();
        $this->productModel::factory(10)->create();
        $this->galleryModel::factory(5)->create();
        $this->productVariantModel::factory(50)->create();
        $this->discountModel::factory(4)->create();
        $this->discountProductVariantModel::factory(5)->create();
    }
}
