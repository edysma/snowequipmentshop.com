@php
    Theme::layout('full-width');
    Theme::set('bodyClass', 'single-product');
    use Illuminate\Support\Str;
@endphp
{!! Theme::partial('page-header', ['size' => 'xxxl']) !!}


<div class="product-detail-container">
    <div class="bg-light py-md-5 px-lg-3 px-2">
        <div class="container-xxxl rounded-7 bg-white py-lg-5 py-md-4 py-3 px-3 px-md-4 px-lg-5">
            <div class="row">
            <div class="entry-product-header">
                            <div class="product-header-left product_custom_css" style="width: 50%; float:left;">
                                <h1 class="product_title entry-title" style="font-size: 1.2rem !important;">{{ $product->name }}</h1>
                                <!-- <h1 class="product_title entry-title" style="font-size: 1.2rem !important;">{{ $product->product_file_pdf }}</h1> -->
                                <div class="product-entry-meta">
                                    @if ($product->brand_id)
                                        <!-- <p class="mb-0 me-2 pe-2 text-secondary">{{ __('Brand') }}: <a href="{{ $product->brand->url }}">{{ $product->brand->name }}</a></p> -->
                                    @endif
                                    

                                    @if (EcommerceHelper::isReviewEnabled())
                                        <a href="#product-reviews-tab" class="anchor-link">
                                            {!! Theme::partial('star-rating', ['avg' => $product->reviews_avg, 'count' => $product->reviews_count]) !!}
                                        </a>
                                    @endif
                                </div>
                                <div style="" class="meta-sku @if (!$product->sku) d-none @endif">
                            <span class="meta-label d-inline-block">{{ __('SKU') }}:</span>
                            <span class="meta-value">{{ $product->sku }}</span>
                        </div>
                        <div style="margin-left:0" class="meta-sku @if (!$product->ean) d-none @endif">
                            <span class="meta-label d-inline-block">{{ __('EAN') }}:</span>
                            <span class="meta-value">{{ $product->ean }}</span>
                        </div>
                            </div>
                          
                            <div class="product-header-right product_custom_css" style="width: 50%; float:right;margin-top: -48px;">
                            @if (theme_option('social_share_enabled', 'yes') == 'yes')
                            <div class="my-5 " style="float:right">
                                {!! Theme::partial('share-socials', compact('product')) !!}
                            </div>
                        @endif
</div>
                        </div>
                <div class="col-lg-5 col-md-12 mb-md-5 pb-md-5 mb-3 d-inline">
              
                    {!! Theme::partial('ecommerce.product-gallery', compact('product', 'productImages')) !!}
                    <div class="col-lg-12 mobile_css_bottom_custom_button ">
                    <?php if($product->btn_text != ""){

                     ?>
                    
                   <a href="/storage/{{$product->file_path}}" style="" target="_blank" class="btn btn-primary mb-2 dbtns">
                   <img src="/storage/icons/icon-download-pdf.png"> <br>
     
                   <label style="font-size:14px" class="text-title-field">{{$product->btn_text}}</label><br>
                        <?//= __('SCARICA IL CATALOGO')?>
                    </a>
                    <?php  } ?>
                    <?php if($product->btn_text_one != ""){

                    ?>
                    <a href="" onclick="return false;" style="" id="myBtn1" class="btn btn-primary mb-2 dbtns">
                    <img src="/storage/icons/icon-zoom.png"> <br>
                        <label style="font-size:14px" class="text-title-field">{{ __('ESPLORA IL PRODOTTO') }}</label> <br>
                        
                    </a>
                    <?php }?>
                    <?php if($product->btn_text_two != ""){
                    ?>
                    <a href="" style="" onclick="return false;" id="myBtn2" class="btn btn-primary mb-2 dbtns">
                    <img src="/storage/icons/icon-virtual.png"> <br>
                    <label class="text-title-field" style="font-size:14px">{{ __('GUARDA IL VIRTUAL TOUR ') }}</label> <br>
                        </a>

                    <?php } ?>
                    </div>
                </div>
                
                <!--Start Modal Custom Code-->
                <!-- Trigger/Open The Modal -->
                <!-- The Modal -->
                    <div id="myModal1" class="modal modal-responsive">
                        <!-- Modal content -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <span class="close">&times;</span>
                            </div>
                            <div class="modal-body" style="height:40rem;width:100%;max-width:40rem;">
                                
                                <iframe src="<?=$product->btn_text_one?>" width="100%" height="100%"></iframe>
                                
                            </div>
                        </div>
                    </div>
                   
                    <div id="myModal2" class="modal modal-responsive">
                        <!-- Modal content -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <span class="close">&times;</span>
                            </div>
                            <div class="modal-body" style="height:40rem;width:100%;max-width:40rem;">
                            <iframe src="<?=$product->btn_text_two?>" width="100%" height="100%"></iframe>
                            </div>
                        </div>
                    </div>
            <!--End Modal Custom Code-->


                <div class="col-lg-4 col-md-8 ps-4 product-details-content">
                    <div class="product-details js-product-content">
                       
                    <div style="float: left;
    margin-top: 20px;
    font-size: 20px;
    font-weight: bold; margin-right:10px;color: #888888;"> {{ __('Price') }}: 
     </div> 
     {!! Theme::partial('ecommerce.product-price', compact('product')) !!}

                        @if (is_plugin_active('marketplace') && $product->store_id)
                            <div class="product-meta-sold-by my-2">
                                <span class="d-inline-block">{{ __('Sold By') }}: </span>
                                <a href="{{ $product->store->url }}">
                                    {{ $product->store->name }}
                                </a>
                            </div>
                        @endif
                       
                      

                        {!! Theme::partial('ecommerce.product-availability', compact('product', 'productVariation')) !!}

                        @if ($flashSale = $product->latestFlashSales()->first())
                            <div class="deal-expire-date p-4 bg-light mb-2">
                                <div class="row">
                                    <div class="col-xxl-5 d-md-flex justify-content-center align-items-center">
                                        <div class="deal-expire-text mb-2">
                                            <div class="fw-bold text-uppercase">{{ __('Hurry up! Sale end in') }}</div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-7">
                                        <div class="countdown-wrapper d-none">
                                            <div class="expire-countdown col-auto" data-expire="{{ now()->diffInSeconds($flashSale->end_date) }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row align-items-center my-3">
                                    <div class="deal-sold row mt-2">
                                        <div class="deal-text col-auto">
                                            <span class="sold fw-bold">
                                                <span class="text">{{ __('Sold') }}: </span>
                                                <span class="value">{{ $flashSale->pivot->sold . '/' .
                                                    $flashSale->pivot->quantity }}</span>
                                            </span>
                                        </div>
                                        <div class="deal-progress col">
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar"
                                                    aria-valuenow="{{ $flashSale->pivot->quantity > 0 ? ($flashSale->pivot->sold / $flashSale->pivot->quantity) * 100 : 0 }}"
                                                    aria-valuemin="0" aria-valuemax="100"
                                                    style="width: {{ $flashSale->pivot->quantity > 0 ? ($flashSale->pivot->sold / $flashSale->pivot->quantity) * 100 : 0 }}%;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="ps-list--dot">
                            {!! apply_filters('ecommerce_before_product_description', null, $product) !!}
                            
                            @if ($product->description != "")
                            <div id="shortdesc">
                                {!! Str::limit($product->description, 300, '...') !!}
                                <br>
                                <a href="javascript:void(0)" id="proddesc" style="font-weight: bold; text-align:center"> {{ __('Find out more about the product') }}</a>
                            </div>
                            @endif
                                                
                            {!! apply_filters('ecommerce_after_product_description', null, $product) !!}
                            
                        </div>
                        {!! Theme::partial('ecommerce.product-cart-form',
                            compact('product', 'selectedAttrs') + ['withButtons' => true, 'withVariations' => true, 'wishlistIds' => [], 'withBuyNow' => true]) !!}
                        <!-- <div class="meta-sku @if (!$product->sku) d-none @endif">
                            <span class="meta-label d-inline-block">{{ __('SKU') }}:</span>
                            <span class="meta-value">{{ $product->sku }}</span>
                        </div> -->
                        @if ($product->categories->count())
                            <div class="meta-categories">
                                <span class="meta-label d-inline-block">{{ __('Categories') }}:</span>
                                @foreach($product->categories as $category)
                                    <a href="{{ $category->url }}">{{ $category->name }}</a>@if (!$loop->last), @endif
                                @endforeach
                            </div>
                        @endif
                        @if ($product->tags->count())
                            <div class="meta-categories">
                                <span class="meta-label d-inline-block">{{ __('Tags') }}:</span>
                                @foreach($product->tags as $tag)
                                    <a href="{{ $tag->url }}">{{ $tag->name }}</a>@if (!$loop->last), @endif
                                @endforeach
                            </div>
                        @endif
                        
                    </div>
                </div>
                <div class="col-lg-3 col-md-4">
                    {!! dynamic_sidebar('product_detail_sidebar' , $product->id) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="container-xxxl">
        <div id="product_detail_tabs" class="row product-detail-tabs mt-3 mb-4">
            <div class="col-md-12">
                <div class="nav flex-column nav-pills me-3" id="product-detail-tabs" role="tablist"
                    aria-orientation="vertical">
                   <?php 
                   if($product->description != ""){
                   ?>
                    <a class="nav-link"
                        id="product-description-tab"
                        data-bs-toggle="pill"
                        href="#product-description"
                        type="button"
                        role="tab"
                        aria-controls="product-description"
                        aria-selected="true">
                        {{ __('Product Description') }}
                    </a>
            <?php    } ?>
                    <a class="nav-link"
                        id="product-additional-tab"
                        data-bs-toggle="pill"
                        href="#product-additional"
                        type="button"
                        role="tab"
                        aria-controls="product-additional"
                        aria-selected="true">
                        {{ __('Additional Information') }}
                    </a>
                    @if (EcommerceHelper::isReviewEnabled())
                        <a class="nav-link"
                            id="product-reviews-tab"
                            data-bs-toggle="pill"
                            href="#product-reviews"
                            type="button"
                            role="tab"
                            aria-controls="product-reviews"
                            aria-selected="false">
                            {{ __('Reviews') }} ({{ $product->reviews_count }})
                        </a>
                    @endif
                    @if (is_plugin_active('marketplace') && $product->store_id)
                        <a class="nav-link"
                            id="product-vendor-info-tab"
                            data-bs-toggle="pill"
                            href="#product-vendor-info"
                            type="button"
                            role="tab"
                            aria-controls="product-vendor-info"
                            aria-selected="false">
                            {{ __('Vendor Info') }}
                        </a>
                    @endif
                    @if (is_plugin_active('faq') && count($product->faq_items) > 0)
                        <a class="nav-link"
                            id="product-faqs-tab"
                            data-bs-toggle="pill"
                            href="#product-faqs"
                            type="button"
                            role="tab"
                            aria-controls="product-faqs"
                            aria-selected="false">
                            {{ __('Questions & Answers') }}
                        </a>
                    @endif

                    <a class="nav-link"
                        id="product-moreinfo-tab"
                        data-bs-toggle="pill"
                        href="#product-moreinfo"
                        type="button"
                        role="tab"
                        aria-controls="product-moreinfo"
                        aria-selected="true">
                        {{ __('Request more info') }}
                    </a>

                    <a class="nav-link"
                        id="product-crossselling-tab"
                        data-bs-toggle="pill"
                        href="#product-crossselling"
                        type="button"
                        role="tab"
                        aria-controls="product-crossselling"
                        aria-selected="true">
                        {{ __('cross selling products') }}
                    </a>
                </div>
            </div>
            <div class="col-md-12">
                <div class="tab-content" id="product-detail-tabs-content">
        
                        @if (theme_option('facebook_comment_enabled_in_product', 'yes') == 'yes')
                            <br />
                            {!! apply_filters(BASE_FILTER_PUBLIC_COMMENT_AREA, Theme::partial('comments')) !!}
                        @endif
                    </div>
                   
                    <?php 
                   if($product->description != ""){
                    
                   ?>
                    <div class="tab-pane fade show active" id="product-description" role="tabpanel"
                        aria-labelledby="product-description-tab">
                        <!-- {!! BaseHelper::clean($product->description) !!} -->
                        <div id="lessdesc">  
                            {!! BaseHelper::clean(substr($product->description,0,$product->readmore)) !!}
                            <a href="javascript:void(0)" id="moredescbtn"> {{ __('read more') }} </a>
                        </div>
                        <div id="moredesc">  
                            {!! BaseHelper::clean($product->description) !!} 
                            <a href="javascript:void(0)" id="lessdescbtn"> {{ __('show less') }} </a>
                        </div>
                    </div>
             
        <?php } ?>

                    <div class="tab-pane fade" id="product-additional" role="tabpanel"
                        aria-labelledby="product-additional-tab">
                        {!! BaseHelper::clean($product->content) !!}

                       
                    </div>
                    @if (EcommerceHelper::isReviewEnabled())
                        <div class="tab-pane fade" id="product-reviews" role="tabpanel"
                            aria-labelledby="product-reviews-tab">
                            <div class="product-panel-reviews">
                                <div class="row">
                                    <div class="col-md-5 col-sm-12 col-xs-12 col-average-rating">
                                        <div class="row justify-content-center">
                                            <div class="col-md-10">
                                                <div class="average-rating border py-4 px-4">
                                                    <h3 class="h1 average-value text-red">{{ number_format($product->reviews_avg, 2) }}</h3>
                                                    <div class="product-rating border-bottom pb-3">
                                                        {!! Theme::partial('star-rating', ['avg' => $product->reviews_avg, 'count' => $product->reviews_count]) !!}
                                                    </div>
                                                    <div class="bar-rating pt-3">
                                                        @foreach (EcommerceHelper::getReviewsGroupedByProductId($product->id, $product->reviews_count) as $item)
                                                            <div class="star-item @if (!$item['count']) disabled @endif">
                                                                <span class="slabel">{{ __(':number Stars', ['number' => $item['star']]) }}</span>
                                                                <div class="progress">
                                                                    <div class="progress-bar"
                                                                        role="progressbar"
                                                                        aria-valuenow="{{ $item['percent'] }}"
                                                                        aria-valuemin="0"
                                                                        aria-valuemax="100"
                                                                        style="width: {{ $item['percent'] }}%"></div>
                                                                </div>
                                                                <span class="svalue">{{ $item['percent'] }} %</span>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-7 col-sm-12 col-xs-12 col-review-form">
                                        <div id="review-form-wrapper">
                                            <div id="review-form">
                                                <div class="comment-respond">
                                                    <h5 class="comment-reply-title text-uppercase">{{ __('Add your review') }}</h5>
                                                    <div class="comment-notes">
                                                        <span>{{ __('Your email address will not be published.') }}</span> {{ __('Required fields are marked') }}
                                                        <span class="required"></span>
                                                    </div>
                                                    {!! Form::open([
                                                        'route'  => 'public.reviews.create',
                                                        'method' => 'POST',
                                                        'class'  => 'form-review-product',
                                                        'files'  => true,
                                                    ]) !!}
                                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                        <div class="row">
                                                            <div class="col-12 mb-3 d-flex mt-2">
                                                                <label class="required" for="rating">{{ __('Your rating') }}:</label>
                                                                <div class="form-rating-stars ms-2">
                                                                    @for ($i = 5; $i >= 1; $i--)
                                                                        <input class="btn-check" type="radio" id="rating-star-{{ $i }}" name="star" value="{{ $i }}">
                                                                        <label for="rating-star-{{ $i }}" title="{{ $i }} stars">
                                                                            <span class="svg-icon">
                                                                                <svg>
                                                                                    <use href="#svg-icon-star" xlink:href="#svg-icon-star"></use>
                                                                                </svg>
                                                                            </span>
                                                                        </label>
                                                                    @endfor
                                                                </div>
                                                            </div>
                                                            <div class="col-12 mb-3">
                                                                <label class="required" for="comment">{{ __('Review') }}:</label>
                                                                <textarea class="form-control" name="comment" id="txt-comment" required aria-required="true"
                                                                    rows="8" placeholder="{{ __('Write your review') }}"></textarea>
                                                            </div>
                                                            <div class="col-12 mb-3 form-group">
                                                                <script type="text/x-custom-template" id="review-image-template">
                                                                    <span class="image-viewer__item" data-id="__id__">
                                                                        <img src="{{ RvMedia::getDefaultImage() }}" alt="Preview" class="img-responsive d-block">
                                                                        <span class="image-viewer__icon-remove">
                                                                            <i class="icon-cross-circle"></i>
                                                                        </span>
                                                                    </span>
                                                                </script>
                                                                <div class="image-upload__viewer d-flex">
                                                                    <div class="image-viewer__list position-relative">
                                                                        <div class="image-upload__uploader-container">
                                                                            <div class="d-table">
                                                                                <div class="image-upload__uploader">
                                                                                    <i class="icon-file-image image-upload__icon"></i>
                                                                                    <div class="image-upload__text">{{ __('Upload photos') }}</div>
                                                                                    <input type="file"
                                                                                        name="images[]"
                                                                                        data-max-files="{{ EcommerceHelper::reviewMaxFileNumber() }}"
                                                                                        class="image-upload__file-input"
                                                                                        accept="image/png,image/jpeg,image/jpg"
                                                                                        multiple="multiple"
                                                                                        data-max-size="{{ EcommerceHelper::reviewMaxFileSize(true) }}"
                                                                                        data-max-size-message="{{ trans('validation.max.file', ['attribute' => '__attribute__', 'max' => '__max__']) }}">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="loading">
                                                                            <div class="half-circle-spinner">
                                                                                <div class="circle circle-1"></div>
                                                                                <div class="circle circle-2"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="help-block">
                                                                    {{ __('You can upload up to :total photos, each photo maximum size is :max kilobytes', [
                                                                            'total' => EcommerceHelper::reviewMaxFileNumber(),
                                                                            'max'   => EcommerceHelper::reviewMaxFileSize(true),
                                                                        ]) }}
                                                                </div>

                                                            </div>
                                                            <div class="col-12 form-submit">
                                                                <button class="btn btn-primary" type="submit" @if (!auth('customer')->check()) disabled @endif>
                                                                    <span class="svg-icon">
                                                                        <svg>
                                                                            <use href="#svg-icon-send" xlink:href="#svg-icon-send"></use>
                                                                        </svg>
                                                                    </span>
                                                                    <span>{{ __('Submit Review') }}</span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    {!! Form::close() !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if (count($product->review_images))
                                    <div class="my-3">
                                        <h4>{{ __('Images from customer (:count)', ['count' => count($product->review_images)]) }}</h4>
                                        <div class="review-images row m-0 g-0 review-images-total">
                                            @foreach ($product->review_images as $img)
                                                <a href="{{ RvMedia::getImageUrl($img) }}" class="col-lg-1 col-sm-2 col-3 more-review-images @if ($loop->iteration > 12) d-none @endif">
                                                    <div class="border position-relative rounded">
                                                        <img src="{{ RvMedia::getImageUrl($img, 'thumb') }}" alt="{{ $product->name }}" class="img-fluid rounded h-100">
                                                        @if ($loop->iteration == 12 && (count($product->review_images) - $loop->iteration > 0))
                                                            <span>+{{ count($product->review_images) - $loop->iteration }}</span>
                                                        @endif
                                                    </div>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                @if ($product->reviews_count)
                                    <div class="product-reviews-container my-5">
                                        <h3 class="h5 my-4 fw-bold product-reviews-header">
                                            {{ __(':total review(s) for ":product"', [
                                                'total'   => $product->reviews_count,
                                                'product' => $product->name,
                                            ]) }}
                                        </h3>
                                        <product-reviews-component url="{{ route('public.ajax.product-reviews', $product->id) }}"></product-reviews-component>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                    @if (is_plugin_active('marketplace') && $product->store_id)
                        <div class="tab-pane fade" id="product-vendor-info" role="tabpanel"
                            aria-labelledby="product-vendor-info-tab">
                            @include(Theme::getThemeNamespace() . '::views.marketplace.includes.info-box', ['store' => $product->store])
                        </div>
                    @endif
                    @if (is_plugin_active('faq') && count($product->faq_items) > 0)
                        <div class="tab-pane fade" id="product-faqs" role="tabpanel" aria-labelledby="product-faqs-tab">
                            <div class="accordion" id="faq-accordion">
                                @foreach($product->faq_items as $faq)
                                    <div class="card">
                                        <div class="card-header" id="heading-faq-{{ $loop->index }}">
                                            <h2 class="mb-0">
                                                <button class="btn btn-link btn-block text-start @if (!$loop->first) collapsed @endif" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-faq-{{ $loop->index }}" aria-expanded="true" aria-controls="collapse-faq-{{ $loop->index }}">
                                                    {!! BaseHelper::clean($faq[0]['value']) !!}
                                                </button>
                                            </h2>
                                        </div>

                                        <div id="collapse-faq-{{ $loop->index }}" class="collapse @if ($loop->first) show @endif" aria-labelledby="heading-faq-{{ $loop->index }}" data-bs-parent="#faq-accordion">
                                            <div class="card-body">
                                                {!! BaseHelper::clean($faq[1]['value']) !!}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    <div class="tab-pane fade" id="product-moreinfo" role="tabpanel"
                        aria-labelledby="product-moreinfo-tab">
                        <!-- [contact-info-boxes title="Contattaci" address_1="Via dell'Industria, 34 41013 Piumazzo di Castelfranco Emilia (Modena), Italia" phone_1="(+39) 059 93 14 83" email_1="info@snowequipmentshop.com" show_contact_form="1" ][/contact-info-boxes] -->
                        [contact-info-boxes title="Contattaci" name_1="Snow Equipment Shop" address_1="Via dell'Industria, 34 41013 Piumazzo di Castelfranco Emilia (Modena), Italia" phone_1="(+39) 059 93 14 83" email_1="info@snowequipmentshop.com" show_contact_form="1"][/contact-info-boxes]

                       
                    </div>

                    <div class="tab-pane fade" id="product-crossselling" role="tabpanel"
                        aria-labelledby="product-crossselling-tab">
                        <div class="row">
                            @php
                                $crossSaleProducts = get_cross_sale_products($product);
                            @endphp
                            @foreach ($crossSaleProducts as $crossSaleProduct)
                                            @include('plugins/ecommerce::themes.includes.default-product', ['product' => $crossSaleProduct])
                            @endforeach                        
                        </div>                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="widget-products-with-category py-5 bg-light">
    <div class="container-xxxl">
        <div class="row">
            <div class="col-12">
                <div class="row align-items-center mb-2 widget-header">
                    <h2 class="col-auto mb-0 py-2" style="font-size: 22px;">{{ __('Related products') }}</h2>
                </div>
                <?php 
                 $relproducts = get_related_products($product, 30);
              

                ?>
                   <div class="list-post--wrapper">
                    <div class="slick-slides-carousel" data-slick="{{ json_encode([
                        'slidesToShow'   => 4,
                        'slidesToScroll' => 1,
                        'arrows'         => true,
                        'dots'           => true,
                        'infinite'        => false,
                        'responsive'     => [
                            [
                                'breakpoint' => 1200,
                                'settings'   => [
                                    'slidesToShow'   => 2,
                                    'slidesToScroll' => 1
                                ],
                            ],
                            [
                                'breakpoint' => 480,
                                'settings'   => [
                                    'slidesToShow'   => 1,
                                    'slidesToScroll' => 1
                                ],
                            ],
                        ],
                    ]) }}">
                  
                    @foreach ($relproducts as $relproduct)
                                        @include('plugins/ecommerce::themes.includes.default-product', ['product' => $relproduct])

                                        
                                    @endforeach
                 
                    </div>
                <!-- <related-products-component
                    limit="6"
                    url="{{ route('public.ajax.related-products', $product->id) }}"
                    slick_config="{{ json_encode([
                        'rtl' => BaseHelper::siteLanguageDirection() == 'rtl',
                        'appendArrows' => '.arrows-wrapper',
                        'arrows' => true,
                        'dots' => false,
                        'autoplay' => false,
                        'infinite' => false,
                        'autoplaySpeed' => 3000,
                        'speed' => 800,
                        'slidesToShow' => 6,
                        'slidesToScroll' => 1,
                        'swipeToSlide' => true,
                        'responsive' => [
                            [
                                'breakpoint' => 1400,
                                'settings' => [
                                    'slidesToShow' => 5,
                                ],
                            ],
                            [
                                'breakpoint' => 1199,
                                'settings' => [
                                    'slidesToShow' => 4,
                                ],
                            ],
                            [
                                'breakpoint' => 1024,
                                'settings' => [
                                    'slidesToShow' => 3,
                                ],
                            ],
                            [
                                'breakpoint' => 767,
                                'settings' => [
                                    'arrows' => true,
                                    'dots' => false,
                                    'slidesToShow' => 2,
                                    'slidesToScroll' => 2,
                                ],
                            ],
                        ],
                    ]) }}"
                ></related-products-component> -->
            </div>
        </div>
        <div class="row" style="    margin-top: 31px;
    border-top: 1px solid #b6b6b6;
    padding-top: 10px;">
            <div class="col-12">
        <div class="row align-items-center mb-2 widget-header">
                    <h2 class="col-auto mb-0 py-2" style="font-size: 22px;">{{ __('Other customers like you also saw ...') }}</h2>
                </div>
        @php
                            $crossSaleProducts = get_cross_sale_products($product,theme_option('number_of_cross_sale_product', 30));
                        @endphp
                    
                                    <div class="list-post--wrapper">
                    <div class="slick-slides-carousel" data-slick="{{ json_encode([
                        'slidesToShow'   => 4,
                        'slidesToScroll' => 1,
                        'arrows'         => true,
                        'dots'           => true,
                        'infinite'        => false,
                        'responsive'     => [
                            [
                                'breakpoint' => 1200,
                                'settings'   => [
                                    'slidesToShow'   => 2,
                                    'slidesToScroll' => 1
                                ],
                            ],
                            [
                                'breakpoint' => 480,
                                'settings'   => [
                                    'slidesToShow'   => 1,
                                    'slidesToScroll' => 1
                                ],
                            ],
                        ],
                    ]) }}">
                  
                    @foreach ($crossSaleProducts as $crossSaleProduct)
                                        @include('plugins/ecommerce::themes.includes.default-product', ['product' => $crossSaleProduct])

                                        
                                    @endforeach
                 
                    </div>
                    
                </div>
                    </div></div>
    </div>
</div>

<!-- add-to-cart sticky bar -->
<div id="sticky-add-to-cart">
    <form class="cart-form footer-cart-form" method="POST" action="{{ route('public.cart.add-to-cart') }}">
        @csrf
        <!-- <input type="hidden"
               name="id" class="hidden-product-id"
               value="{{ ($product->is_variation || !$product->defaultVariation->product_id) ? $product->id : $product->defaultVariation->product_id }}"/> -->
               <input type="hidden"
               name="id" class="hidden-product-id"
               value="{{ $product->id }}"/> 

        <header class="header--product js-product-content">
            <nav class="navigation">
                <div class="container">
                    <article class="ps-product--header-sticky">
                        <div class="ps-product__thumbnail">
                            <img src="{{ RvMedia::getImageUrl($product->image, 'small', false, RvMedia::getDefaultImage()) }}" alt="{{ $product->name }}">
                        </div>
                        <div class="ps-product__wrapper">
                            <div class="ps-product__content"><a class="ps-product__title" href="{{ $product->url }}">{{ $product->name }}</a>
                                <ul>
                                    <li class="active"><a href="#product-description-tab">{{ __('Description') }}</a></li>
                                    @if (EcommerceHelper::isReviewEnabled())
                                        <li><a href="#product-reviews-tab">{{ __('Reviews') }} ({{ $product->reviews_count }})</a></li>
                                    @endif
                                </ul>
                            </div>
                            <div class="ps-product__shopping">
                                {!! Theme::partial('ecommerce.product-price', compact('product')) !!}
                                @if (EcommerceHelper::isCartEnabled())
                                    <button type="submit" class="btn btn-primary ms-2 add-to-cart-button @if ($product->isOutOfStock()) disabled @endif" @if ($product->isOutOfStock()) disabled @endif title="{{ __('Add to cart') }}">
                                        <span class="svg-icon">
                                            <svg>
                                                <use href="#svg-icon-cart" xlink:href="#svg-icon-cart"></use>
                                            </svg>
                                        </span>
                                        <span class="add-to-cart-text ms-1">{{ __('Add to cart') }}</span>
                                    </button>
                                    @if (EcommerceHelper::isQuickBuyButtonEnabled())
                                        <!-- <button type="submit" name="checkout" class="btn btn-primary btn-black ms-2 add-to-cart-button @if ($product->isOutOfStock()) disabled @endif" @if ($product->isOutOfStock()) disabled @endif title="{{ __('Buy Now') }}">
                                            <span class="add-to-cart-text">{{ __('Buy Now') }}</span>
                                        </button> -->
                                    @endif
                                @endif
                            </div>
                        </div>
                    </article>
                </div>
            </nav>
        </header>

        <div class="sticky-atc-wrap sticky-atc-shown" >
            <div class="container">
                <div class="row">
                    <div class="sticky-atc-btn product-button">
                        {!! Theme::partial('ecommerce.product-quantity', compact('product')) !!}

                        @if (EcommerceHelper::isCartEnabled())
                            <button type="submit" class="btn btn-primary mb-2 add-to-cart-button @if ($product->isOutOfStock()) disabled @endif" @if ($product->isOutOfStock()) disabled @endif title="{{ __('Add to cart') }}">
                                <span class="svg-icon">
                                    <svg>
                                        <use href="#svg-icon-cart" xlink:href="#svg-icon-cart"></use>
                                    </svg>
                                </span>
                                <span class="add-to-cart-text ms-1">{{ __('Add to cart') }}</span>
                            </button>
                            @if (EcommerceHelper::isQuickBuyButtonEnabled())
                                <!-- <button type="submit" name="checkout" class="btn btn-primary btn-black mb-2 ms-2 add-to-cart-button @if ($product->isOutOfStock()) disabled @endif" @if ($product->isOutOfStock()) disabled @endif title="{{ __('Buy Now') }}">
                                    <span class="add-to-cart-text ms-2">{{ __('Buy Now') }}</span>
                                </button> --> 
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- end add-to-cart sticky bar -->

<style>
small.star-count.ms-1.text-secondary.d-inline-block {
    color: green !important;
    font-weight: bold;
}
/* Start Modal Custom Code */

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 15; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  /* left: 0; */
  /* top: 0; */
  padding:10rem;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  position: relative;
  background-color: #fefefe;
  margin: auto;
  padding: 0;
  border: 1px solid #888;
  width: 80%;
  box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
  -webkit-animation-name: animatetop;
  -webkit-animation-duration: 0.4s;
  animation-name: animatetop;
  animation-duration: 0.4s
}

/* Add Animation */
@-webkit-keyframes animatetop {
  from {top:-300px; opacity:0} 
  to {top:0; opacity:1}
}

@keyframes animatetop {
  from {top:-300px; opacity:0}
  to {top:0; opacity:1}
}

/* The Close Button */
.close {
  color: white;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}

.modal-header {
  padding: 2px 16px;
  background-color: #bec0cc;
  color: white;
}

.modal-body {padding: 2px 16px;}

.modal-footer {
  padding: 2px 16px;
  background-color: #bec0cc;
  color: white;
}
@media only screen and (max-width: 768px) {
.modal-responsive{
    /* width: unset !important; */
    padding:unset !important;
}
.product-gallery .product-gallery__variants .slick-arrow {
    transform: none;
}
.product-gallery .product-gallery__variants .slick-arrow.slick-prev-arrow {
    top: 14px !important;
    left: 0 !important;
}
}
@media only screen and (max-width: 768px) {
.product_custom_css{
    width: unset !important;
    margin: unset !important;
    float: unset !important;
}
.mobile_css_bottom_custom_button{
    display: flex;
    justify-content: space-between;
}
.mobile_css_bottom_custom_button a br{
    display: none;
}
.mobile_css_bottom_custom_button a{
    width: 30%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}
.mobile_css_bottom_custom_button a label.text-title-field{
    font-size: 15px !important;
    line-height: 16px !important;
    padding-top: 3px;
}
.product-detail-container .product-detail-tabs .nav{
    display: block;
}

}
.slick-arrow{
    z-index:10 !important;
}
/* End Modal Custom Code */
@media only screen and (min-width: 768px) { .modal-content { max-width: 40rem; } }
@media (max-width: 1024px) { .sticky-atc-wrap{bottom:60px!important; }}
#lg-download{ display:none; }
</style>