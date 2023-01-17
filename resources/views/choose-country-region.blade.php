<?php

use Illuminate\Support\Facades\DB;

 if(count( Botble\Location\Models\Country::all()) > 0 ){ 
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
			if(isset($response['error'])) {
				session(['country'=>112]);
			} else {
				if(isset($response['country'])){
                $recommendedCountryCode = $response['country'];
            }
            foreach (Botble\Location\Models\Country::all() as $country){
                if(strtolower($country->code) == strtolower($recommendedCountryCode)) {
                    session(['country'=>$country->id]);
                }
            }
			}
			
            
            
        }
    }
}


/*
 * CountryContinents.php
 */

/*
 * Map a two-letter continent code onto the name of the continent.
 */
$CONTINENTS = array(
	"AS" => "Asia",
	"AN" => "Antarctica",
	"AF" => "Africa",
	"SA" => "South America",
	"EU" => "Europe",
	"OC" => "Oceania",
	"NA" => "North America"
);

/*
 * Map a two-letter country code onto the country's two-letter continent code.
 */
$COUNTRY_CONTINENTS = array(
	"AF" => "AS",
	"AX" => "EU",
	"AL" => "EU",
	"DZ" => "AF",
	"AS" => "OC1",
	"AD" => "EU",
	"AO" => "AF",
	"AI" => "NA",
	"AQ" => "AN",
	"AG" => "NA",
	"AR" => "SA",
	"AM" => "AS",
	"AW" => "NA",
	"AU" => "OC",
	"AT" => "EU",
	"AZ" => "AS",
	"BS" => "NA",
	"BH" => "AS",
	"BD" => "AS",
	"BB" => "NA",
	"BY" => "EU",
	"BE" => "EU",
	"BZ" => "NA",
	"BJ" => "AF",
	"BM" => "NA",
	"BT" => "AS",
	"BO" => "SA",
	"BA" => "EU",
	"BW" => "AF",
	"BV" => "AN",
	"BR" => "SA",
	"IO" => "AS",
	"BN" => "AS",
	"BG" => "EU",
	"BF" => "AF",
	"BI" => "AF",
	"KH" => "AS",
	"CM" => "AF",
	"CA" => "NA",
	"CV" => "AF",
	"KY" => "NA",
	"CF" => "AF",
	"TD" => "AF",
	"CL" => "SA",
	"CN" => "AS",
	"CX" => "OC1",
	"CC" => "AS",
	"CO" => "SA",
	"KM" => "AF",
	"CD" => "AF",
	"CG" => "AF",
	"CK" => "OC1",
	"CR" => "NA",
	"CI" => "AF",
	"HR" => "EU",
	"CU" => "NA",
	"CY" => "AS",
	"CZ" => "EU",
	"DK" => "EU",
	"DJ" => "AF",
	"DM" => "NA",
	"DO" => "NA",
	"EC" => "SA",
	"EG" => "AF",
	"SV" => "NA",
	"GQ" => "AF",
	"ER" => "AF",
	"EE" => "EU",
	"ET" => "AF",
	"FO" => "EU",
	"FK" => "SA",
	"FJ" => "OC",
	"FI" => "EU",
	"FR" => "EU",
	"GF" => "SA",
	"PF" => "OC",
	"TF" => "AN",
	"GA" => "AF",
	"GM" => "AF",
	"GE" => "AS",
	"DE" => "EU",
	"GH" => "AF",
	"GI" => "EU",
	"GR" => "EU",
	"GL" => "NA",
	"GD" => "NA",
	"GP" => "NA",
	"GU" => "OC1",
	"GT" => "NA",
	"GG" => "EU",
	"GN" => "AF",
	"GW" => "AF",
	"GY" => "SA",
	"HT" => "NA",
	"HM" => "OC1",
	"VA" => "EU",
	"HN" => "NA",
	"HK" => "AS",
	"HU" => "EU",
	"IS" => "EU",
	"IN" => "AS",
	"ID" => "AS",
	"IR" => "AS",
	"IQ" => "AS",
	"IE" => "EU",
	"IM" => "EU",
	"IL" => "AS",
	"IT" => "EU",
	"JM" => "NA",
	"JP" => "AS",
	"JE" => "EU",
	"JO" => "AS",
	"KZ" => "AS",
	"KE" => "AF",
	"KI" => "OC",
	"KP" => "AS",
	"KR" => "AS",
	"KW" => "AS",
	"KG" => "AS",
	"LA" => "AS",
	"LV" => "EU",
	"LB" => "AS",
	"LS" => "AF",
	"LR" => "AF",
	"LY" => "AF",
	"LI" => "EU",
	"LT" => "EU",
	"LU" => "EU",
	"MO" => "AS",
	"MK" => "EU",
	"MG" => "AF",
	"MW" => "AF",
	"MY" => "AS",
	"MV" => "AS",
	"ML" => "AF",
	"MT" => "EU",
	"MH" => "OC1",
	"MQ" => "NA",
	"MR" => "AF",
	"MU" => "AF",
	"YT" => "AF",
	"MX" => "NA",
	"FM" => "OC1",
	"MD" => "EU",
	"MC" => "EU",
	"MN" => "AS",
	"ME" => "EU",
	"MS" => "NA",
	"MA" => "AF",
	"MZ" => "AF",
	"MM" => "AS",
	"NA" => "AF",
	"NR" => "OC",
	"NP" => "AS",
	"AN" => "NA",
	"NL" => "EU",
	"NC" => "OC",
	"NZ" => "OC",
	"NI" => "NA",
	"NE" => "AF",
	"NG" => "AF",
	"NU" => "OC1",
	"NF" => "OC1",
	"MP" => "OC1",
	"NO" => "EU",
	"OM" => "AS",
	"PK" => "AS",
	"PW" => "OC",
	"PS" => "AS",
	"PA" => "NA",
	"PG" => "OC",
	"PY" => "SA",
	"PE" => "SA",
	"PH" => "AS",
	"PN" => "OC1",
	"PL" => "EU",
	"PT" => "EU",
	"PR" => "NA",
	"QA" => "AS",
	"RE" => "AF",
	"RO" => "EU",
	"RU" => "EU",
	"RW" => "AF",
	"SH" => "AF",
	"KN" => "NA",
	"LC" => "NA",
	"PM" => "NA",
	"VC" => "NA",
	"WS" => "OC",
	"SM" => "EU",
	"ST" => "AF",
	"SA" => "AS",
	"SN" => "AF",
	"RS" => "EU",
	"SC" => "AF",
	"SL" => "AF",
	"SG" => "AS",
	"SK" => "EU",
	"SI" => "EU",
	"SB" => "OC1",
	"SO" => "AF",
	"ZA" => "AF",
	"GS" => "AN",
	"ES" => "EU",
	"LK" => "AS",
	"SD" => "AF",
	"SR" => "SA",
	"SJ" => "EU",
	"SZ" => "AF",
	"SE" => "EU",
	"CH" => "EU",
	"SY" => "AS",
	"TW" => "AS",
	"TJ" => "AS",
	"TZ" => "AF",
	"TH" => "AS",
	"TL" => "AS",
	"TG" => "AF",
	"TK" => "OC1",
	"TO" => "OC",
	"TT" => "NA",
	"TN" => "AF",
	"TR" => "AS",
	"TM" => "AS",
	"TC" => "NA",
	"TV" => "OC",
	"UG" => "AF",
	"UA" => "EU",
	"AE" => "AS",
	"GB" => "EU",
	"UM" => "OC",
	"US" => "NA",
	"UY" => "SA",
	"UZ" => "AS",
	"VU" => "OC",
	"VE" => "SA",
	"VN" => "AS",
	"VG" => "NA",
	"VI" => "NA",
	"WF" => "OC1",
	"EH" => "AF",
    "XK" => "EU",
	"YE" => "AS",
	"ZM" => "AF",
	"ZW" => "AF"
);

    // echo $response;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        @media only screen and (max-width: 999px) {
            .mini {
                margin-left: 20px;
            }
        }
    </style>

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
        <link rel="stylesheet" href="/themes/farmart/css/style.css?v=1.5.2">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>

<body>
    <header class="header header-js-handler" >
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
                        
                    </div>
                    <div class="header-items header__right">
                        
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="lg:container lg:ml-52 lg:w-auto mt-24 mini">
        <h1 class="text-3xl font-bold">{{ __('Choose the country or territory you are in to see local content and buy') }}</h1>
        <!-- <div class="lg:gird lg:grid-cols-3 w-4/5 justify-center items-center mt-8 sm:grid sm:grid-cols-1 "> -->

                <?php 
                           
                           echo '<div class="row pt-5 pb-5">';
                           echo"<h1 class='h3 fw-bold'>". __('Asia') ."</h1><hr/>";
                    foreach (array_chunk(Botble\Location\Models\Country::all()->toArray() , 3) as $set) {
                        
                            foreach ($set as $country) {
                            
                                //  echo "<pre>";
                                //  print_r($country);
                                //  echo "</pre>";
                                // exit;

                               $result = DB::table('countries_translations')->where('lang_code','like', '%'.session()->all()['language'].'_%')->where('countries_id' , $country['id'])->first();
                               if($result){
                                $countryName = $result->name;
                               }else{
                                $countryName = $country['name'];

                               }
                               if($country['status'] != "pending"){
                                  
                               if($CONTINENTS[$COUNTRY_CONTINENTS[$country['code']]]=="Asia"){
                                    
                                    echo '<div class="col-lg-4 col-md-4 pt-2">';
                                    echo '<a  href="'. route("public.change-country", $country['id']).'?request_from=https://'.$_SERVER['HTTP_HOST'] .'" class="text-base text-sky-600 coun">';
                                 ?>
                                    <span>{{ __($countryName) }} </span>
                                    <?php
                                    echo '</a>';
                                    echo '</div>';
                                   
                                    
                                }
                            }
                            //    dd( Language::getCurrentLocaleName());

                               
                            }
                        
                    }
                    echo '</div>';
                    echo '<div class="row pt-5 pb-5">';
                    echo"<h1 class='h3 fw-bold'>". __('Africa')."</h1><hr/>";
                    foreach (array_chunk(Botble\Location\Models\Country::all()->toArray() , 3) as $set) {
                        
                        foreach ($set as $country) {
                            // echo "<pre>";
                            // print_r($country);
                            // echo "</pre>";
						   session()->all()['language'] = (session()->all()['language'] != '') ? session()->all()['language'] : 'Italiano';
                           $result = DB::table('countries_translations')->where('lang_code','like', '%'.session()->all()['language'].'_%')->where('countries_id' , $country['id'])->first();
                           if($result){
                                $countryName = $result->name;
                           }else{
                            $countryName = $country['name'];

                           }
                           if($country['status'] != "pending"){
                            if($CONTINENTS[$COUNTRY_CONTINENTS[$country['code']]]=="Africa"){
                                
                                echo '<div class="col-lg-4 col-md-4 pt-2">';
                                echo '<a  href="'. route("public.change-country", $country['id']).'?request_from=https://'.$_SERVER['HTTP_HOST'] .'" class="text-base text-sky-600 coun">';
                              ?>
                               <span>{{ __($countryName) }} </span>
                                <?php
                                echo '</a>';
                                echo '</div>';
                                
                            }
                        }
                        //    dd( Language::getCurrentLocaleName());

                           
                        }
                    
                }
                echo '</div>';
                echo '<div class="row pt-5 pb-5">';
                echo"<h1 class='h3 fw-bold'>". __('Europe')."</h1><hr/>";
                foreach (array_chunk(Botble\Location\Models\Country::all()->toArray() , 3) as $set) {
                        
                    foreach ($set as $country) {
                        // echo "<pre>";
                        // print_r($country);
                        // echo "</pre>";
					   session()->all()['language'] = (session()->all()['language'] != '') ? session()->all()['language'] : 'Italiano';
                       $result =  DB::table('countries_translations')->where('lang_code','like', '%'.session()->all()['language'].'_%')->where('countries_id' , $country['id'])->first();
                       if($result){
                            $countryName = $result->name;
                       }else{
                        $countryName = $country['name'];

                       }
                       
                       if($country['status'] != "pending"){
                        if($CONTINENTS[$COUNTRY_CONTINENTS[$country['code']]]=="Europe"){
                            
                            echo '<div class="col-lg-4 col-md-4 pt-2">';
                            echo '<a  href="'. route("public.change-country", $country['id']).'?request_from=https://'.$_SERVER['HTTP_HOST'].'" class="text-base text-sky-600 coun">';
                            ?>
                            <span>{{ __($countryName) }} </span>
                             <?php
                            echo '</a>';
                            echo '</div>';
                            
                        }
                    }
                    //    dd( Language::getCurrentLocaleName());

                       
                    }
                
            }
            echo '</div>';
            echo '<div class="row pt-5 pb-5">';
            echo"<h1 class='h3 fw-bold'>". __('South America and the Caribbean')." </h1><hr/>";
            foreach (array_chunk(Botble\Location\Models\Country::all()->toArray() , 3) as $set) {
                        
                foreach ($set as $country) {
                    // echo "<pre>";
                    // print_r($country);
                    // echo "</pre>";
                    
                   $result =  DB::table('countries_translations')->where('lang_code','like', '%'.session()->all()['language'].'_%')->where('countries_id' , $country['id'])->first();
                   if($result){
                        $countryName = $result->name;
                   }else{
                    $countryName = $country['name'];

                   }
                   if($country['status'] != "pending"){
                    if($CONTINENTS[$COUNTRY_CONTINENTS[$country['code']]]=="South America"){
                        
                        echo '<div class="col-lg-4 col-md-4 pt-2">';
                        echo '<a  href="'. route("public.change-country", $country['id']).'?request_from=https://'.$_SERVER['HTTP_HOST'] .'" class="text-base text-sky-600 coun">';
                        ?>
                        <span>{{ __($countryName) }} </span>
                         <?php
                        echo '</a>';
                        echo '</div>';
                       
                    }
                   
                }
                //    dd( Language::getCurrentLocaleName());

                   
                }
            
        }
        echo '</div>';
        echo '<div class="row pt-5 pb-5">';
        echo"<h1 class='h3 fw-bold'>". __('North America and Antarctica')."</h1><hr/>";
        foreach (array_chunk(Botble\Location\Models\Country::all()->toArray() , 3) as $set) {
                        
            foreach ($set as $country) {
                // echo "<pre>";
                // print_r($country);
                // echo "</pre>";
                
               $result =  DB::table('countries_translations')->where('lang_code','like', '%'.session()->all()['language'].'_%')->where('countries_id' , $country['id'])->first();
               if($result){
                    $countryName = $result->name;
               }else{
                $countryName = $country['name'];

               }
               if($country['status'] != "pending"){
                if($CONTINENTS[$COUNTRY_CONTINENTS[$country['code']]]=="North America"  || $CONTINENTS[$COUNTRY_CONTINENTS[$country['code']]]=="Antarctica"){
                    
                    echo '<div class="col-lg-4 col-md-4 pt-2">';
                    echo '<a href="'. route("public.change-country", $country['id']).'?request_from=https://'.$_SERVER['HTTP_HOST'] .'" class="text-base text-sky-600 coun">';
                    ?>
                    <span>{{ __($countryName) }} </span>
                     <?php
                    echo '</a>';
                    echo '</div>';
                    
                }
            }
            //    dd( Language::getCurrentLocaleName());

               
            }
        
    }

        echo '</div>';
        echo '<div class="row pt-5 pb-5">';
        echo"<h1 class='h3 fw-bold'>". __('Oceania')."</h1><hr/>";
        foreach (array_chunk(Botble\Location\Models\Country::all()->toArray() , 3) as $set) {
                        
            foreach ($set as $country) {
                // echo "<pre>";
                // print_r($country);
                // echo "</pre>";
                
               $result =  DB::table('countries_translations')->where('lang_code','like', '%'.session()->all()['language'].'_%')->where('countries_id' , $country['id'])->first();
               if($result){
                    $countryName = $result->name;
               }else{
                $countryName = $country['name'];

               }
               if($country['status'] != "pending"){
                if($CONTINENTS[$COUNTRY_CONTINENTS[$country['code']]]=="Oceania"){
                    
                    echo '<div class="col-lg-4 col-md-4 pt-2">';
                    echo '<a href="'. route("public.change-country", $country['id']).'?request_from=https://'.$_SERVER['HTTP_HOST'] .'" class="text-base text-sky-600 coun">';
                    ?>
                    <span>{{ __($countryName) }} </span>
                     <?php
                    echo '</a>';
                    echo '</div>';
                    
                }
            }
            //    dd( Language::getCurrentLocaleName());

               
            }
        
    }
    echo '</div>';
                ?>
            
        <!-- </div> -->
    </div>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
     <script>
        jQuery(document).ready(function(){
            // console.log("ready");
            jQuery('.coun').click(function(){
                // console.log("click",jQuery(this).attr('href'));
                // setTimeout(()=>{
                    //window.location.href='https://<?//=$_SERVER['HTTP_HOST']?>';//'+jQuery(this).data('code');
                    console.log("location");
                // },1000);
                // console.log(jQuery(this));
            });
        });
     </script>
     <style>
        hr{
            width: 80%;
        }
     </style>
</body>
    <!-- <script>
        $('.coun').click(function){
            $(location).attr('href','');
            // $(window).(location).()('http://www.example.com')
            // .window.this.href = 'https://snow.algoretico.it/';
        }
    </script> -->
</html>



