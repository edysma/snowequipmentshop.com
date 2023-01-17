@php Theme::layout('full-width'); @endphp

{!! Theme::partial('page-header') !!}

<div class="container-xxxl">
    <div class="row mt-5">
        <div class="col-xl-3 col-lg-4">
            <aside class="catalog-primary-sidebar catalog-sidebar" data-toggle-target="product-categories-primary-sidebar">
                <div class="backdrop"></div>
                <div class="catalog-sidebar--inner side-left">
                    <div class="panel__header d-lg-none mb-4">
                        <span class="panel__header-title">{{ __('Filter Products') }}</span>
                        <a class="close-toggle--sidebar" href="#" data-toggle-closest=".catalog-primary-sidebar">
                            <span class="svg-icon">
                                <svg>
                                    <use href="#svg-icon-arrow-right" xlink:href="#svg-icon-arrow-right"></use>
                                </svg>
                            </span>
                        </a>
                    </div>
                    @php
                        $categories = ProductCategoryHelper::getAllProductCategories()
                                            ->where('status', \Botble\Base\Enums\BaseStatusEnum::PUBLISHED)
                                            ->whereIn('parent_id', [0, null])
                                            ->loadMissing(['slugable', 'activeChildren:id,name,parent_id', 'activeChildren.slugable']);
                        $categoriesRequest = (array)request()->input('categories', []);
                        $urlCurrent = URL::current();
                    @endphp
                    <div class="catalog-filter-sidebar-content px-3 px-md-0">
                        <form action="{{ URL::current() }}"
                            data-action="{{ $store->url }}"
                            method="GET"
                            id="products-filter-form">
                            <input type="hidden" name="sort-by" class="product-filter-item" value="{{ request()->input('sort-by') }}">
                            <input type="hidden" name="layout" class="product-filter-item" value="{{ request()->input('layout') }}">
                            <div class="widget-wrapper widget-product-categories">
                                <h4 class="widget-title">{{ __('All Categories') }}</h4>
                                <input type="hidden" name="categories[]" value="{{ Arr::get($categoriesRequest, 0, '') }}" class="product-filter-item">
                                <div class="widget-layered-nav-list">
                                    @include(Theme::getThemeNamespace() . '::views.ecommerce.includes.categories', compact('categories', 'categoriesRequest', 'urlCurrent'))
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </aside>
            <aside class="catalog-primary-sidebar catalog-sidebar" data-toggle-target="contact-store-primary-sidebar">
                <div class="backdrop"></div>
                <div class="catalog-sidebar--inner side-left">
                    <div class="panel__header d-lg-none mb-4">
                        <span class="panel__header-title">{{ __('Contact Vendor') }}</span>
                        <a class="close-toggle--sidebar" href="#" data-toggle-closest=".catalog-primary-sidebar">
                            <span class="svg-icon">
                                <svg>
                                    <use href="#svg-icon-arrow-right" xlink:href="#svg-icon-arrow-right"></use>
                                </svg>
                            </span>
                        </a>
                    </div>
 
                    <div class="catalog-filter-sidebar-content px-3 px-md-0">
                        <div class="widget-wrapper widget-contact-store">
                            <h4 class="widget-title">{{ __('Contact Vendor') }}</h4>
            
                          <!-- side contact -->
                          <div class="form">
   
    <form class="mt-5 contact-form" action="{{ route('public.send.contact') }}" method="POST" role="form">
        @csrf

        {!! apply_filters('pre_contact_form', null) !!}

        <div class="row">
            <div class="col-md-12">
                <div class="mb-3">
                    <label class="d-none sr-only" for="contact-name">{{ __('Name') }}</label>
                    <input class="form-control py-3 px-3" type="text" id="contact-name" name="name" value="{{ old('name') }}" placeholder="{{ __('Your Name *') }}">
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3">
                    <label class="d-none sr-only" for="contact-email">{{ __('Email') }}</label>
                    <input class="form-control py-3 px-3" type="email" id="contact-email" name="email"  value="{{ old('email') }}" placeholder="{{ __('Your Email *') }}">
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3">
                    <label class="d-none sr-only" for="contact-phone">{{ __('Phone') }}</label>
                    <input class="form-control py-3 px-3" type="text" id="contact-phone" name="phone"  value="{{ old('phone') }}" placeholder="{{ __('Your Phone') }}">
                </div>
            </div>
            <div class="col-12">
                <div class="mb-3">
                    <label class="d-none sr-only" for="contact-subject">{{ __('Subject') }}</label>
                    <input class="form-control py-3 px-3" type="text" id="contact-subject" name="subject" value="{{ old('subject') }}" placeholder="{{ __('Subject (optional)') }}">
                </div>
            </div>
            <div class="col-12">
                <div class="mb-3">
                    <label class="d-none sr-only" for="contact-message">{{ __('Message') }}</label>
                    <textarea class="form-control py-3 px-3" id="contact-message" name="content" cols="40" rows="10" placeholder="{{ __('Write your message here') }}">{{ old('content') }}</textarea>
                </div>
            </div>

            <div class="col-12">
                <div class="mb-3">
                    <input class=" py-3 px-3" type="checkbox"  name="privacyPolicy" value="1" required>
                    <label class=" " for="checkbox">{{ __('By accepting this you agree to') }} <a href="/it/privacy">{{ __('Privacy and Policy*') }}</a></label>
                </div>
            </div>

            @if (is_plugin_active('captcha'))
                @if (setting('enable_captcha'))
                    <div class="col-12">
                        <div class="mb-3">
                            {!! Captcha::display() !!}
                        </div>
                    </div>
                @endif

                @if (setting('enable_math_captcha_for_contact_form', 0))
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="math-group">{{ app('math-captcha')->label() }}</label>
                            {!! app('math-captcha')->input(['class' => 'form-control', 'id' => 'math-group', 'placeholder' => app('math-captcha')->getMathLabelOnly() . ' = ?']) !!}
                        </div>
                    </div>
                @endif
            @endif

            {!! apply_filters('after_contact_form', null) !!}

            <div class="col-12">
                <div class="mt-4">
                    <button class="btn btn-primary" type="submit">{{ __('Send Message') }}</button>
                </div>
            </div>
            <div class="col-12">
                <div class="contact-form-group mt-4">
                    <div class="contact-message contact-success-message" style="display: none"></div>
                    <div class="contact-message contact-error-message" style="display: none"></div>
                </div>
            </div>
        </div>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.6.1.slim.min.js"></script>
<script>
    let form_fields = $('.panel-content .form');
    let fields = $('.panel-content .col-md-4');
    

    form_fields.removeClass('ms-md-5');
    form_fields.removeClass('ps-md-5');

    fields.toggleClass("col-md-4");


</script>
                          <!-- side contact -->
                        </div>
                    </div>
                </div>
            </aside>
        </div>
        <div class="col-xl-9 col-lg-8">
            @include(Theme::getThemeNamespace() . '::views.marketplace.includes.info-box', ['showContactVendor' => true])
            <div class="row justify-content-center my-5 mb-2">
                <div class="col-12">
                    <div class="form-group">
                        <form action="{{ URL::current() }}" method="GET" class="products-filter-form-vendor">
                            <div class="input-group">
                                <input type="text" class="form-control" name="q" value="{{ request()->input('q') }}" form="products-filter-form" placeholder="{{ __('Search in this store...') }}">
                                <button type="submit" class="btn btn-primary px-3 justify-content-center">
                                    <span class="svg-icon me-2 d-block text-center w-100">
                                        <svg>
                                            <use href="#svg-icon-search" xlink:href="#svg-icon-search"></use>
                                        </svg>
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="bg-light p-2 my-3">
                <div class="row catalog-header justify-content-between">
                    <div class="col-auto catalog-header__left d-flex align-items-center">
                        <h2 class="h6 catalog-header__title d-none d-lg-block mb-0 ps-2">
                            <span class="products-found">
                                <span class="text-primary me-1">{{ $products->total() }}</span>{{ __('Products found') }}
                            </span>
                        </h2>
                        <a class="d-lg-none sidebar-filter-mobile" href="#" data-toggle="product-categories-primary-sidebar">
                            <span class="svg-icon me-2">
                                <svg>
                                    <use href="#svg-icon-filter" xlink:href="#svg-icon-filter"></use>
                                </svg>
                            </span>
                            <span>{{ __('Filter') }}</span>
                        </a>
                    </div>
                    <div class="col-auto catalog-header__right">
                        <div class="catalog-toolbar row align-items-center">
                            @include(Theme::getThemeNamespace() . '::views.ecommerce.includes.layout')
                        </div>
                    </div>
                </div>
            </div>
            <div class="products-listing position-relative">
                @include(Theme::getThemeNamespace('views.marketplace.stores.items'))
            </div>
        </div>
    </div>
</div>
