<?php
$con=mysqli_connect("localhost","snownew","Hzf53s6_6%_","snownew",3306);
$uri=$_SERVER['REQUEST_URI'];
$uri=explode('/',$uri);
?>
<div class="container-xxxl">
    <div class="row<?=(in_array('contact',$uri)?' py-5 mt-5':'')?>">
        <div class="col-md-4">
            <div class="contact-page-info mx-3">
                
                
                <h2>{!! BaseHelper::clean($shortcode->title) !!}</h2>
                <div class="fs-5 mt-5 mb-3">{!! BaseHelper::clean($shortcode->subtitle) !!}</div>
                @for ($i = 1; $i <= 3; $i++)
                    @if ($shortcode->{'name_' . $i} && $shortcode->{'address_' . $i})
                        <div class="contact-page-info-item">
                            <small class="fw-bold text-uppercase">{{ $shortcode->{'name_' . $i} }}</small>
                            <div class="fs-5">
                                <p>{{ $shortcode->{'address_' . $i} }}</p>
                                @if ($phone = $shortcode->{'phone_' . $i})
                                    <p><a href="tel:{{ $phone }}">{{ $phone }}</a></p>
                                @endif
                                @if ($email = $shortcode->{'email_' . $i})
                                    <p><a href="mailto:{{ $email }}">{{ $email }}</a></p>
                                @endif
                            </div>
                        </div>
                    @endif
                @endfor
                <?php
                
                //     $urlex = explode("/",$_SERVER['REQUEST_URI']);
                    
                //     $res=mysqli_query($con,"SELECT * FROM languages ORDER BY lang_order ASC");
                //     $lang="it";
                //     while($row=mysqli_fetch_assoc($res)){
                //         if(in_array($row['lang_locale'],$urlex)){
                //             $lang=$row['lang_locale'];
                //         }
                //     }

                //         $file=$lang.'_notice';
                // //     // echo $lang;
                // //     // echo $module=in_array('contact',$urlex)??'';
                
                //     $storagePath = get_setting_email_template_path('contact', $file);
                //     // if ($storagePath != null && File::exists($storagePath)) {
                //     //     $file=BaseHelper::getFileData($storagePath, false);
                //     //     print_r($file);
                //     // }

                //     if(file_exists($storagePath)){
                        
                //         include ($storagePath);
                    
                //     }
                    
                ?>
            </div>
        </div>
        @if ($shortcode->show_contact_form && is_plugin_active('contact'))
            <div class="col-md-8 border-start">
                {!! '[contact-form][/contact-form]' !!}
            </div>
        @endif
    </div>
</div>
