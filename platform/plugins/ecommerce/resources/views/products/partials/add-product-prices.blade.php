@if ($country->count() > 0)
    <div class="add-new-product-price-wrap">
        <input type="hidden" name="is_added_prices" id="is_added_prices" value="0">
        <!-- <a href="#" class="btn-trigger-add-price" data-bs-toggle-text="{{ trans('plugins/ecommerce::products.form.cancel') }}">{{ trans('plugins/ecommerce::products.form.add_new_price') }}</a> -->
        <div class="list-product-price-values-wrap ">
            <div class="product-select-price-item-template">
                <div class="product-price-set-item">
                    <div class="row">
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group mb-3">
                                <label class="text-title-field">{{ trans('plugins/ecommerce::products.form.country') }}</label>
                                <select class="next-input product-select-price-item" name="product_price_country[]">
                                    @foreach ($country as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group mb-3">
                                <label class="text-title-field">{{ trans('plugins/ecommerce::products.form.price') }}</label>
                                <div class="product-select-price-item-value-wrap">
                                <input  name="product_price[]" value="0" type="text" class="next-input">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6 product-set-item-delete-action hidden">
                            <div class="form-group mb-3">
                                <label class="text-title-field">&nbsp;</label>
                                <div style="height: 36px;line-height: 33px;vertical-align: middle">
                                    <a href="#" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            
        </div>
        <button type="button" onclick="add_price_items()"  class="btn btn-secondary btn-trigger-add-price-item " id="btn-trigger-add-price-item">
            Add more prices
        </button>
      
    </div>

@else
    <p>{!! trans('plugins/ecommerce::products.form.create_product_variations', ['link' => Html::link(route('product-attribute-sets.create'), trans('plugins/ecommerce::products.form.add_new_attributes'))]) !!}</p>
@endif

<script>
   console.log($('.product-price-set-item')); 
   let price_items = 0;
   function add_price_items(){
    let data =     '<div class="product-price-set-item">'
        data +=         '<div class="row">'
        data +=             '<div class="col-md-4 col-sm-6">'
        data +=                 '<div class="form-group mb-3">'
        data +=                     '<label class="text-title-field">{{ trans("plugins/ecommerce::products.form.country") }}</label>'
        data +=                     '<select class="next-input product-select-price-item" name="product_price_country[]">'
        data +=                         '@foreach ($country as $item)'
        data +=                             '<option  value="{{ $item->id }}">'
        data +=                                 '{{ $item->name }}'
        data +=                             '</option>'
        data +=                         '@endforeach'
        data +=                     '</select>'
        data +=                 '</div>'
        data +=             '</div>'
        data +=             '<div class="col-md-4 col-sm-6">'
        data +=                 '<div class="form-group mb-3">'
        data +=                     '<label class="text-title-field">{{ trans("plugins/ecommerce::products.form.price") }}</label>'
        data +=                     '<div class="product-select-price-item-value-wrap">'
        data +=                     '<input  name="product_price[]" type="text" class="next-input">'
        data +=                     '</div>'
        data +=                 '</div>'
        data +=             '</div>'
        data +=             '<div class="col-md-4 col-sm-6 product-set-item-delete-action hidden">'
        data +=                 '<div class="form-group mb-3">'
        data +=                     '<label class="text-title-field">&nbsp;</label>'
        data +=                     '<div style="height: 36px;line-height: 33px;vertical-align: middle">'
        data +=                         '<a href="#" class="btn btn-danger"><i class="fa fa-trash"></i></a>'
        data +=                     '</div>'
        data +=                 '</div>'
        data +=             '</div>'
        data +=             '</div>'
        data +=     '</div>'
        $('.product-select-price-item-template').append(data);

   }

   $('#btn-trigger-add-price-item').click(function() { 
    add_price_items();
   }, false);
</script>
