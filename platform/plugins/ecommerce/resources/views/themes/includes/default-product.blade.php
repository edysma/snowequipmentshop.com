<?php
 use Illuminate\Support\Facades\DB as DB;
 use Botble\Ecommerce\Models\Customer;
 use Botble\Ecommerce\Models\FlashSale;
 use Botble\Ecommerce\Models\FlashSaleProductPrice;
 use Illuminate\Support\Carbon;

?>

@php
    $isConfigurable = $product->variations()->count() > 0;
@endphp
<div class="col-md-4 col-6">

    <div class="block2-img wrap-pic-w of-hidden pos-relative
        @if ($product->front_sale_price != $product->price) block2-labelsale @endif">
        <a href="{{ $product->url }}" class="block2-name dis-block s-text3 p-b-5">
        <img style="width: auto;" src="{{ RvMedia::getImageUrl($product->image, 'product-thumbnail', false, RvMedia::getDefaultImage()) }}"
             alt="{{ $product->name }}">
             <span class="ribbons">
            @if ($product->isOutOfStock())
                <span class="ribbon out-stock">{{ __('Out Of Stock') }}</span>
            @else
                @if ($product->productLabels->count())
                    @foreach ($product->productLabels as $label)
                        <span class="ribbon" @if ($label->color) style="background-color: {{ $label->color }}" @endif>{{ $label->name }}</span>
                    @endforeach
                @else
                    @if ($product->front_sale_price !== $product->price)
                        <div class="featured ribbon" dir="ltr">{{ get_sale_percentage($product->price, $product->front_sale_price) }}</div>
                    @endif
                @endif
            @endif
        </span>
             </a>
        <div class="block2-overlay trans-0-4">
            @if (EcommerceHelper::isWishlistEnabled())
                <a href="{{ route('public.wishlist.add', $product->slug) }}"
                   class="block2-btn-addwishlist hov-pointer trans-0-4">
                    <i class="icon-wishlist icon_heart_alt" aria-hidden="true"></i>
                    <i class="icon-wishlist icon_heart dis-none" aria-hidden="true"></i>
                </a>
            @endif

            @if (!$isConfigurable)
                <div class="block2-btn-addcart w-size1 trans-0-4">
                    <!-- Button -->
                    <button data-route="{{ route('public.cart.add-to-cart') }}"
                            data-id="{{ $product->id }}"
                            class="flex-c-m size1 bg4 bo-rad-23 hov1 s-text1 trans-0-4 add-cart-btn">
                        {{ __('Buy') }}
                    </button>
                </div>
            @else
                <div class="block2-btn-addcart w-size1 trans-0-4">
                    <!-- Button -->
                    <a href="{{ $product->url }}" class="flex-c-m size1 bg4 bo-rad-23 hov1 s-text1 trans-0-4">
                        {{ __('View') }}
                    </a>
                </div>
            @endif

        </div>
    </div>

    <div class="block2-txt p-t-20">
        <a href="{{ $product->url }}" class="block2-name dis-block s-text3 p-b-5">
            {{ $product->name }}
        </a>

        <span class="block2-price m-text6 p-r-5">
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
                                                                    // $cartItem->price=$price_sale;
                                                                    // $product->price=$price_tax;
                                                                }
                                                                    
                                                                   
                                                                    // echo $cartItem->price;
                                                            ?>
			@if ($product->front_sale_price !== $product->price)
                <span class="block2-oldprice m-text8 p-r-5 amount" style="text-decoration: line-through;">
                    {{ format_price($price_tax ) }}
                </span>
                &nbsp;
                <span class="block2-newprice m-text7 p-r-5">
                    {{ format_price($price_sale) }}
                </span>
                <small><span>{{ __('TAXES EXCLUDED') }}</span></small>
            @else
                <span class="block2-newprice m-text8 p-r-5">
                    {{ format_price($price) }}
                </span>
                <small><span>{{ __('TAXES EXCLUDED') }}</span></small>
            @endif
		</span>
    </div>

</div>
