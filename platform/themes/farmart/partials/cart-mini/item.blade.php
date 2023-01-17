<?php
 use Illuminate\Support\Facades\DB as DB;
 use Botble\Ecommerce\Models\Customer;
 use Botble\Ecommerce\Models\FlashSale;
 use Botble\Ecommerce\Models\FlashSaleProductPrice;
 use Illuminate\Support\Carbon;

?>
<li class="mini-cart-item row g-0">
    <div class="col-3">
        <div class="product-image">
            <a class="img-fluid-eq" href="{{ $product->original_product->url }}">
                <div class="img-fluid-eq__dummy"></div>
                <div class="img-fluid-eq__wrap">
                    <img class="lazyload" data-src="{{ Arr::get($cartItem->options, 'image', $product->original_product->image) }}" alt="{{ $product->original_product->name }}">
                </div>
            </a>
        </div>
    </div>
    <div class="col-7">
        <div class="product-content">
            <div class="product-name">
                <a href="{{ $product->original_product->url }}">{{ $product->original_product->name }}</a>
            </div>
            @if (is_plugin_active('marketplace') && $product->original_product->store->id)
                <div class="product-vendor">
                    <a class="text-primary ms-1" href="{{ $product->original_product->store->url }}">
                        {{ $product->original_product->store->name }}
                    </a>
                </div>
            @endif
            <span class="quantity">
                <span class="price-amount amount">
                <?php
                                                $recommendedCountryCode = '';
                                                if(!session('country')) {
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

                                                    if($response) {
                                                        $response = json_decode($response,true);
                                                        // dd($response);
                                                        if(isset($response['country'])){
                                                            $recommendedCountryCode = $response['country'];
                                                        }
                                                        foreach (Botble\Location\Models\Country::all() as $country){
                                                            // dd( $recommendedCountryCode);
                                                            if(strtolower($country->code) == strtolower($recommendedCountryCode)) {
                                                                // dd('running');
                                                                session(['country'=>$country->id]);
                                                            }
                                                        }

                                                        // dd(session('country'));
                                                    }
                                                }
                                                                
                                                    
                                                                $price = $product->price;
                                                                $country_id = 1;
                                                                if(session('country') != '') {
                                                                    $country_id = session('country');
                                                                }
                                                                // print_r($country_id);
                                                                $priceInfo = DB::table('ec_product_price')->where('ec_products_id',$product->id)->where('countries_id',$country_id)->first();
                                                                
                                                                if($priceInfo) {
                                                                    // print_r($priceInfo);
                                                                    $price = $priceInfo->price;
                                                                    $cartItem->price=$price;
                                                                }
                                                                
                                                               

                                                                if(auth('customer')->check()){
                                                                    $customer  =  Customer::find(Auth::guard('customer')->user()->id);
                                                                    $categorie =  $customer->categories()->first();
                                                                    if($categorie){
                                                                        $categorie = $categorie->id;

                                                                    }
                                                                }else{
                                                                    $categorie = 1;
                                                                }

                                                                $flashsale =  FlashSale::where('status','published')->where('end_date' , '>' , Carbon::now())->first();
                                                            

                                                                $discount = 0;
                                                                if($flashsale && $categorie){
                                                                    $discount  = FlashSaleProductPrice::where('flash_sale_id' ,$flashsale->id)->where('category_id' , $categorie)->first();
                                                                    if($discount){
                                                                        $discount  = $discount->discount;
                                                                    }
                                                                }
                                                        
                                                                if(session('pdiscount') == 1) {
                                                                    $price_tax = (float)$price ;
                                                                }else{
                                                                    $price_tax = (float)$product->price_with_taxes ;

                                                                }
                                                            
                                                               $price_sale = (float)$product->front_sale_price_with_taxes ;

                                                                if($discount != 0){
                                                                    
                                                                    if(session('pdiscount') == 1) {
                                                                      $price_tax  =  $price;//(float)$price - (  (float)$product->price / (float)$discount);
                                                                      $price_sale = (float)$product->front_sale_price_with_taxes ;//- ((float)$product->front_sale_price_with_taxes / (float)$discount);

                                                                    }
                                                                    else{
                                                                        $price_tax  =  (float)$product->price_with_taxes - (  (float)$product->price_with_taxes / (float)$discount);
                                                                        $price_sale = (float)$product->front_sale_price_with_taxes - ((float)$product->front_sale_price_with_taxes / (float)$discount);

                                                                    }
                                                                //   
                                                                    $cartItem->price=$price_sale;
                                                                    $product->price=$price_tax;
                                                                }
                                                                    
                                                                   
                                                                    // echo $cartItem->price;
                                                            ?>
                                                    <bdi> @if ($product->front_sale_price != $product->price)
                                                            {{ format_price($cartItem->price) }}
                                                            <small><del>{{ format_price($product->price) }}</del></small>
                                                            @else
                                                                <?php $cartItem->price=$price; ?>
                                                            {{ format_price($cartItem->price) }}
                                                        @endif</bdi>
                </span>
                (x{{ $cartItem->qty }})
            </span>
            <p class="mb-0">
                <small>
                    <small>{{ $cartItem->options['attributes'] ?? '' }}</small>
                </small>
            </p>
            @if (!empty($cartItem->options['options']))
                {!! render_product_options_info($cartItem->options['options'], $product, true) !!}
            @endif

            @if (!empty($cartItem->options['extras']) && is_array($cartItem->options['extras']))
                @foreach($cartItem->options['extras'] as $option)
                    @if (!empty($option['key']) && !empty($option['value']))
                        <p class="mb-0"><small>{{ $option['key'] }}: <strong> {{ $option['value'] }}</strong></small></p>
                    @endif
                @endforeach
            @endif
        </div>
    </div>
    <div class="col-2">
        <a class="btn remove-cart-item" href="#"
            data-url="{{ route('public.cart.remove', $cartItem->rowId) }}"
            aria-label="{{ __('Remove this item') }}">
            <span class="svg-icon">
                <svg>
                    <use href="#svg-icon-trash" xlink:href="#svg-icon-trash"></use>
                </svg>
            </span>
        </a>
    </div>
</li>
