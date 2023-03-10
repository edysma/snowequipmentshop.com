<?php
$con=mysqli_connect("localhost","snownew","Hzf53s6_6%_","snownew",3306);
$query="SELECT count(*) as reviews_count , avg(star) as reviews_avg FROM  `ec_reviews` WHERE product_id=".$product->id."";
$rs=mysqli_query($con,$query);

$review=mysqli_fetch_assoc($rs);
// print_r($row);
?>
<article class="post-item-wrapper">
<div class="product-thumbnail">
    <a class="product-loop__link img-fluid-eq" href="{{$product->url}}" tabindex="0">
        <div class="img-fluid-eq__dummy"></div>
        <div class="img-fluid-eq__wrap">
            <img class="lazyload product-thumbnail__img"
                src="{{ image_placeholder($product->image, 'small') }}"
                data-src="{{ RvMedia::getImageUrl($product->image, 'small', false, RvMedia::getDefaultImage()) }}"
                alt="{{ $product->name }}">
        </div>
        
    </a>
    {!! Theme::partial('ecommerce.product-loop-buttons', compact('product') + (!empty($wishlistIds) ? compact('wishlistIds') : [])) !!}
</div>
<div class="product-details position-relative">
    <div class="product-content-box">
        @if (is_plugin_active('marketplace') && $product->store_id)
            <div class="sold-by-meta"> 
              
            </div>
        @endif
        <h3 class="product__title">
            <a href="{{$product->url}}" tabindex="0">{{ $product->name }}</a>
        </h3> 
       @if (EcommerceHelper::isReviewEnabled())
            {!! Theme::partial('star-rating', ['avg' => $review['reviews_avg'], 'count' => $review['reviews_count'] ]) !!}
        @endif
        {!! Theme::partial('ecommerce.product-price', compact('product')) !!}

        @if (!empty($isFlashSale))
            <div class="deal-sold row mt-2">
                <div class="deal-text col-auto">
                    <span class="sold fw-bold">
                        @if ($product->pivot->quantity > $product->pivot->sold)
                            <span class="text">{{ __('Sold') }}: </span>
                            <span class="value">{{ (int) $product->pivot->sold }} / {{ (int) $product->pivot->quantity }}</span>
                        @else
                            <span class="text text-danger">{{ __('Sold out') }}</span>
                        @endif
                    </span>
                </div>
                <div class="deal-progress col">
                    <div class="progress">
                        <div class="progress-bar"
                            role="progressbar"
                            aria-valuenow="{{ $product->pivot->quantity > 0 ? ($product->pivot->sold / $product->pivot->quantity) * 100 : 0 }}"
                            aria-valuemin="0"
                            aria-valuemax="100"
                            style="width: {{ $product->pivot->quantity > 0 ? ($product->pivot->sold / $product->pivot->quantity) * 100 : 0 }}%">
                        </div>
                    </div>
                </div>
            </div>
        @endisset
    </div>
   
</div>
</article>