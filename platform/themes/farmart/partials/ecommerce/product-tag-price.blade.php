<?php
// print_r($product);
?>
<span class="product-price">
    <?php
 
    if($product->sale_price != 0 && $product->sale_price !=='' && $product->sale_price !== $product->price){
    ?>
    <span class="product-price-sale d-flex align-items-center @if ($product->sale_price === '' || $product->sale_price ===0 || $product->sale_price !== $product->price) d-none @endif">
        
        <del aria-hidden="true">
            <span class="price-amount">
                <?php

                    // use Botble\Ecommerce\Models\Customer;
                    // use Botble\Ecommerce\Models\FlashSale;
                    // use Botble\Ecommerce\Models\FlashSaleProductPrice;
                    // use Illuminate\Support\Carbon;

                    // if(auth('customer')->check()){
                    //      $customer  =  Customer::find(Auth::guard('customer')->user()->id);
                    //      $categorie =  $customer->categories()->first();
                    //      if($categorie){
                    //         $categorie = $categorie->id;

                    //      }
                    // }else{
                    //     $categorie = 1;
                    // }

                    // $flashsale =  FlashSale::where('status','published')->where('end_date' , '>' , Carbon::now())->first();
                   

                    // $discount = 0;
                    // if($flashsale && $categorie){
                    //     $discount  = FlashSaleProductPrice::where('flash_sale_id' ,$flashsale->id)->where('category_id' , $categorie)->first();
                    //     if($discount){
                    //         $discount  = $discount->discount;
                    //     }
                    // }

                    $price_tax = (float)$product->price;
                    $price_sale = (float)$product->sale_price ;

                    // if($discount != 0){
                    //     $price_tax  =  (float)$product->price - (  (float)$product->price / (float)$discount);
                    //     $price_sale = (float)$product->sale_price - ((float)$product->sale_price / (float)$discount);
                    // }

                 ?>
                <bdi>
                    
                    <span class="amount">

                        {{ format_price($price_tax) }}
                    </span>
                </bdi>

                
            </span>
        </del>
        <ins>
            <span class="price-amount">
                <bdi>
                    <span class="amount">{{ format_price($price_sale) }}</span>
                </bdi>
            </span>
        </ins>
    </span>

    <?php
    }else{
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
    ?>
    <span  class="product-price-original ">
        <span class="price-amount">
            <bdi>
                <?php
                    // use Illuminate\Support\Facades\DB as DB;
                    $price = $product->price;
                    $country_id = 1;
                    if(session('country') != '') {
                        $country_id = session('country');
                    }

                    $priceInfo = DB::table('ec_product_price')->where('ec_products_id',$product->id)->where('countries_id',$country_id)->first();
                    
                    if($priceInfo) {
                        $price = $priceInfo->price;
                    }
                ?>
                <span class="amount">{{ format_price($price) }}</span>
            </bdi>
        </span>
    </span>
</span>

<?php } ?>
