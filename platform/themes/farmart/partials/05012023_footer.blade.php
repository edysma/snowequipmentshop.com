<footer id="footer">
        <div class="footer-info border-top">
            <div class="container-xxxl py-3">
                {!! dynamic_sidebar('pre_footer_sidebar') !!}
            </div>
        </div>
        @if (Widget::group('footer_sidebar')->getWidgets())
            <div class="footer-widgets">
                <div class="container-xxxl">
                    <div class="row border-top py-5">
                        {!! dynamic_sidebar('footer_sidebar') !!}
                    </div>
                </div>
            </div>
        @endif


        <!-- @if (Widget::group('bottom_footer_sidebar')->getWidgets())
            <div class="container-xxxl"> -->
                <!-- <div class="footer__links custom-cookie-set" id="footer-links">
                    {!! dynamic_sidebar('bottom_footer_sidebar') !!}
                </div> -->
                <!-- <div id="footer-links" class="footer__links custom-cookie-set">
                    <div class="panel panel-default"><div class="panel-title"><h3></h3></div> 
                    <div class="panel-content"><p></p><p style="text-align: center;"><a href="javascript:void(0)" id="open_preferences_center" class="d-block">Update cookies preferences</a></p><p></p></div></div> <div class="panel panel-default"><div class="panel-title"><h3></h3></div> <div class="panel-content"><p></p><p style="font-size: 12px; color: rgb(89, 89, 89); text-align: center;">Tutti i diritti riservati - sito realizzato da <a href="http://edysma.com/dachi.php?mit=snowequipmentshop">edysma</a> in conformità agli standard di accessibilità ed al Responsive Web Design (RWD)</p><p></p></div></div></div>
            </div>
        @endif         -->


        <div class="container-xxxl">
            <div class="row custom-responsive-footer align-items-center">
                <!-- start default code -->
                <!-- <div class="col-lg-3 col-md-4 py-3">
                    <div class="copyright d-flex justify-content-center justify-content-md-start">
                        <span>{{ theme_option('copyright') }}</span>
                    </div>
                </div> -->
                <!-- end default code -->
                <!-- start customization -->
                <div class="col-md-4 col-lg-4 col-sm-12 custom-responsive-footer-one d-none">[simple-slider key="home-slider" ads="VC2C8Q1UGCBG" background="general/slider-bg.jpg"][/simple-slider]</div>
                @if (theme_option('logo'))
                 <div class="custom-footer-logo-design">
                    <a href="{{ route('public.index') }}">
                      <img src="{{ RvMedia::getImageUrl(theme_option('logo')) }}" alt="{{ theme_option('site_title') }}" />
                    </a>
                </div>
                @endif
                <!-- end customization -->

                <!-- start customizationstyle="width:28%;margin:0 auto;" -->
                    <div class="col-md-4 col-lg-4 col-sm-12 uk-width-1-3@m custom-responsive-footer-two" >
                        <div class="uk-panel uk-text-center">
                            @if (Widget::group('bottom_footer_sidebar')->getWidgets())
                                <div class="container-xxxl">
                                    <!-- <div class="footer__links custom-cookie-set" id="footer-links">
                                        {!! dynamic_sidebar('bottom_footer_sidebar') !!}
                                    </div> -->
                                    <div id="footer-links" class="footer__links custom-cookie-set">
                                        <div class="panel panel-default"><div class="panel-title"><h3></h3></div> 
                                        <div class="panel-content"><p></p>
                                        <p></p></div></div> <div class="panel panel-default"><div class="panel-title"><h3></h3></div> <div class="panel-content"><p></p><p style="font-size: 12px; color: rgb(89, 89, 89); text-align: center;">Tutti i diritti riservati - sito realizzato da <a href="http://edysma.com/dachi.php?mit=snowequipmentshop">edysma</a> in conformità agli standard di accessibilità ed al Responsive Web Design (RWD)</p><p></p></div></div></div>
                                </div>
                            @endif
                            <!-- <ul class="uk-nav uk-nav-default custom-footer-css">
                            <h3 class="el-title uk-heading-small">Social Links</h3>    
                                <li><a href="https://www.facebook.com/snowservicesrl/">Facbook</a></li>
                                <li><a href="https://it.linkedin.com/company/snow-service-srl?trk=public_profile_position_image">linkedin</a></li>
                                <li><a href="https://www.youtube.com/user/SNOWSERVICESRL">Youtube</a></li> -->
                                <!-- <li><span style="font-size:14px !important;">{{ theme_option('copyright') }}</span></li> -->
                            <!-- <h3 class="el-title uk-heading-small">Informazioni Legali</h3>    
                                <li><a href="/note-legali">Note legali</a></li>
                                <li><a href="/privacy">Privacy</a></li>
                                <li><a href="/condizioni-duso">Condizioni d'uso</a></li>
                                <li><a href="/cookies">Cookies</a></li>-->
                                <!-- <li><a href="javascript:void(0)" id="open_preferences_center" class="cc-show d-block">Update cookies Preferenze</a></li> -->
                                <!--<li><a href="javascript:void(0)">Site Map</a></li> -->
                            <!-- </ul> -->
                        </div>
                        
                    </div>
                    <!-- cookie -->
                    <div class="termsfeed-com---reset termsfeed-com---nb termsfeed-com---palette-light termsfeed-com---nb-simple termsfeed-com---lang-it d-none custom-cookie-set " id="termsfeed-com---nb" role="dialog" aria-modal="true" aria-labelledby="cc-nb-title" aria-describedby="cc-nb-text">
                        <div class="cc-nb-main-container">
                            <div class="cc-nb-title-container">
                                <p class="cc-nb-title" id="cc-nb-title">Noi usiamo i cookies</p>
                            </div>
                        <div class="cc-nb-text-container">
                            <p class="cc-nb-text" id="cc-nb-text">Noi usiamo i cookies e altre tecniche di tracciamento per migliorare la tua esperienza di navigazione nel nostro sito, per mostrarti contenuti personalizzati e annunci mirati, per analizzare il traffico sul nostro sito, e per capire da dove arrivano i nostri visitatori.</p>
                    </div>
                        <div class="cc-nb-buttons-container">
                            <button class="cc-nb-okagree" role="button">Accetto</button>
                            <button class="cc-nb-reject" role="button">Rifiuto</button>
                            <button class="cc-nb-changep" role="button">Cambia le mie impostazioni</button>
                        </div>
                    </div>
                </div>
                    <!-- cookie -->
                <!-- end customization -->

                <!-- start default code -->
                <!-- <div class="col-lg-6 col-md-4 py-3">
                    @if (theme_option('payment_methods_image'))
                        <div class="footer-payments d-flex justify-content-center">
                            @if (theme_option('payment_methods_link'))
                                <a href="{{ url(theme_option('payment_methods_link')) }}" target="_blank">
                            @endif

                            <img class="lazyload"
                                data-src="{{ RvMedia::getImageUrl(theme_option('payment_methods_image')) }}" alt="footer-payments">

                            @if (theme_option('payment_methods_link'))
                                </a>
                            @endif
                        </div>
                    @endif
                </div> -->
                <!-- end default code -->
                <div class="col-md-4 col-lg-4 py-3">
                    <!-- start customization -->
                            <div class="copyright d-flex justify-content-center justify-content-md-start">
                                <span>{{ theme_option('copyright') }}</span>
                            </div>
                            
                    <!-- end customization -->
                    
                    <!-- default code -->
                    <!-- <div class="footer-socials d-flex justify-content-md-end justify-content-center">
                        @if (theme_option('social_links'))
                            <p class="me-3 mb-0">{{ __('Stay connected:') }}</p>
                            <div class="footer-socials-container">
                                <ul class="ps-0 mb-0">
                                    @foreach(json_decode(theme_option('social_links'), true) as $socialLink)
                                        @if (count($socialLink) == 3)
                                            <li class="d-inline-block ps-1 my-1">
                                                <a target="_blank" href="{{ Arr::get($socialLink[2], 'value') }}" title="{{ Arr::get($socialLink[0], 'value') }}">
                                                    <img class="lazyload" data-src="{{ RvMedia::getImageUrl(Arr::get($socialLink[1], 'value')) }}"
                                                        alt="{{ Arr::get($socialLink[0], 'value') }}" />
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div> -->
                    <!-- default code -->
                </div>
                            <!-- @if (Widget::group('bottom_footer_sidebar')->getWidgets())
                                <div class="container-xxxl"> -->
                                    <!-- <div class="footer__links custom-cookie-set" id="footer-links">
                                        {!! dynamic_sidebar('bottom_footer_sidebar') !!}
                                    </div> -->
                                    <!-- <div id="footer-links" class="footer__links custom-cookie-set">
                                        <div class="panel panel-default"><div class="panel-title"><h3></h3></div> 
                                        <div class="panel-content"><p></p>
                                        <p></p></div></div> <div class="panel panel-default"><div class="panel-title"><h3></h3></div> <div class="panel-content"><p></p><p style="font-size: 12px; color: rgb(89, 89, 89); text-align: center;">Tutti i diritti riservati - sito realizzato da <a href="http://edysma.com/dachi.php?mit=snowequipmentshop">edysma</a> in conformità agli standard di accessibilità ed al Responsive Web Design (RWD)</p><p></p></div></div></div>
                                </div>
                            @endif -->
            </div>
        </div>
    </footer>
    @if (is_plugin_active('ecommerce'))
        <div class="panel--sidebar" id="navigation-mobile">
            <div class="panel__header">
                <span class="svg-icon close-toggle--sidebar">
                    <svg>
                        <use href="#svg-icon-arrow-left" xlink:href="#svg-icon-arrow-left"></use>
                    </svg>
                </span>
                <h3>{{ __('Categories') }}</h3>
            </div>
            <div class="panel__content">
                <ul class="menu--mobile">
                    {!! Theme::partial('product-categories-dropdown', compact('categories')) !!}
                </ul>
            </div>
        </div>
    @endif
    
    <div class="panel--sidebar" id="menu-mobile">
        <div class="panel__header">
            <span class="svg-icon close-toggle--sidebar">
                <svg>
                    <use href="#svg-icon-arrow-left" xlink:href="#svg-icon-arrow-left"></use>
                </svg>
            </span>
            <div class="header-items header__right ">
                            @if (theme_option('logo'))
                                <div class="logo">
                                    <a href="{{ route('public.index') }}" class="d-flex justify-content-end">
                                        <img src="{{ RvMedia::getImageUrl(theme_option('logo')) }}" width="50%" alt="{{ theme_option('site_title') }}" />
                                    </a>
                                </div>
                            @endif
                        </div>
            <!-- <h3>{{ __('Menu') }}</h3> -->
        </div>
        <div class="panel__content">
            {!! Menu::renderMenuLocation('main-menu', [
                'view'    => 'menu',
                'options' => ['class' => 'menu--mobile'],
            ]) !!}

            {!! Menu::renderMenuLocation('header-navigation', [
                'view'    => 'menu',
                'options' => ['class' => 'menu--mobile'],
            ]) !!}

            <ul class="menu--mobile">

                @if (is_plugin_active('ecommerce'))
                    @if (EcommerceHelper::isCompareEnabled())
                        <li><a href="{{ route('public.compare') }}"><span>{{ __('Compare') }}</span></a></li>
                    @endif

                    @php $currencies = get_all_currencies(); @endphp
                    @if (count($currencies) > 1)
                        <li class="menu-item-has-children">
                            <a href="#">
                                <span>{{ get_application_currency()->title }}</span>
                                <span class="sub-toggle">
                                <span class="svg-icon">
                                    <svg>
                                        <use href="#svg-icon-chevron-down" xlink:href="#svg-icon-chevron-down"></use>
                                    </svg>
                                </span>
                            </span>
                            </a>
                            <ul class="sub-menu">
                                @foreach ($currencies as $currency)
                                    @if ($currency->id !== get_application_currency_id())
                                        <li><a href="{{ route('public.change-currency', $currency->title) }}"><span>{{ $currency->title }}</span></a></li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                    @endif
                @endif
                @if (is_plugin_active('language'))
                        @php
                            $supportedLocales = Language::getSupportedLocales();
                        @endphp

                        @if ($supportedLocales && count($supportedLocales) > 1)
                            @php
                                $languageDisplay = setting('language_display', 'all');
                            @endphp
                            <li class="menu-item-has-children">
                                <a href="#">
                                    @if ($languageDisplay == 'all' || $languageDisplay == 'flag')
                                        {!! language_flag(Language::getCurrentLocaleFlag(), Language::getCurrentLocaleName()) !!}
                                    @endif
                                    @if ($languageDisplay == 'all' || $languageDisplay == 'name')
                                        {{ Language::getCurrentLocaleName() }}
                                    @endif
                                    <span class="sub-toggle">
                                        <span class="svg-icon">
                                            <svg>
                                                <use href="#svg-icon-chevron-down" xlink:href="#svg-icon-chevron-down"></use>
                                            </svg>
                                        </span>
                                    </span>
                                </a>
                                <ul class="sub-menu">
                                    @foreach ($supportedLocales as $localeCode => $properties)
                                        @if ($localeCode != Language::getCurrentLocale())
                                            <li>
                                                <a href="{{ Language::getSwitcherUrl($localeCode, $properties['lang_code']) }}">
                                                    @if ($languageDisplay == 'all' || $languageDisplay == 'flag'){!! language_flag($properties['lang_flag'], $properties['lang_name']) !!}@endif
                                                    @if ($languageDisplay == 'all' || $languageDisplay == 'name')<span>{{ $properties['lang_name'] }}</span>@endif
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                @endif
                @if (is_plugin_active('ecommerce'))
                @if (EcommerceHelper::isWishlistEnabled())
                <li class="wishlist_side_bar">
                                    <!-- <div class="header__extra header-wishlist"> -->
                                        <a class="btn-wishlist" href="{{ route('public.wishlist') }}">
                                            <span>Wishlist</span>
                                            <!-- <span class="svg-icon">
                                                <svg>
                                                    <use href="#svg-icon-wishlist" xlink:href="#svg-icon-wishlist"></use>
                                                </svg>
                                            </span> -->
                                            <!-- <span class="header-item-counter">
                                                {{ auth('customer')->check() ? auth('customer')->user()->wishlist()->count() : Cart::instance('wishlist')->count() }}
                                            </span> -->
                                        </a>
                                    <!-- </div> -->
            </li>
                                @endif
                                @endif
                <?php
$ip = $_SERVER['REMOTE_ADDR'];
                                      use Illuminate\Support\Facades\DB;

                                      if(count( Botble\Location\Models\Country::all()) > 0 ){ 
                                          $recommendedCountryCode = '';
                                          if(!session('country') || !session('countryCode')  ) {
                                              $curl = curl_init();

                                              curl_setopt_array($curl, array(
                                              CURLOPT_URL => "https://ipinfo.io/{$ip}",
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
                                                      if(strtolower($country->code) == strtolower($recommendedCountryCode)) {
                                                          session(['country'=>$country->id]);
                                                          session(['countryCode'=>$country->code]);

                                                      }
                                                  }

                                                  // dd(session('country'));
                                              }
                                          }
                                          // echo $response;
                                          // dd(session()->all()['countryCode']);

                                          $result =  DB::table('countries_translations')->where('lang_code','like', '%'.strtolower(session()->all()['countryCode']).'_%')->where('countries_id' , session(['country']))->first();
                                          if($result){
                                              
                                                  $countryName = $result->name;
                                          }else{
                                              $result =  DB::table('countries_translations')->where('lang_code','like', '%'.strtolower(session()->all()['countryCode']).'_%')->where('countries_id' , session(['country']))->first();

                                              if($result){

                                              }else{
                                               
                                                    $countryName = get_application_country()->name;

//                                                }

                                              }


                                          }
                                          // dd(strtolower(session()->all()['countryCode']));

                                      ?>
                <li>
                    <a href="https://<?=$_SERVER['HTTP_HOST']."/choose-country-region"?>">
                        <img src="/public/Globe_icon_2.svg.png" title="English" width="16" alt="English">
                        <span>{{ $countryName }}</span>
                        
                        
                    </a>
                </li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="panel--sidebar panel--sidebar__right" id="search-mobile">
        <div class="panel__header">
            @if (is_plugin_active('ecommerce'))
            <form class="form--quick-search w-100" action="{{ route('public.products') }}" data-ajax-url="{{ route('public.ajax.search-products') }}" method="get">
                <div class="search-inner-content">
                    <div class="text-search">
                        <div class="search-wrapper">
                            <input class="search-field input-search-product" name="q" type="text" placeholder="{{ __('Search something...') }}" autocomplete="off">
                            <button class="btn" type="submit">
                                <span class="svg-icon">
                                    <svg>
                                        <use href="#svg-icon-search" xlink:href="#svg-icon-search"></use>
                                    </svg>
                                </span>
                            </button>
                        </div>
                        <a class="close-search-panel close-toggle--sidebar" href="#">
                            <span class="svg-icon">
                                <svg>
                                    <use href="#svg-icon-times" xlink:href="#svg-icon-times"></use>
                                </svg>
                            </span>
                        </a>
                    </div>
                </div>
                <div class="panel--search-result"></div>
            </form>
            @endif
        </div>
    </div>
    <div class="footer-mobile">
        <ul class="menu--footer">
            <li>
                <a href="{{ route('public.index') }}">
                    <i class="icon-home3"></i>
                    <span>{{ __('Home') }}</span>
                </a>
            </li>
            @if (is_plugin_active('ecommerce'))
                <li>
                    <a class="toggle--sidebar" href="#navigation-mobile">
                        <i class="icon-list"></i>
                        <span>{{ __('Category') }}</span>
                    </a>
                </li>
                @if (EcommerceHelper::isCartEnabled())
                    <li>
                         <a class="btn-shopping-cart" href="{{ route('public.cart') }}">
                        <!-- <a class="toggle--sidebar" href="#cart-mobile"> -->
                       
                            <i class="icon-cart">
                                <span class="cart-counter">{{ Cart::instance('cart')->count() }}</span>
                            </i>
                            <span>{{ __('Cart') }}</span>
                        </a>
                    </li>
                @endif
                @if (EcommerceHelper::isWishlistEnabled())
                    <li>
                        <a href="{{ route('public.wishlist') }}">
                            <i class="icon-heart"></i>
                            <span>{{ __('Wishlist') }}</span>
                        </a>
                    </li>
                @endif
                <li>
                    <a href="{{ route('customer.overview') }}">
                        <i class="icon-user"></i>
                        <span>{{ __('Account') }}</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>
    @if (is_plugin_active('ecommerce'))
        {!! Theme::partial('ecommerce.quick-view-modal') !!}
    @endif
    {!! Theme::partial('toast') !!}

    <div class="panel-overlay-layer"></div>
    <div id="back2top">
        <span class="svg-icon">
            <svg>
                <use href="#svg-icon-arrow-up" xlink:href="#svg-icon-arrow-up"></use>
            </svg>
        </span>
    </div>

    <script>
        'use strict';

        window.trans = {
            "View All": "{{ __('View All') }}",
            "No reviews!": "{{ __('No reviews!') }}"
        };

        window.siteConfig = {
            "url"            : "{{ route('public.index') }}",
            "img_placeholder": "{{ theme_option('lazy_load_image_enabled', 'yes') == 'yes' ? image_placeholder() : null }}",
            "countdown_text" : {
                "days"   : "{{ __('days') }}",
                "hours"  : "{{ __('hours') }}",
                "minutes": "{{ __('mins') }}",
                "seconds": "{{ __('secs') }}"
            }
        };

        @if (is_plugin_active('ecommerce') && EcommerceHelper::isCartEnabled())
            siteConfig.ajaxCart = "{{ route('public.ajax.cart') }}";
            siteConfig.cartUrl = "{{ route('public.cart') }}";
        @endif
    </script>

    {!! Theme::footer() !!}

     @if (session()->has('success_msg') || session()->has('error_msg') || (isset($errors) && $errors->count() > 0) || isset($error_msg))
         <script type="text/javascript">
             window.onload = function () {
                 @if (session()->has('success_msg'))
                    MartApp.showSuccess('{{ session('success_msg') }}');
                 @endif

                 @if (session()->has('error_msg'))
                    MartApp.showError('{{ session('error_msg') }}');
                 @endif

                 @if (isset($error_msg))
                    MartApp.showError('{{ $error_msg }}');
                 @endif

                 @if (isset($errors))
                     @foreach ($errors->all() as $error)
                        MartApp.showError('{!! BaseHelper::clean($error) !!}');
                     @endforeach
                 @endif
             };
         </script>
     @endif
     <script>
        
        // jQuery(document).ready(function(){
        //     console.log("ready");
        //     jQuery('[name="star"]').on('change',function(){
        //         console.log('click');
        //         jQuery(this).each(function(){
        //             if(jQuery(this).is(':checked')){
        //                 jQuery(this).remove('checked','');
        //             }else{
        //                 jQuery(this).attr('checked','');
        //             }
        //         });
                
        //     });
        // });
     </script>
   <!-- Cookie Consent by TermsFeed https://www.TermsFeed.com -->
<script type="text/javascript" src="https://www.termsfeed.com/public/cookie-consent/4.0.0/cookie-consent.js" charset="UTF-8"></script>
<script type="text/javascript" charset="UTF-8">
document.addEventListener('DOMContentLoaded', function () {
// cookieconsent.run({"notice_banner_type":"simple","consent_type":"express","palette":"light","language":"<?=str_replace('/','',substr($_SERVER['REQUEST_URI'],1,strrpos($_SERVER['REQUEST_URI'],"/")))!=''?str_replace('/','',substr($_SERVER['REQUEST_URI'],1,strrpos($_SERVER['REQUEST_URI'],"/"))):'it'?>","page_load_consent_levels":["strictly-necessary"],"notice_banner_reject_button_hide":false,"preferences_center_close_button_hide":false,"page_refresh_confirmation_buttons":false,"website_name":"https://snowequipmentshop.com"});
});
</script>

<noscript>Free cookie consent management tool by <a href="https://www.termsfeed.com/" rel="nofollow noopener">TermsFeed Policy Generator</a></noscript>
<!-- End Cookie Consent by TermsFeed https://www.TermsFeed.com -->





<!-- Below is the link that users can use to open Preferences Center to change their preferences. Do not modify the ID parameter. Place it where appropriate, style it as needed. -->

<a href="gghjghjghghjghj" id="open_preferences_center">Update cookies preferences</a>


<script>
//desc

$("#moredescbtn").click(function() {
    console.log("hello");
    jQuery('#moredesc').show();
    jQuery('#lessdesc').hide();
    jQuery('#moredescbtn').hide();
    jQuery('#lessdescbtn').show();

});
$("#lessdescbtn").click(function() {
    console.log("hello");
    jQuery('#lessdesc').show();
    jQuery('#moredesc').hide();
    jQuery('#moredescbtn').show();
    jQuery('#lessdescbtn').hide();
});

$("#moredescbtndownside").click(function() {
    console.log("hello");
    jQuery('#moredescdownside').show();
    jQuery('#lessdescdownside').hide();
    jQuery('#moredescbtndownside').hide();
    jQuery('#lessdescbtndownside').show();

});
$("#lessdescbtn1").click(function() {
    console.log("hello");
    jQuery('#lessdescdownside').show();
    jQuery('#moredescdownside').hide();
    jQuery('#moredescbtndownside').show();
    jQuery('#lessdescbtndownside').hide();
});



    $("#proddesc").click(function() {
    $('html, body').animate({
        scrollTop: $("#product_detail_tabs").offset().top
    }, 1000);
});

jQuery("#myBtn1").click(function() {
    jQuery("#myModal1").show();
    console.log("hello");
});
jQuery(".close").click(function() {
    jQuery("#myModal1").hide();
    console.log("hello");
});
jQuery("#myBtn2").click(function() {
    jQuery("#myModal2").show();
    console.log("hello");
});
jQuery(".close").click(function() {
    jQuery("#myModal2").hide();
    console.log("hello");
});
jQuery("#open_preferences_center").click(function() {
    jQuery("div.custom-cookie-set").show();
    console.log("hello cookie");
});
jQuery(".open_preferences_center").click(function() {
    jQuery(".custom-cookie-set").show();
    console.log("hello cookie");
});
jQuery("#open_preferences_center2-links").click(function() {
    jQuery("div.custom-cookie-set").show();
    console.log("hello cookie");
});

jQuery(document).ready(function(){
    jQuery(".custom-ads-css").last().css("width", "100%");
	jQuery(".custom-ads").last().hide();
  
});
// jQuery(document).ready(function(){
    

// });

// jQuery(window).load(function() {
//     var shortdesc  = jQuery('#shortdesc').html();
// jQuery('#shortdesc').html(shortdesc.substr(0, 300));

// });
    </script>
     <style>
         .header .header-bottom .header-wrapper .navigation .navigation__right
         {
             width:73% !important;
         }
body {
    overflow-x: hidden;
}
img.lazyload.entered.loaded {
    object-fit: fill !important;
}
ul{
    font-size:18px !important;
}
li{
    font-size:18px !important;
}
ul.nav {display:block !important}
.footer-info .container-xxxl.py-3 .site-info__item.d-flex.align-items-center{
    justify-content: center;
}
/* .footer-info .container-xxxl.py-3 {
    padding-left: 170px;
} */
         .dbtns {
    padding: 12px;
    width: 32%;
    background:transparent !important;
}
         .product-price ins{
            color: #659900;
         }
         .product-price del{
             color:black;
         }
         .product-details.js-product-content .product-price {
    clear: none;
}
         span.product-price-sale.d-flex.align-items-center {
    /* clear: both !important;
    display: block !important; */
    
}

.product-price ins {
    clear: both !important;
    display: block !important;
}
.img-fluid-eq .img-fluid-eq__wrap img {
    object-fit: cover;
}
div#footer-links {
    border: 0 !important;
}
a#open_preferences_center {
    display: none;
}
         .product-price{
             clear:both;
         }
        #lessdescbtn{
            display:none;
        }
        #moredesc{
    display:none;
}
      
small.star-count.ms-1.text-secondary.d-inline-block {
    color: green !important;
    font-weight: bold;
}
.star-rating-wrapper {
    float: left;
}

.meta-sku {
   
    border-left: 1px solid #b6b6b6;
    line-height: 15px;
    padding: 0px 10px;
    float: left;
    margin-left: 10px;
    margin-top: -1px;
}
/* button.btn.btn-primary.btn-black.mb-2.add-to-cart-button {
    display: none;
}
.product-loop__buttons {
    float: left !important;
    width: 20% !important;
}
.compare-button.product-compare-button.product-loop_button {
    display: none;
}
.wishlist-button.product-wishlist-button.product-loop_button {
    margin-bottom: 18px;
}
.wishlist-button span.text {
    display: none !important;
}
.wishlist-icons.product-loop_icon{
    font-size:25px;
} */
.product-button {
    border-top: 1px solid #dddddd;
    padding-top: 14px;
}
.entry-product-header {
    border-bottom: solid 1px #e4e4e4;
   margin-bottom:20px
}

.col-lg-4.col-md-8.ps-4.product-details-content {
    border-left: 0px;
}
.product-gallery {
    display: block !important;
}
.product-gallery .product-gallery__variants {
    max-width: 100% !important;
}
.product-gallery .product-gallery__wrapper {
    max-width: 100% !important;
    padding-left: 0 !important;
}
.flex-column {
    flex-direction: unset !important;
}
span.price-amount {
    font-size: 21px;
}
.product-detail-container .product-detail-tabs .nav .nav-link.active {
    background-color: transparent;
    color: green;
}
.tab-content {
    margin-left: 10px;
}
 .block2 {
    width: 20%;
    float: left;
    display: block;
}

 .block2-btn-addcart.w-size1.trans-0-4 {
    display: none;
}
 span.block2-price.m-text6.p-r-5 {
    text-align: center;
    display: block;
    font-weight: bold;
}
 a.block2-name.dis-block.s-text3.p-b-5 {
    text-align: center;
    display: block;
    font-weight: bold;
}
.block2-img.wrap-pic-w.of-hidden.pos-relative {
    margin-right: 10px;
}
.entry-meta {
    display: none !important;
}
.product-gallery .product-gallery__variants .slick-next-arrow {
    right: -12px;
    bottom: 0px !important;
    /* vertical-align: unset !important; */
    left: unset !important;
}
.product-gallery .product-gallery__variants .slick-prev-arrow {
   
   top: 38px !important;
   /* vertical-align: unset !important; */
   left: -10px !important;
}
.brand__text.py-3 {
    display: none !important;
}
.menu>li>a {
    
    padding: 0.9rem 0.9rem; !important;
}
.section-banner-wrapper .banner-medium .banner-item__image {
   /* height: unset !important; */
}
.header .header-bottom .header-wrapper .navigation .navigation__center{
padding-left:18px !important;
}
.page-breadcrumbs .container-xl {
    padding-left: 0px;
    margin-left: 36px;
}
.fade:not(.show) {
    display: none;
}

.custom-footer-css{
    font-size:16px;
}
.custom-footer-css a:hover{
    color:black !important;
}

@media only screen and (max-width: 768px) {
.custom-responsive-footer-one{
    padding-top:20px;
    justify-content:center;
    align-item:center;
    text-align:center;

}
.custom-responsive-footer-two{
    padding-top:20px;
    justify-content:center;
    align-item:center;
    text-align:center;

}
}
.nonlinear-wrapper .noUi-horizontal .noUi-handle{
    left: unset !important;
}
.#footer .border-top{
    border-top:0px !important;
}
.custom-footer-logo-design{
width: 215px;
margin: 0 auto;
justify-content: center;
align-items: center;
}

.cart--mini .mini-cart-content .control-buttons {
    border-top: 1px solid #e1e1e1;
    padding: 0 25px 55px;
}
    </style>
    <script>

jQuery(window).on('load', function(){

setTimeout(() => {
    

(()=>{var s;(s=jQuery).fn.expireCountdown=function(){return this.each((function(){var n=s(this),
e=n.data("expire"),t=function(s){if(s){
    var e={days:Math.floor(s/86400),hours:Math.floor(s%86400/3600),minutes:Math.floor(s%3600/60),seconds:Math.floor(s%60)},t=window.siteConfig.countdown_text||{days:"days",hours:"hours",minutes:"mins",seconds:"secs"};Object.keys(e).forEach((function(s){if("days"!=s||0!=e[s]){var a=n.find("."+s+" .digits");a.length?parseInt(a.text())!=e[s]&&a.text(e[s]>9?e[s]:"0"+e[s]):n.append('\n        <span class="__class__ timer">\n            <span class="digits">__digits__</span>\n            <span class="text">__text__</span>\n        </span>\n        <span class="divider">:</span>'.replace("__class__",s).replace("__digits__",e[s]>9?e[s]:"0"+e[s]).replace("__text__",t[s]))}})),n.closest(".countdown-wrapper").removeClass("d-none")}};t(e);var a=setInterval((function(){t(e-=1),e<0&&clearInterval(a)}),1e3)}))},s((function(){
s(".expire-countdown").expireCountdown()}))})();
}, 2000);
});
        </script>
    </body>
</html>
 