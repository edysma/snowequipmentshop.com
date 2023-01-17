@extends(BaseHelper::getAdminMasterLayoutTemplate())
@section('content')
<?php
$con=mysqli_connect("localhost","snownew","Hzf53s6_6%_","snownew",3306);
?>
    {!! Form::open(['route' => ['setting.email.template.store']]) !!}
    <input type="hidden" name="module" value="{{ $pluginData['name'] }}">
    <input type="hidden" name="template_file" value="{{ $pluginData['template_file'] }}">
    <div class="max-width-1200">
        <div class="flexbox-annotated-section">
            <div class="flexbox-annotated-section-annotation">
                <div class="annotated-section-title pd-all-20">
                    <h2>{{ trans('core/setting::setting.email.title') }}</h2>
                </div>
                <div class="annotated-section-description pd-all-20 p-none-t">
                    <p class="color-note">
                        {!! BaseHelper::clean(trans('core/setting::setting.email.description')) !!}
                    </p>
                </div>
            </div>

            <div class="flexbox-annotated-section-content">
                <div class="wrapper-content pd-all-20 email-template-edit-wrap">
                <?php $urlex = explode("/",$_SERVER['REQUEST_URI']); 
                if (in_array("contact", $urlex) && in_array("notice", $urlex))
                {
                    $res=mysqli_query($con,"SELECT * FROM languages ORDER BY lang_order ASC");
                    
                 ?>
                        <div class="form-group mb-3">
                            <label class="text-title-field"
                                   for="lang">
                                {{ trans('core/setting::setting.lang') }}
                            </label>
                            <select class="form-control" name="lang">
                            <option value="">Select Language</option>
                            <?php
                                while($row=mysqli_fetch_assoc($res)){
                                    ?>
                                    <option value="<?=$row['lang_locale']?>"><?=$row['lang_name']?></option>
                                    <?php
                                }
                            
                            ?>
                            </select>
                        </div>
                        <?php } ?>
                    @if ($emailSubject)
                        <div class="form-group mb-3">
                            <label class="text-title-field"
                                   for="email_subject">
                                {{ trans('core/setting::setting.email.subject') }}
                            </label>
                            <input type="hidden" name="email_subject_key"
                                   value="{{ get_setting_email_subject_key($pluginData['type'], $pluginData['name'], $pluginData['template_file']) }}">
                            <input data-counter="300" type="text" class="next-input"
                                   name="email_subject"
                                   id="email_subject"
                                   value="{{ $emailSubject }}">
                        </div>
                    @endif
                    <div class="form-group mb-3">
                        <label class="text-title-field"
                               for="email_content">{{ trans('core/setting::setting.email.content') }}</label>
                        <div class="d-inline-block mb-3">
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown"><i class="fa fa-code"></i> {{ __('Variables') }}
                                </button>
                                <ul class="dropdown-menu">
                                    @foreach(EmailHandler::getVariables($pluginData['type'], $pluginData['name'], $pluginData['template_file']) as $key => $label)
                                        <li><a href="#" class="js-select-mail-variable" data-key="{{ $key }}"><span class="text-danger">{{ $key }}</span>: {{ trans($label) }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <textarea id="mail-template-editor" name="email_content" class="form-control" style="overflow-y:scroll; height: 500px;">{{ $emailContent }}</textarea>
                    </div>
                </div>
            </div>

        </div>

        <div class="flexbox-annotated-section" style="border: none">
            <div class="flexbox-annotated-section-annotation">
                &nbsp;
            </div>
            <div class="flexbox-annotated-section-content">
                <a href="{{ route('settings.email') }}" class="btn btn-secondary">{{ trans('core/setting::setting.email.back') }}</a>
                <a class="btn btn-warning btn-trigger-reset-to-default" data-target="{{ route('setting.email.template.reset-to-default') }}">{{ trans('core/setting::setting.email.reset_to_default') }}</a>
                <button class="btn btn-info" type="submit" name="submit">{{ trans('core/setting::setting.save_settings') }}</button>
            </div>
        </div>
    </div>
    <script>
        jQuery(document).ready(function(){
            jQuery('[name="lang"]').on("change",function(){
                var val=jQuery(this).val()
                if(val!=''){
                    jQuery.ajax({
                        url:"notice/"+val,
                        type:"GET",
                        success:function(data){
                            console.log(data.emailContent);
                            if(data.emailContent!=''){
                                jQuery('#email_subject').val(data.emailSubject);
                                jQuery("#mail-template-editor").text(data.emailContent);
                              
                                var cm = $(".CodeMirror")[0].CodeMirror;
                                cm.setValue(data.emailContent);
                                cm.refresh();
                                
                            }
                        },
                    });
                }
            });
        });
    </script>
    {!! Form::close() !!}

    {!! Form::modalAction('reset-template-to-default-modal', trans('core/setting::setting.email.confirm_reset'), 'info', trans('core/setting::setting.email.confirm_message'), 'reset-template-to-default-button', trans('core/setting::setting.email.continue')) !!}
@endsection
