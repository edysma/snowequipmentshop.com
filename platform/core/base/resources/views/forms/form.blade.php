@extends(BaseHelper::getAdminMasterLayoutTemplate())
@section('content')
    @if ($showStart)
        {!! Form::open(Arr::except($formOptions, ['template'])) !!}
    @endif

    @php
        do_action(BASE_ACTION_TOP_FORM_CONTENT_NOTIFICATION, request(), $form->getModel())
    @endphp
    <?php
$con=mysqli_connect("localhost","snownew","Hzf53s6_6%_","snownew",3306);
?>
<div class="row">
        <div class="col-md-9">
            @if ($showFields && $form->hasMainFields())
                <div class="main-form">
                    <div class="{{ $form->getWrapperClass() }}">
                        
                        @foreach ($fields as $key => $field)
                            
                            @if ($field->getName() == $form->getBreakFieldPoint())
                                @break
                            @else
                                @unset($fields[$key])
                            @endif
                            @if (!in_array($field->getName(), $exclude))
                                {!! $field->render() !!}
                                @if (defined('BASE_FILTER_SLUG_AREA') && $field->getName() == SlugHelper::getColumnNameToGenerateSlug($form->getModel()))
                                    {!! apply_filters(BASE_FILTER_SLUG_AREA, null, $form->getModel()) !!}
                                @endif
                            @endif
                        @endforeach
                        <div class="clearfix"></div>
                        
                    </div>
					
                <?php $urlex = explode("/",$_SERVER['REQUEST_URI']); 
                if (in_array("ads", $urlex))
                {
                 ?>
 <div class="{{ $form->getWrapperClass() }}">
    @php
        $res=mysqli_query($con,"SELECT * FROM ads WHERE id=".$form->getModel()->id." ");
        $row=mysqli_fetch_assoc($res);
    @endphp
                        <div class="fomr-group row mb-3">
                          
                            <div class="col-3">
                          <div style="float:left">  {{ __('other tab ?') }} </div>
                          <div style="float:left;margin-left:10px;">    
                          <input name="target_blank" type="checkbox" <?= $row['other_tab']==1?'checked':'' ?> value="1"> </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                    </div>
                 <?php
                }
                if (in_array("products", $urlex))
                {
                    if($form->getModel()->id != ""){
                        $res=mysqli_query($con,"SELECT * FROM ec_products WHERE id=".$form->getModel()->id." ");
                    }
                    else{
                    $res=mysqli_query($con,"SELECT * FROM ec_products ");

                    }
                    $row=mysqli_fetch_assoc($res);
                    $btn_text=$row['btn_text'];
                    $btn_text_one=$row['btn_text_one'];
                    $btn_text_two=$row['btn_text_two'];
                    $video_link=$row['video_link'];
                    $readmore=$row['readmore'];
             ?>
                
                <div class="{{ $form->getWrapperClass() }}">
                        <div class="fomr-group row mb-3">
                            <label class="text-title-field">{{ trans('core/base::forms.pdflabel') }}</label>
                            <div class="col-7">
                                <input name="product_file_pdf" type="file" value="" class="form-control" placeholder="Add PDF">
								<a target="_blank" href="https://snowequipmentshop.com/storage/{{ $row['file_path'] }}"> https://snowequipmentshop.com/storage/{{ $row['file_path'] }} </a>


                            </div>
                            <div class="col-5">
                                
                                <input name="btn_text" type="text" value="<?=$btn_text?>" class="form-control" placeholder="Button Text">
                            </div>
                        </div>
                        <div class="clearfix"></div>

                    </div>
                    
                    <div class="{{ $form->getWrapperClass() }}">
                        <div class="fomr-group row mb-3">
                            <div class="col-12">
                                <label class="text-title-field">{{ trans('core/base::forms.btn_snd') }}</label> 
                                <textarea name="btn_text_one" type="text" class="form-control" placeholder="Content"><?=$btn_text_one?></textarea>
                            </div>
                            
                        </div>
                        <div class="clearfix"></div>

                    </div>
                    <div class="{{ $form->getWrapperClass() }}">
                        <div class="fomr-group row mb-3">
                        <div class="col-12">
                                <label class="text-title-field">{{ trans('core/base::forms.btn_trd') }}</label> 
                                <textarea name="btn_text_two" type="text" class="form-control" placeholder="Content"><?=$btn_text_two?></textarea>
                            </div>
                            
                        </div>
                        <div class="clearfix"></div>

                    </div>

                    <div class="{{ $form->getWrapperClass() }}">
                    
                    <div class="form-group mb-3 ">
                         <label class="text-title-field">{{ __('read more character') }}</label> 
                        <input name="readmore" type="text" value="<?=$readmore?>" class="form-control" placeholder="read more characters"/>
                        if this is empty its means there will not read more functionility
                    </div>

                    
                    <div class="clearfix"></div>
                </div>
                <div class="{{ $form->getWrapperClass() }}">
                    
                        <div class="form-group mb-3 ">
                             <label class="text-title-field">{{ trans('core/base::forms.videos') }}</label> 
                            <input name="video_link" type="text" value="<?=$video_link?>" class="form-control" placeholder="Video Link"/>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <?php } ?>    
                </div>
               
            @endif
            @if (isset($urlex))
			  @if(in_array("ads", $urlex)))
                <div class="{{ $form->getWrapperClass() }}">        
                    <div class="form-group mb-3 ">
                        <label class="text-title-field">Input Country Names (Separated by Comma)</label> 
                        @php
                            $con = mysqli_connect("localhost","snownew","Hzf53s6_6%_","snownew",3306);
                            $res=mysqli_query($con,"SELECT * FROM ads WHERE id=".$form->getModel()->id);
                            $row=mysqli_fetch_assoc($res);

                        @endphp
                        <input name="country_ids" type="text" value="{{ $row['country_ids'] }}" class="form-control" placeholder="Country Ids"/>
                    </div>
                    <div class="clearfix"></div>
                </div>
			  @endif
            @endif
            @foreach ($form->getMetaBoxes() as $key => $metaBox)
                {!! $form->getMetaBox($key) !!}
            @endforeach

            @php do_action(BASE_ACTION_META_BOXES, 'advanced', $form->getModel()) @endphp
        </div>
        <div class="col-md-3 right-sidebar">
            {!! $form->getActionButtons() !!}
            @php do_action(BASE_ACTION_META_BOXES, 'top', $form->getModel()) @endphp

            @foreach ($fields as $field)
                @if (!in_array($field->getName(), $exclude))
                    @if ($field->getType() == 'hidden')
                        {!! $field->render() !!}
                    @else
                        <div class="widget meta-boxes">
                            <div class="widget-title">
                                <h4>{!! Form::customLabel($field->getName(), $field->getOption('label'), $field->getOption('label_attr')) !!}</h4>
                            </div>
                            <div class="widget-body">
                                {!! $field->render([], in_array($field->getType(), ['radio', 'checkbox'])) !!}
                            </div>
                        </div>
                    @endif
                @endif
            @endforeach

            @php do_action(BASE_ACTION_META_BOXES, 'side', $form->getModel()) @endphp
			@if (isset($urlex))
                @if (in_array("products", $urlex))
                    <a href="https://snowequipmentshop.com/amministrazione/ecommerce/products/duplicate-products/{{$form->getModel()->id}}"  class="btn btn-warning pull-right"><i class="fa fa-save"></i> Duplicate </a>
                @endif	
			@endif
        </div>
    </div>

    @if ($showEnd)
        {!! Form::close() !!}
    @endif

    @yield('form_end')
@stop

@if ($form->getValidatorClass())
    @if ($form->isUseInlineJs())
        {!! Assets::scriptToHtml('jquery') !!}
        {!! Assets::scriptToHtml('form-validation') !!}
        {!! $form->renderValidatorJs() !!}
    @else
        @push('footer')
            {!! $form->renderValidatorJs() !!}
        @endpush
    @endif
@endif
