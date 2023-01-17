
<div class="recently-product-wrapper">
<?php  //if(isset($product)){ ?>
    @if ($products->count())
    
        <ul class="product-list"
            data-slick="{{ json_encode(['arrows' => true, 'dots' => false, 'autoplay' => false, 'infinite' => true, 'slidesToShow' => 10]) }}">
            @foreach ($products as $product)
                <li class="product">
                    <a href="{{ $product->url }}">
                        <img src="{{ RvMedia::getImageUrl($product->image, 'small', false, RvMedia::getDefaultImage()) }}" alt="{{ $product->name }}"/>
                    </a>
                    <div class="ps-product__content"><a class="ps-product__title" style="border:0px !important;font-size:12px" href="{{ $product->url }}">{{ $product->name }}</a>
                               
                            </div>
                </li>
            @endforeach
        </ul>
    @else
        <div class="recently-empty-products text-center">
            <div class="empty-desc">
                <span>{{ __('Recently Viewed Products is a function which helps you keep track of your recent viewing history.') }}</span>
                <a class="text-primary" href="{{ route('public.products') }}">{{ __('Shop Now') }}</a>
            </div>
            <div class="ps-product__content"><a class="ps-product__title" style="border:0px !important;font-size:12px" href="{{ $product->url }}">{{ $product->name }}</a>
                              
                            </div>
        </div>
    @endif
    <?php //} ?>
<div>
