<div class="product-gallery product-gallery--with-images row">
    <div class="product-gallery__wrapper">
    @php
            
            if(!empty($product->video_link)){
                foreach(explode('|',$product->video_link) as $video_link){
        @endphp
            <div class="product-gallery__image item">
                <a class="img-fluid-eq1" href="{{$video_link}}" >
                    <div class="img-fluid-eq__dummy"></div>
                    <div class="img-fluid-eq__wrap">
                    <iframe width="100%" height="315" src="<?=str_replace('watch','embed',str_replace('?v=','/',str_replace(' ','',$video_link)))?>?autoplay=1&mute=1" frameborder="0" allowfullscreen>
                    </iframe>
                    </div>
                </a>
            </div>
            
        @php
                }
            }    
            
        @endphp
        @forelse ($productImages as $img)
            <div class="product-gallery__image item">
                <a class="img-fluid-eq1" href="{{ RvMedia::getImageUrl($img) }}">
                    <div class="img-fluid-eq__dummy"></div>
                    <div class="img-fluid-eq__wrap">
                        <img class="mx-auto" title="{{ $product->name }}" src="{{ image_placeholder($img) }}" data-lazy="{{ RvMedia::getImageUrl($img) }}">
                    </div>
                </a>
            </div>
        @empty
            <div class="product-gallery__image item">
                <a class="img-fluid-eq" href="{{ image_placeholder() }}">
                    <div class="img-fluid-eq__dummy"></div>
                    <div class="img-fluid-eq__wrap">
                        <img class="mx-auto" title="{{ $product->name }}" src="{{ image_placeholder() }}">
                    </div>
                </a>
            </div>
        @endforelse
        
        
    </div>

    <div class="product-gallery__variants px-1">
        @php
        if(!empty($product->video_link)){
                foreach(explode('|',$product->video_link) as $video_link){
            @endphp
            <div class="item">
                    <div class="border p-1 m-1">
                    <iframe width="100%" height="45" src="<?=str_replace('watch','embed',str_replace('?v=','/',str_replace(' ','',$video_link)))?>" frameborder="0">
                    </iframe>
                        </div>
                </div>
        
            @php
                }
            }
            @endphp    
        @forelse ($productImages as $img)
            <div class="item">
                <div class="border p-1 m-1">
                    <img class="lazyload" title="{{ $product->name }}" src="{{ image_placeholder($img, 'thumb') }}" data-src="{{ RvMedia::getImageUrl($img, 'thumb') }}">
                </div>
            </div>
        @empty
            <div class="item">
                <div class="border p-1 m-1">
                    <img title="{{ $product->name }}" src="{{ image_placeholder() }}">
                </div>
            </div>
        @endforelse
        
    </div>
</div>
