<div class="variation-form-wrapper">
    <form action="">
        <input type="hidden" name="product_id" value={{$id}}>
        <div class="row">
                <div class="col-md-4 col-sm-6">
                    <div class="form-group mb-3">
                        <label for="" class="text-title-field required">Country</label>
                        <div class="ui-select-wrapper">
                            <select class="ui-select" id="attribute" name="country_id">
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}" >
                                        {{ $country->name }}
                                    </option>
                                @endforeach
                            </select>
                           
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <label  class="text-title-field required">Price</label>
                    <div class="">
                        <input type="text" name="price" value="0" class="form" id="">
                    </div>
                </div>
			    <div class="col-md-4 col-sm-6">
                    <label  class="text-title-field">Sale Price</label>
                    <div class="">
                        <input type="text" name="nation_sale_price" value="0" class="form" id="">
                    </div>
                </div>    
        </div>
    
        
    </form>

    @once
        <script id="gallery_select_image_template" type="text/x-custom-template">
            <div class="list-photo-hover-overlay">
                <ul class="photo-overlay-actions">
                    <li>
                        <a class="mr10 btn-trigger-edit-gallery-image" data-bs-toggle="tooltip" data-placement="bottom"
                           data-bs-original-title="{{ trans('core/base::base.change_image') }}">
                            <i class="fa fa-edit"></i>
                        </a>
                    </li>
                    <li>
                        <a class="mr10 btn-trigger-remove-gallery-image" data-bs-toggle="tooltip" data-placement="bottom"
                           data-bs-original-title="{{ trans('core/base::base.delete_image') }}">
                            <i class="fa fa-trash"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="custom-image-box image-box">
                <input type="hidden" name="__name__" class="image-data">
                <img src="{{ RvMedia::getDefaultImage(false) }}" alt="{{ trans('core/base::base.preview_image') }}" class="preview_image">
                <div class="image-box-actions">
                    <a class="btn-images" data-result="images[]" data-action="select-image">
                        {{ trans('core/base::forms.choose_image') }}
                    </a> |
                    <a class="btn_remove_image">
                        <span></span>
                    </a>
                </div>
            </div>
        </script>
    @endonce

</div>
