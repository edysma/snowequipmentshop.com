<span class="product-price">

    <?php

        $recommendedCountryCode = '';
        if (!session('country')) {
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://ipinfo.io/',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            if ($response) {
                $response = json_decode($response, true);
                if(isset($response['error'])) {
					session(['country'=>112]);
					
				} else {
					if (isset($response['country'])) {
                    $recommendedCountryCode = $response['country'];
                }
                foreach(Botble\ Location\ Models\ Country::all() as $country) {
                    // dd( $recommendedCountryCode);
                    if (strtolower($country->code) == strtolower($recommendedCountryCode)) {
                        // dd('running');
                        session(['country' => $country->id]);
                    }
                }
				}
				
				
				
                

               
            }
        }

        // Get price based on user country
        use Illuminate\Support\Facades\DB as DB;
        $price = $product->price;
        $country_id = 1;
        if(session('country') != '') {
            $country_id = session('country');
        }
        $priceInfo = DB::table('ec_product_price')->where('ec_products_id',$product->id)->where('countries_id',$country_id)->first();
        if($priceInfo) {
            $price = $priceInfo->price;
        }

        // Flash Sale
        use Botble\ Ecommerce\ Models\ Discount;
        use Botble\ Ecommerce\ Models\ Customer;
        use Botble\ Ecommerce\ Models\ FlashSale;
        use Botble\ Ecommerce\ Models\ FlashSaleProductPrice;
        use Illuminate\ Support\ Carbon;

        if (auth('customer')->check()) {
            $customer = Customer::find(Auth::guard('customer')->user()->id);
            $categorie = $customer->categories()->first();
            if ($categorie) {
                $categorie = $categorie->id;

            }
        } else {
            $categorie = 1;
        }

        $flashsale = FlashSale::where('status', 'published')->where('end_date', '>', Carbon::now())->first();

        $discount = 0;
        if ($flashsale && $categorie) {
            $discount = FlashSaleProductPrice::where('flash_sale_id', $flashsale->id)->where('category_id', $categorie)->first();
            if ($discount) {
                $discount = $discount->discount;
            }
        }

        if (session('pdiscount') == 1) {
            $price_tax = (float) $price;
        } else {
            $price_tax = (float) $product->price_with_taxes;

        }

        $price_sale = (float) $product->front_sale_price_with_taxes;

        if ($discount != 0) {
            if (session('pdiscount') == 1) {
                $price_tax = (float) $price - ((float) $product->price / (float) $discount);
                $price_sale = ((float) $product->front_sale_price_with_taxes / (float) $discount);

            } else {
                $price_tax = (float) $product->price_with_taxes - ((float) $product->price_with_taxes / (float) $discount);
                $price_sale = (float) $product->front_sale_price_with_taxes - ((float) $product->front_sale_price_with_taxes / (float) $discount);

            }
            //   

        }

        // check if promotion running for user's country
        $userCountryID = session('country');
        $userCountryName = trim(strtolower(DB::table('countries')->where('id', $userCountryID)->first()->name));
        // echo "<span id='azeem-debugging' style='display: none;'>Checking promotions for: $userCountryName</span>\n";
        $discounts_promotions = Discount::where('end_date', '>', Carbon::now())->orWhereNull('end_date')->get();

        foreach ($discounts_promotions as $promotion) {
            if ($promotion->countries != '') {
                $countriesApplicable = explode(',', $promotion->countries);
                foreach($countriesApplicable as $countryApplicable) {
                    $countryApplicable = trim(strtolower($countryApplicable));
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
            if (!$promotionApplicable) {
                continue;
                echo "<span id='azeem-debugging' style='display: none;'>Discount is not applicable</span>\n";
            } else {
                echo "<span id='azeem-debugging' style='display: none;'>Applying discount</span>\n";
            }

            $discount = $promotion->value;
            if ($discount > 0) {
                // if (session('pdiscount') == 1) {
                    // echo "<span id='azeem-debugging' style='display: none;'>pdiscount == 1</span>\n";
                    $price_tax = (float) $price - ((float) $product->price / (float) $discount);
                    // $price_sale = ((float) $product->front_sale_price_with_taxes / (float) $discount);
                    $price_sale = (float) $price - ((float) $price * (float) $discount / 100);
                // } else {
                    // echo "<span id='azeem-debugging' style='display: none;'>pdiscount != 1</span>\n";
                    // $price_tax = (float) $product->price_with_taxes - ((float) $product->price_with_taxes / (float) $discount);
                    // $price_sale = (float) $product->front_sale_price_with_taxes - ((float) $product->front_sale_price_with_taxes / (float) $discount);
                // }
            }

            // $price_sale = ((float) $price_tax / (float) $discount);
            // $price_sale = ((float) $price_tax / (float) $discount);
            // echo "<span id='azeem-debugging' style='display: none;'>Running promotion: ".$promotion->title."</span>\n";
        }
        // echo "<span id='azeem-debugging' style='display: none;'>Checking promotions for: $userCountryName</span>\n";
        // $is_discount = true;

        echo "<span id='azeem-debugging' style='display: none;'>price: ".$price."</span>\n";
        echo "<span id='azeem-debugging' style='display: none;'>price_tax: ".$price_tax."</span>\n";
        echo "<span id='azeem-debugging' style='display: none;'>product->price: ".$product->price."</span>\n";
        echo "<span id='azeem-debugging' style='display: none;'>product->front_sale_price: ".$product->front_sale_price."</span>\n";
        echo "<span id='azeem-debugging' style='display: none;'>product->front_sale_price_with_taxes: ".$product->front_sale_price_with_taxes."</span>\n";
        echo "<span id='azeem-debugging' style='display: none;'>discount: ".$discount."</span>\n";
        echo "<span id='azeem-debugging' style='display: none;'>price_sale: ".$price_sale."</span>\n";
        // echo "<span id='azeem-debugging' style='display: none;'>price_sale (2): ".((float) $price_tax / (float) $discount)."</span>\n";



        // Check if there is discount on price
        $show_dnone_1 = false;
        $show_dnone_2 = false;
        // if ($product->front_sale_price === $product->price) {
        if ($discount <= 0) {
            $show_dnone_1 = true;
        // } elseif ($product->front_sale_price !== $product->price) {
        } elseif ($discount > 0) {
            $show_dnone_2 = true;
        // } else (Arr::get($sessionData, 'promotion_discount_amount', 0) != $product->price) {
        //     $is_discount = false;
        }


    ?>
  
    <span class="product-price-sale align-items-center @if ($show_dnone_1) d-none @endif">
        <del aria-hidden="true">
            <span class="price-amount">
                <bdi>
                    <span class="amount">
                        {{ format_price($price) }}
                    </span>
                    <small><span>{{ __('TAXES EXCLUDED') }}</span></small>
                </bdi>

                
            </span>
        </del>
        <ins>
            <span class="price-amount">
                <bdi>
                    <span class="amount">{{ format_price($price_sale) }}</span>
                    <small><span>{{ __('TAXES EXCLUDED') }}</span></small>
                </bdi>
            </span>
        </ins>
    </span>


    <span class="product-price-original @if ($show_dnone_2) d-none @endif" style="padding-top:17px">
        <span class="price-amount">
            <bdi>
              
                <span class="amount">{{ format_price($price) }}</span>
                <small><span>{{ __('TAXES EXCLUDED') }}</span></small>
            </bdi>
        </span>
    </span>
</span>