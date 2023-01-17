<div class="summary-meta d-flex">
    @if ($product->isOutOfStock())
        <div class="product-stock out-of-stock d-inline-block">
            <label>{{ __('Availability') }}:</label>{{ __('Out of stock') }}
        </div>
    @else
        @if (!$productVariation)
            <div class="product-stock out-of-stock d-inline-block">
                <label>{{ __('Availability') }}:</label>{{ __('Not available') }}
            </div>
        @else
            @if ($productVariation->isOutOfStock())
                <div class="product-stock out-of-stock d-inline-block">
                    <label>{{ __('Availability') }}:</label>{{ __('Out of stock') }}
                </div>
            @elseif  (!$productVariation->with_storehouse_management || $productVariation->quantity < 1)
                <div class="product-stock in-stock d-inline-block">
                    
                    <label>{{ __('Availability') }}:</label> {!! BaseHelper::clean($productVariation->stock_status_html) !!}
                </div>
                <span class="ribbons d-flex align-center m-4 ">
                    @if ($product->isOutOfStock())
                        <span class="ribbon out-stock" style="position:relative;">{{ __('Out Of Stock') }}</span>
                    @else
                        @if ($product->productLabels->count())
                            @foreach ($product->productLabels as $label)
                                <span class="ribbon" @if ($label->color) style="position:relative; background-color: {{ $label->color }}" @endif>{{ $label->name }}</span>
                            @endforeach
                        @else
                            @if ($product->front_sale_price !== $product->price)
                                <div class="featured ribbon" style="position:relative;" dir="ltr">{{ get_sale_percentage($product->price, $product->front_sale_price) }}</div>
                            @endif
                        @endif
                    @endif
                </span>
                
            @elseif ($productVariation->quantity)
                @if (EcommerceHelper::showNumberOfProductsInProductSingle())
                    <div class="product-stock in-stock d-inline-block">
                        <label>{{ __('Availability') }}:</label>
                        @if ($productVariation->quantity != 1)
                            {{ __(':number products available', ['number' => $productVariation->quantity]) }}
                        @else
                            {{ __(':number product available', ['number' => $productVariation->quantity]) }}
                        @endif
                    </div>
                @else
                    <div class="product-stock in-stock d-inline-block">
                        <label>{{ __('Availability') }}:</label>{{ __('In stock') }}
                    </div>
                @endif
            @endif
        @endif
    @endif
</div>
