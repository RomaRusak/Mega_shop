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
use App\Models\UserApi;
use App\Models\Cart;
use App\Models\Review;
use App\Models\Address;
use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
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
    private $userModel                   = null;
    private $userApiModel                = null;
    private $cartModel                   = null;
    private $reviewModel                 = null;
    private $addressModel                = null;
    private $orderModel                  = null;

    private $factoryParams = [
        'brand'                  => 10,
        'category'               => 3,
        'product'                => 10,
        'gallery'                => 5,
        'productVariant'         => 50,
        'discount'               => 4,
        'discountProductVariant' => 5,
        'user'                   => 12,
        'review'                 => 20,
        'address'                => 14,
        'order'                  => 10,
    ];

    public function __construct(
        Brand                  $brandModel, 
        Category               $categoryModel,
        Product                $productModel,
        Gallery                $galleryModel,
        ProductVariant         $productVariant,
        Discount               $discountModel,
        DiscountProductVariant $discountProductVariant,
        User                   $user,
        UserApi                $userApi,
        Cart                   $cart,
        Review                 $review,
        Address                $address,
        Order                  $order,
        )
    {
        $this->brandModel                  = $brandModel;
        $this->categoryModel               = $categoryModel;
        $this->productModel                = $productModel;
        $this->galleryModel                = $galleryModel;
        $this->productVariantModel         = $productVariant;
        $this->discountModel               = $discountModel;
        $this->discountProductVariantModel = $discountProductVariant;
        $this->userModel                   = $user;
        $this->userApiModel                = $userApi;
        $this->cartModel                   = $cart;
        $this->reviewModel                 = $review;
        $this->addressModel                = $address;
        $this->orderModel                  = $order;
    }

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->brandModel::factory($this->factoryParams['brand'])->create();
        $this->categoryModel::factory($this->factoryParams['category'])->create();
        $this->productModel::factory($this->factoryParams['product'])->create();
        $this->galleryModel::factory($this->factoryParams['gallery'])->create();
        $this->generateUniqProductVariants();
        $this->discountModel::factory($this->factoryParams['discount'])->create();
        $this->discountProductVariantModel::factory($this->factoryParams['discountProductVariant'])->create();
        $this->userModel::factory($this->factoryParams['user'])->create();

        foreach($this->userModel::all() as $userData) {
            $userApiFactory = $this->getFactoryWithUserId($this->userApiModel, $userData->id);
            $cartFactory    = $this->getFactoryWithUserId($this->cartModel, $userData->id);

            $userApiFactory->create();
            $cartFactory->create();
        };

        $this->reviewModel::factory($this->factoryParams['review'])->create();

        foreach ($this->productModel::all() as $productData) {
            $productData->update(['rating' => $this->calcProductRating($productData)]);
        }

        $this->createAddresses();
        $this->orderModel::factory($this->factoryParams['order'])->create();
    }

    private function createAddresses()
    {
        $userFactoriesCount    = $this->factoryParams['user'];
        $addressFactoriesCount = $this->factoryParams['address'];
        
        $usedUserIds = $this->userModel::select('id')
                                        ->limit($addressFactoriesCount)
                                        ->pluck('id');

        if ($addressFactoriesCount >= $userFactoriesCount) {
            $idOfAdditAddres = $this->userModel::select('id')
                                                ->limit($addressFactoriesCount - $userFactoriesCount) 
                                                ->get()  
                                                ->shuffle()
                                                ->pluck('id');

            $usedUserIds = [...$usedUserIds, ...$idOfAdditAddres];
        }

        foreach($usedUserIds as $id) {
            $addressFactory = $this->getFactoryWithUserId($this->addressModel, $id);
            $addressFactory->create();
        }
    }

    private function generateUniqProductVariants() {
        for ($i = 0; $i < $this->factoryParams['productVariant']; $i++) {
            while(true) {
                $productVariant = $this->productVariantModel::factory()->make();
    
                $product_id = $productVariant->product_id;
                $size       = $productVariant->size;
                $color      = $productVariant->color;

                $existingProductVariant = $this->productVariantModel::where('product_id', $product_id)
                ->where('size', $size)
                ->where('color', $color)
                ->first();

                if (!$existingProductVariant) {
                    $productVariant->save();
                    break;
                }
            }
        }
    }

    private function getFactoryWithUserId(Model $model, int $userId)
    {
        return $model::factory()->state([
            'user_id' => $userId,
        ]);
    }

    private function calcProductRating($product)
    {
        return $product->reviews()->avg('rating');
    }
}
