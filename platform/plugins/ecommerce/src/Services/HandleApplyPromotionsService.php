<?php

namespace Botble\Ecommerce\Services;

use Botble\Ecommerce\Models\Discount;
use Botble\Ecommerce\Repositories\Interfaces\DiscountInterface;
use Botble\Ecommerce\Repositories\Interfaces\ProductInterface;
use Cart;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use OrderHelper;

class HandleApplyPromotionsService
{
    /**
     * @var DiscountInterface
     */
    protected $discountRepository;

    /**
     * @var ProductInterface
     */
    protected $productRepository;

    /**
     * @var null|Collection
     */
    protected $promotions;

    /**
     * HandleApplyPromotionsService constructor.
     * @param DiscountInterface $discountRepository
     * @param ProductInterface $productRepository
     */
    public function __construct(DiscountInterface $discountRepository, ProductInterface $productRepository)
    {
        $this->discountRepository = $discountRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * @param null $token
     * @param array $data
     * @param string|null $prefix
     * @return float
     */
    public function execute($token = null, array $data = [], ?string $prefix = '')
    {
       
        if (empty($this->promotions)) {
            $promotions = $this->discountRepository->getAvailablePromotions();
            $this->promotions = $promotions;
        } else {
            $promotions = $this->promotions;
        }

        $promotionDiscountAmount = 0;

        $rawTotal = Arr::get($data, 'rawTotal', Cart::instance('cart')->rawTotal());
        $cartItems = Arr::get($data, 'cartItems', Cart::instance('cart')->content());
        $countCart = Arr::get($data, 'countCart', Cart::instance('cart')->count());

        // Azeem, Promotion logic
        $promotionApplicable    = false; // by default should be true if there is no country selected
        $userCountryID          = session('country');
        $userCountryName        = trim(strtolower(DB::table('countries')->where('id', $userCountryID)->first()->name));
        echo "<span id='azeem-debugging' style='display: none;'>Your Country: $userCountryName</span>\n";

        foreach ($promotions as $promotion) {
            /**
             * @var Discount $promotion
             */

             echo "<span id='azeem-debugging' style='display: none;'>inside foreach promotions</span>\n";
             // Azeem, check promotion country
            if ($promotion->countries != '') {
                $countriesApplicable = explode(',', $promotion->countries);
                foreach($countriesApplicable as $countryApplicable) {
                    $countryApplicable = trim($countryApplicable);
                    echo "<span id='azeem-debugging' style='display: none;'>Checking if you're from '".$countryApplicable."'</span>\n";
                    if ($userCountryName == $countryApplicable) {
                        $promotionApplicable = true;
                        echo "<span id='azeem-debugging' style='display: none;'>Yes you're from '".$countryApplicable."'</span>\n";
                        echo "<span id='azeem-debugging' style='display: none;'>".$promotion->value. " " . $promotion->type_option." country based discount applicable</span>\n";
                        break;
                    } else {
                        $promotionApplicable = false;
                        echo "<span id='azeem-debugging' style='display: none;'>No, you're not from '".$countryApplicable."'</span>\n";
                        echo "<span id='azeem-debugging' style='display: none;'>".$promotion->title. " not applicable</span>\n";
                    }
                }
            } else {
                $promotionApplicable = true;
                echo "<span id='azeem-debugging' style='display: none;'>".$promotion->title. " is applicable on all countries</span>\n";
            }
            if (!$promotionApplicable)
                return $promotionDiscountAmount;

            switch ($promotion->type_option) {
                case 'amount':
                    switch ($promotion->target) {
                        case 'amount-minimum-order':
                            if ($promotion->min_order_price <= $rawTotal) {
                                $promotionDiscountAmount += $promotion->value;
                            }
                            break;
                        case 'all-orders':
                            $promotionDiscountAmount += $promotion->value;
                            break;
                        default:
                            if ($countCart >= $promotion->product_quantity) {
                                $promotionDiscountAmount += $promotion->value;
                            }
                            break;
                    }
                    break;
                case 'percentage':
                    switch ($promotion->target) {
                        case 'amount-minimum-order':
                            if ($promotion->min_order_price <= $rawTotal) {
                                $promotionDiscountAmount += $rawTotal * $promotion->value / 100;
                            }
                            break;
                        case 'all-orders':
                            $promotionDiscountAmount += $rawTotal * $promotion->value / 100;
                            break;
                        default:
                            if ($countCart >= $promotion->product_quantity) {
                                $promotionDiscountAmount += $rawTotal * $promotion->value / 100;
                            }
                            break;
                    }
                    break;
                case 'same-price':
                    if ($promotion->product_quantity > 1 && $countCart >= $promotion->product_quantity) {
                        foreach ($cartItems as $item) {
                            if ($item->qty >= $promotion->product_quantity) {
                                if (in_array($promotion->target, ['specific-product', 'product-variant']) &&
                                    in_array($item->id, $promotion->products()->pluck('product_id')->all())
                                ) {
                                    $promotionDiscountAmount += ($item->price - $promotion->value) * $item->qty;
                                } elseif ($product = $this->productRepository->findById($item->id)) {
                                    $productCollections = $product
                                        ->productCollections()
                                        ->pluck('ec_product_collections.id')->all();

                                    $discountProductCollections = $promotion
                                        ->productCollections()
                                        ->pluck('ec_product_collections.id')
                                        ->all();

                                    if (!empty(array_intersect(
                                        $productCollections,
                                        $discountProductCollections
                                    ))) {
                                        $promotionDiscountAmount += ($item->price - $promotion->value) * $item->qty;
                                    }
                                }
                            }
                        }
                    }

                    break;
            }
        }
        echo "<span id='azeem-debugging' style='display: none;'>after foreach promotions</span>\n";

        if (!$token) {
            $token = OrderHelper::getOrderSessionToken();
        }

        $sessionData = OrderHelper::getOrderSessionData($token);
        Arr::set($sessionData, $prefix . 'promotion_discount_amount', $promotionDiscountAmount);
        OrderHelper::setOrderSessionData($token, $sessionData);

        return $promotionDiscountAmount;
    }
}
