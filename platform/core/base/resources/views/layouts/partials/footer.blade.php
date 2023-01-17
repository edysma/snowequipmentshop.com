<div class="page-footer">
    <div class="page-footer-inner">
        <div class="row">
            <div class="col-md-6">
                {!! BaseHelper::clean(trans('core/base::layouts.copyright', ['year' => now()->format('Y'), 'company' => setting('admin_title', config('core.base.general.base_name')), 'version' => get_cms_version()])) !!}
            </div>
            <div class="col-md-6 text-end">
                @if (defined('LARAVEL_START')) {{ trans('core/base::layouts.page_loaded_time') }} {{ round((microtime(true) - LARAVEL_START), 2) }}s @endif
            </div>
        </div>
    </div>
    <div class="scroll-to-top">
        <i class="icon-arrow-up-circle"></i>
    </div>
</div>
<script>
jQuery(document).ready(function(){
    jQuery("#select-offers").append('<option value="customer-category" v-if="type_option !== "same-price"">{{ __("Customer Category")}}</option>');

    jQuery("#discount-type-option").change(function(){
        if(jQuery('#discount-type-option').val()=="same-price"){
            jQuery('option[value="customer-category"]').remove();
        }else{
            jQuery('option[value="customer-category"]').remove();
            jQuery("#select-offers").append('<option value="customer-category" v-if="type_option !== "same-price"">{{ __("Customer Category")}}</option>');

        }
    });
    jQuery("#select-offers").change(function(){
        if(jQuery(this).val()=="customer-category"){
            console.log(jQuery(this).parents('div').eq(1),"val");
            // jQuery("#div-select-customer-category").remove();
            jQuery(this).parents('div').eq(1).append('<div id="div-select-customer-category" class="inline mb5">'+
                                                        '<div class="box-search-advance customer" style="min-width: 310px;"><div>'+
                                                            '<input type="text" placeholder="Search customer category" class="next-input textbox-advancesearch customer-category">'+
                                                        '</div>'+
                                                        '<div class="panel panel-default category"><div class="panel-body">'+
                                                          '<div class="list-search-data"><div class="has-loading" style="display: none;">'+
                                                            '<i class="fa fa-spinner fa-spin"></i>'+
                                                          '</div>'+
                                                           '<ul class="clearfix category-ul" style="">'+
                                                            
                                                            '</ul></div></div><div class="panel-footer foot"><div class="btn-group float-end"><button type="button" disabled="disabled" class="btn btn-secondary disable"><svg role="img" class="svg-next-icon svg-next-icon-size-16 svg-next-icon-rotate-180"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#next-chevron"></use></svg></button> <button type="button" class="btn btn-secondary"><svg role="img" class="svg-next-icon svg-next-icon-size-16"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#next-chevron"></use></svg></button></div> <div class="clearfix"></div></div></div>'
                                                                );
        jQuery('.customer-category').focus(function(){
            console.log("focus");
            
            jQuery.ajax({
                url:"{{ route('customers.get-list-customers-category-for-search') }}",
                type:'GET',
                success:function(data){
                    console.log(data,"data");
                    console.log(data.data,"data data");
                    console.log(data.data.data,"data data data");
                    jQuery('.category').addClass('active');
                    jQuery('.category').removeClass('hidden');
                    jQuery(".category-ul").empty();
                    if(data.error!=false || data.message!=null){
                        jQuery(".foot").hide();
                    }
                     jQuery.each(data.data.data,function(key,value){
                       console.log(value); 
                       jQuery(".category-ul").append('<li class="row select-category" data-id="'+value.id+'" data-name="'+value.name+'">'+
                                                                '<div class="flexbox-grid-default flexbox-align-items-center">'+
                                                                '<div class="flexbox-auto-40">'+
                                                                '</div>'+
                                                                 '<div class="flexbox-auto-content-right"><div class="overflow-ellipsis">'+value.name+'</div>'+
                                                                '</div></div>'+
                                                            '</li>');
                                                            jQuery('.selected-category').remove();
                        jQuery('.customer-category').parents('div').eq(5).append('<div class="clearfix selected-category" style="display: none;"> <div class="mt20"><label class="text-title-field">Selected customers category:</label></div></div>');
                        
                            
                        
                        jQuery('.select-category').click(function(){
                            
                            console.log(jQuery('.selected-category'),"child");
                            jQuery('.selected-category').show();
                            jQuery('.selected-category').append('<input type="hidden" class="remove-'+jQuery(this).data('id')+'" name="customers_category[]" value="'+jQuery(this).data('id')+'"> <div  class="table-wrapper p-none mt10 mb20 ps-relative remove-'+jQuery(this).data('id')+'"><table class="table-normal"><tbody><tr> <td class="pl5 p-r5 min-width-200-px">'+jQuery(this).data('name')+'</td> <td class="pl5 p-r5 text-end width-20-px min-width-20-px"><a href="#" class="remove-category" data-id="'+jQuery(this).data('id')+'"><svg class="svg-next-icon svg-next-icon-size-12"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#next-remove"></use></svg></a></td></tr></tbody></table></div>');
                            jQuery('.remove-category').click(function(){
                                jQuery('.remove-'+jQuery(this).data("id")).remove();
                                  if(jQuery('.selected-category').children().length<=3){
                                        jQuery('.selected-category').hide();

                                  }  
                                
                            });
                        });                                    
                    });
                },  

            });
        });                                                     

        }else{
            console.log("else");
            jQuery("#div-select-customer-category").remove();
        }
    });
    jQuery('.select-category').click(function(){
        
    }); 

});
// jQuery(document).ready(function($){
  
//   let txt = jQuery('.form-control.form-control.editor-ckeditor');
    
//      var i = 0;
//      setTimeout(()=>{ 
//     txt.each(function(){
//         txtlength=jQuery(this).html();
//         i++;
    
//        if(txtlength.length > 100){
            
        
//             jQuery(this).parents('.form-group').find('.ck-editor').hide();
           
//             var min=txtlength.substr(0,100);
//             var html=jQuery.parseHTML(min)[0].data;
//             // console.log(html,"html");
//             jQuery(this).parents('.form-group').append('<div class="fulltxt" style="padding: 12px;"></div>');
//             jQuery(this).parents('.form-group').find('.fulltxt').html(html+'...<a data-result="'+jQuery(this).attr('name')+'" href="javascript:void(0)" class="btn_read">Read more</a>');
//         //    jQuery(this).html(min+' ...<a href="javascript:void(0)" class="btn_read'+i+'">Read more</a>');
//            //jQuery(this).parents('.form-group').find('.d-flex').append('<div class="d-inline-block editor-action-item"><a href="javascript:void(0)" data-result="'+jQuery(this).attr('name')+'"   class="btn_read'+i+'" btn btn-primary">Read More</a></div>');
           
          
           
       
//         }
//     });

//     jQuery('.btn_read').click( function(event) {
//             event.preventDefault();
            
//             jQuery(this).parents('.form-group').find('.ck-editor').show();
//             jQuery(this).parents('.fulltxt').hide();
//             var id=jQuery(this).data('result');
//             jQuery(this).parents('.form-group').find('.d-flex').append('<div id="less_'+id+'" class="d-inline-block editor-action-item"><a href="javascript:void(0)" data-result="'+id+'"   class="btn_less btn btn-primary">Read Less</a></div>');
            
//             jQuery('.btn_less').click( function() {
            
//                 jQuery(this).parents('.form-group').find('.ck-editor').hide();
//                 jQuery(this).parents('.form-group').find('.fulltxt').show();
//                 var id=jQuery(this).data('result');
//                 jQuery('#less_'+id).remove();
//                 // jQuery(this).parents('.form-group').find('.d-flex').append('<div class="d-inline-block editor-action-item"><a href="javascript:void(0)" data-result="'+jQuery(this).attr('name')+'"   class="btn_read'+i+'" btn btn-primary">Read Less</a></div>');
//             });
//     });
    
//     jQuery(".show-hide-editor-btn").click(function(){
        
//             var id=jQuery(this).data('result');
//             jQuery('#less_'+id).remove();
//             jQuery('#'+id).show();
//             jQuery(this).parents('.form-group').find('.fulltxt').hide();
//             jQuery(this).parents('.form-group').find('.d-flex').append('<div id="less_'+id+'" class="d-inline-block editor-action-item"><a href="javascript:void(0)" data-result="'+id+'"   class="btn_less btn btn-primary">Read Less</a></div>');
            
//             jQuery('.btn_less').click( function() {
                
//                 var id=jQuery(this).data('result');
//                 jQuery(this).parents('.form-group').find('.ck-editor').hide();
//                 jQuery('#'+id).hide();
//                 jQuery(this).parents('.form-group').find('.fulltxt').show();
                
//                 jQuery('#less_'+id).remove();
//                 // jQuery(this).parents('.form-group').find('.d-flex').append('<div class="d-inline-block editor-action-item"><a href="javascript:void(0)" data-result="'+jQuery(this).attr('name')+'"   class="btn_read'+i+'" btn btn-primary">Read Less</a></div>');
//             });
//     });

//     },2000);
//   //  jQuery('.btn_read2').click( function(event) {
 
//        // });
// });
</script>

