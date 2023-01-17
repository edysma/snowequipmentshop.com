
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=5, user-scalable=1" name="viewport"/>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family={{ urlencode(theme_option('primary_font', 'Muli')) }}:wght@400;600;700&display=swap" rel="stylesheet">

        <style>
            :root {
                --primary-font: '{{ theme_option('primary_font', 'Muli') }}', sans-serif;
                --primary-color: {{ theme_option('primary_color', '#fab528') }};
                --heading-color: {{ theme_option('heading_color', '#000') }};
                --text-color: {{ theme_option('text_color', '#000') }};
                --primary-button-color: {{ theme_option('primary_button_color', '#000') }};
                --top-header-background-color: {{ theme_option('top_header_background_color', '#f7f7f7') }};
                --middle-header-background-color: {{ theme_option('middle_header_background_color', '#fff') }};
                --bottom-header-background-color: {{ theme_option('bottom_header_background_color', '#fff') }};
                --header-text-color: {{ theme_option('header_text_color', '#000') }};
                --header-text-secondary-color: {{ BaseHelper::hexToRgba(theme_option('header_text_color', '#000'), 0.5) }};
                --header-deliver-color: {{ BaseHelper::hexToRgba(theme_option('header_deliver_color', '#000'), 0.15) }};
                --footer-text-color: {{ theme_option('footer_text_color', '#555') }};
                --footer-heading-color: {{ theme_option('footer_heading_color', '#555') }};
                --footer-hover-color: {{ theme_option('footer_hover_color', '#fab528') }};
                --footer-border-color: {{ theme_option('footer_border_color', '#dee2e6') }};
            }
        </style>

        @php
            Theme::asset()->remove('language-css');
            Theme::asset()->container('footer')->remove('language-public-js');
            Theme::asset()->container('footer')->remove('simple-slider-owl-carousel-css');
            Theme::asset()->container('footer')->remove('simple-slider-owl-carousel-js');
            Theme::asset()->container('footer')->remove('simple-slider-css');
            Theme::asset()->container('footer')->remove('simple-slider-js');
        @endphp

        {!! Theme::header() !!}
    </head>
    <body @if (BaseHelper::siteLanguageDirection() == 'rtl') dir="rtl" @endif @if (Theme::get('bodyClass')) class="{{ Theme::get('bodyClass') }}" @endif>
        @if (theme_option('preloader_enabled', 'yes') == 'yes')
            {!! Theme::partial('preloader') !!}
        @endif

        {!! Theme::partial('svg-icons') !!}
        {!! apply_filters(THEME_FRONT_BODY, null) !!}

        <header class="header header-js-handler" data-sticky="{{ theme_option('sticky_header_enabled', 'yes') == 'yes' ? 'true' : 'false' }}">
            <div class="header-top d-none d-lg-block" style="
                    padding-top: 10px;
                ">
                <div class="container-xxxl">
                    <div class="row align-items-center" style="padding-top: 15px; padding-bottom: 15px; background: #000000b5; margin-bottom:10px; display:none">
                        <div class="col-6">
                            <div class="header-info" style="color:#fff">
                                Choose the country or territory you are in to see local content and buy
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="header-info header-info-right" style="margin-right: 100px;">
                              
                            </div>
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-6">
                            <div class="header-info">
                                {!! Menu::renderMenuLocation('header-navigation', ['view' => 'menu-default']) !!}
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="header-info header-info-right">
                            <ul style="margin-right:15px;">
<span></span>
                                  
                                  <?php
									$ip = $_SERVER['REMOTE_ADDR'];
									$countryName = 'Italia';

                                      use Illuminate\Support\Facades\DB;
                                      try {
                
                                        if (count(\Botble\Location\Models\Country::all()) > 0) {
                                            $recommendedCountryCode = '';
                                            if (!session('country')) {
                                                $curl = curl_init();
                            
                                                curl_setopt_array($curl, array(
                                                    CURLOPT_URL => 'https://ipwhois.app/json/'.$ip,//'https://ipinfo.io/',
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
														$recommendedCountryCode = 'IT';
														session(['country' => 112]);
														session(['countryCode' => 'IT']);
													} else {
														// dd($response);
														if (isset($response['country'])) {
															$recommendedCountryCode = $response['country_code'];
														}

														foreach (\Botble\Location\Models\Country::all() as $country) {
															if (strtolower($country->code) == strtolower($recommendedCountryCode)) {
																session(['country' => $country->id]);
																session(['countryCode' => $country->code]);
															}
														}
													}
													
													
                                                    
                                                } else {
													session(['country' => 112]);
                                                            session(['countryCode' => 'IT']);
												}
                                            }
                                            
                                            $result =  DB::table('countries_translations')->where('lang_code', 'like', '%' . strtolower(session()->all()['countryCode']) . '_%')->where('countries_id', session(['country']))->first();
                                            if ($result) {    
                                                $countryName = $result->name;
                                            } else {
                                                $result =  DB::table('countries_translations')->where('lang_code', 'like', '%' . strtolower(session()->all()['countryCode']) . '_%')->where('countries_id', session(['country']))->first();    
                                                if ($result) {
                                                } else {
                                                    $countryName = get_application_country()->name;
                                                }
                                            }
                                        }
                                    } catch (Exception $exception) {
                                        
                                    }  

                                      ?>
                                      <li>
                                         <div style="margin-right:10px">{{ __('Your country is') }}</div> 
                                         <a class="language-dropdown-active" href="/choose-country-region">
                                          <img src="/public/Globe_icon_2.svg.png" title="English" width="16" alt="English">
                                              <span>{{ $countryName }}</span>
                                              <?php $_SESSION['countryName'] = $countryName; ?>
                                              <span class="svg-icon" >
                                                  <svg>
                                                      <use href="#svg-icon-chevron-down" xlink:href="#svg-icon-chevron-down"></use>
                                                  </svg>
                                              </span>
                                          </a>
                                          <ul class="language-dropdown" style="
                                                  background: #000;
                                                  margin: 0px;
                                                  border: 0px;
                                              ">
                                              <li>
                                                  <a href="/choose-country-region" >
                                                      <span style="color:#fff" >{{ __('Other Countries or territory') }}</span>
                                                  </a>
                                              </li>
                                              
                                          </ul>
                                      </li>
                                  <?php ?>
                             
                          </ul>
                                <ul>
                                    @if (is_plugin_active('language'))
                                        {!! Theme::partial('language-switcher') !!}
                                    @endif
                                       
                                    @if (is_plugin_active('ecommerce'))
                                        @if (count($currencies) > 1)
                                            <li>
                                                <a class="language-dropdown-active" href="#">
                                                    <span>{{ get_application_currency()->title }}</span>
                                                    <span class="svg-icon">
                                                        <svg>
                                                            <use href="#svg-icon-chevron-down" xlink:href="#svg-icon-chevron-down"></use>
                                                        </svg>
                                                    </span>
                                                </a>
                                                <ul class="language-dropdown">
                                                    @foreach ($currencies as $currency)
                                                    
                                                        @if ($currency->id !== get_application_currency_id())
                                                            <li>
                                                                <a href="{{ route('public.change-currency', $currency->title) }}">
                                                                    <span>{{ $currency->title }}</span>
                                                                </a>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @endif
                                        @if (auth('customer')->check())
                                            <li>
                                                <a href="{{ route('customer.overview') }}">{{ auth('customer')->user()->name }}</a> <span class="d-inline-block ms-1">(<a href="/en/customer/logout" class="color-primary">{{ __('Logout') }}</a>)</span>
                                            </li>
                                        @else
                                            <li><a href="{{ route('customer.login') }}">{{ __('Login') }}</a></li>
                                            <li><a href="{{ route('customer.register') }}">{{ __('Register') }}</a></li>
                                        @endif
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-middle">
                <div class="container-xxxl">
                    <div class="header-wrapper">
                        <div class="header-items header__left">
                            @if (theme_option('logo'))
                                <div class="logo">
                                    <a href="{{ route('public.index') }}">
                                        <img src="{{ RvMedia::getImageUrl(theme_option('logo')) }}" alt="{{ theme_option('site_title') }}" />
                                    </a>
                                </div>
                            @endif
                        </div>
                        <div class="header-items header__center">
                            @if (is_plugin_active('ecommerce'))
                                <form class="form--quick-search" action="{{ route('public.products') }}" data-ajax-url="{{ route('public.ajax.search-products') }}" method="get">
                                    <div class="form-group--icon" style="display: none">
                                        <div class="product-category-label">
                                            <span class="text">{{ __('All Categories') }}</span>
                                            <span class="svg-icon">
                                                <svg>
                                                    <use href="#svg-icon-chevron-down" xlink:href="#svg-icon-chevron-down"></use>
                                                </svg>
                                            </span>
                                        </div>
                                        <select class="form-control product-category-select" name="categories[]">
                                            <option value="0">{{ __('All Categories') }}</option>
                                            {!! Theme::partial('product-categories-select', ['categories' => $categories, 'indent' => null]) !!}
                                        </select>
                                    </div>
                                    <input class="form-control input-search-product" name="q" type="text"
                                        placeholder="{{ __("I'm shopping for...") }}" autocomplete="off">
                                    <button class="btn" type="submit">
                                        <span class="svg-icon">
                                            <svg>
                                                <use href="#svg-icon-search" xlink:href="#svg-icon-search"></use>
                                            </svg>
                                        </span>
                                    </button>
                                    <div class="panel--search-result"></div>
                                </form>
                            @endif
                        </div>
                        <div class="header-items header__right">
                            @if (theme_option('hotline'))
                                <div class="header__extra header-support">
                                    <div class="header-box-content">
                                        <span><a href="tel:{{ theme_option('hotline') }}">{{ theme_option('hotline') }}</a></span>
                                        <p>{{ __('Support 24/7') }}</p>
                                    </div>
                                </div>
                            @endif

                            @if (is_plugin_active('ecommerce'))
                                @if (EcommerceHelper::isCompareEnabled())
                                    <div class="header__extra header-compare">
                                        <a class="btn-compare" href="{{ route('public.compare') }}">
                                            <i class="icon-repeat"></i>
                                            <span class="header-item-counter">{{ Cart::instance('compare')->count() }}</span>
                                        </a>
                                    </div>
                                @endif
                                @if (EcommerceHelper::isWishlistEnabled())
                                    <div class="header__extra header-wishlist">
                                        <a class="btn-wishlist" href="{{ route('public.wishlist') }}">
                                            <span class="svg-icon">
                                                <svg>
                                                    <use href="#svg-icon-wishlist" xlink:href="#svg-icon-wishlist"></use>
                                                </svg>
                                            </span>
                                            <span class="header-item-counter">
                                                {{ auth('customer')->check() ? auth('customer')->user()->wishlist()->count() : Cart::instance('wishlist')->count() }}
                                            </span>
                                        </a>
                                    </div>
                                @endif
                                @if (EcommerceHelper::isCartEnabled())
                                    <div class="header__extra cart--mini" tabindex="0" role="button">
                                        <div class="header__extra">
                                            <a class="btn-shopping-cart" href="{{ route('public.cart') }}">
                                                <span class="svg-icon">
                                                    <svg>
                                                        <use href="#svg-icon-cart" xlink:href="#svg-icon-cart"></use>
                                                    </svg>
                                                </span>
                                                <span class="header-item-counter">{{ Cart::instance('cart')->count() }}</span>
                                            </a>
                                            <span class="cart-text">
                                                <span class="cart-title">{{ __('Your Cart') }}</span>
                                                <span class="cart-price-total">
                                                    <span class="cart-amount">
                                                        <bdi>
                                                            <span>{{ format_price(Cart::instance('cart')->rawSubTotal() + Cart::instance('cart')->rawTax()) }}</span>
                                                        </bdi>
                                                    </span>
                                                </span>
                                            </span>
                                        </div>
                                        <div class="cart__content" id="cart-mobile">
                                            <div class="backdrop"></div>
                                            <div class="mini-cart-content">
                                                <div class="widget-shopping-cart-content">
                                                    {!! Theme::partial('cart-mini.list') !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-bottom">
                <div class="header-wrapper">
                    <nav class="navigation">
                        <div class="container-xxxl">
                            <div class="navigation__left">
                                @if (is_plugin_active('ecommerce'))
                                    <div class="menu--product-categories">
                                        <div class="menu__toggle">
                                            <span class="svg-icon">
                                                <svg>
                                                    <use href="#svg-icon-list" xlink:href="#svg-icon-list"></use>
                                                </svg>
                                            </span>
                                            <span class="menu__toggle-title">{{ __('Shop by Category') }}</span>
                                        </div>
                                        <div class="menu__content">
                                            <ul class="menu--dropdown">
                                                {!! Theme::partial('product-categories-dropdown', compact('categories')) !!}
                                            </ul>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="navigation__center">
                                {!! Menu::renderMenuLocation('main-menu', [
                                    'view'    => 'menu',
                                    'options' => ['class' => 'menu'],
                                ]) !!}
                            </div>
                            <div class="navigation__right">
                                @if (is_plugin_active('ecommerce') && EcommerceHelper::isEnabledCustomerRecentlyViewedProducts())
                                    <div class="header-recently-viewed stick_recent_view" data-url="{{ route('public.ajax.recently-viewed-products') }}" role="button">
                                        <h3 class="recently-title">
                                            <span class="svg-icon recent-icon">
                                                <svg>
                                                    <use href="#svg-icon-refresh" xlink:href="#svg-icon-refresh"></use>
                                                </svg>
                                            </span>
                                            {{ __('Recently Viewed') }}
                                        </h3>
                                        <div class="recently-viewed-inner container-xxxl">
                                            <div class="recently-viewed-content">
                                                <div class="loading--wrapper">
                                                    <div class="loading"></div>
                                                </div>
                                                <div class="recently-viewed-products"></div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                @endif
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
            <!-- start static header -->
            <div  class="header-mobile header-js-handler p-0 m-0 first_sticky" style=" text-transform: uppercase; padding-top: 10px;"  data-sticky="{{ theme_option('sticky_header_mobile_enabled', 'no') == 'yes' ? 'true' : 'false' }}">                
                    <div class="custom_head col-12 row m-0" style="background-color:#919ea6;padding: unset !important; "> 
                      <div class="col-9" style="background-color:#919ea6;padding: 5px 0px;">
                        <div class="" style="text-transform: uppercase; margin-top:2.5px; background-color:#919ea6; display: flex;justify-content: center; ">
                            <div class="uk-grid-medium uk-child-width-auto uk-flex-middle uk-grid" uk-grid="margin: uk-margin-small-top">
                                <div class="uk-first-column">
                                    <div class="uk-panel" id="module-262">    
                                        <div class="uk-margin-remove-last-child custom">
                                            <p class="svg-customization"><strong><span uk-icon="icon: mail" class="uk-icon">
                                                <svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <polyline fill="none" stroke="#000" points="1.4,6.5 10,11 18.6,6.5"></polyline>
                                                    <path d="M 1,4 1,16 19,16 19,4 1,4 Z M 18,15 2,15 2,5 18,5 18,15 Z"></path>
                                                </svg></span>&nbsp;<a href="/contact" style="font-size:14px;">CONTACT&nbsp;</a>
                                                    </strong>&nbsp;<strong><span uk-icon="icon: receiver" class="uk-icon">
                                                    <svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill="none" stroke="#fff" stroke-width="1.01" d="M6.189,13.611C8.134,15.525 11.097,18.239 13.867,18.257C16.47,18.275 18.2,16.241 18.2,16.241L14.509,12.551L11.539,13.639L6.189,8.29L7.313,5.355L3.76,1.8C3.76,1.8 1.732,3.537 1.7,6.092C1.667,8.809 4.347,11.738 6.189,13.611"></path></svg>
                                                </span>&nbsp;<a href="tel:+39059931483" onclick="gtag('event', 'Click To Call', {event_category: 'Contact', event_label: 'Phone'});" style="font-size:14px;margin-top:2px">+39 059.931483</a></strong>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                        
                    <div class="col-3" style="background-color:#919ea6;padding: 5px 0px;">
                        <div class="" style="text-transform: uppercase; display: flex;justify-content: space-evenly;align-items: center;">
                        <a href="https://www.facebook.com/snowservicesrl/">   
                        <img src="/public/facebook.png" class="img-custom-design" style="height:18px;" alt="" title="" class="img-small">
                                </a>  
                        <a href="https://it.linkedin.com/company/snow-service-srl">   

                        <img src="/public/linkedin.png" class="img-custom-design" style="height:18px;" alt="" title="" class="img-small">
                                </a>
                        <a href="https://www.youtube.com/user/SNOWSERVICESRL">   

                            <img src="/public/youtube.png" class="img-custom-design" style="height:18px;" alt="" title="" class="img-small" style="">
                                </a>
                        </div>
                    </div>
                                </div>
            </div>
            <!-- end custom mobile menu -->

            <!-- End static header -->
            <div class="header-mobile header-js-handler second_sticky" data-sticky="{{ theme_option('sticky_header_mobile_enabled', 'yes') == 'yes' ? 'true' : 'false' }}">
                <div class="header-items-mobile header-items-mobile--left">
                    <div class="menu-mobile">
                        <div class="menu-box-title">
                            <div class="icon menu-icon toggle--sidebar" href="#menu-mobile">
                                <span class="svg-icon">
                                    <svg>
                                        <use href="#svg-icon-list" xlink:href="#svg-icon-list"></use>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="header-items-mobile header-items-mobile--center">
                    @if (theme_option('logo'))
                        <div class="logo">
                            <a href="{{ route('public.index') }}">
                                <img src="{{ RvMedia::getImageUrl(theme_option('logo')) }}" alt="{{ theme_option('site_title') }}" width="155" />
                            </a>
                        </div>
                    @endif
                </div>
                <div class="header-items-mobile header-items-mobile--right">
                    <div class="search-form--mobile search-form--mobile-right search-panel">
                        <a class="open-search-panel toggle--sidebar" href="#search-mobile">
                            <span class="svg-icon">
                                <svg>
                                    <use href="#svg-icon-search" xlink:href="#svg-icon-search"></use>
                                </svg>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </header>