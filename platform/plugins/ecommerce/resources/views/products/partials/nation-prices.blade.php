<form  id ="delte-price-form" action="index.php" method="POST">
    <div id="product-wrapper">
        <div class="variation-actions">
            <!-- <a href="#" class="btn-trigger-delete-selected-variations text-danger" style="display: none" data-target="{{ route('products.delete-versions') }}">{{ trans('plugins/ecommerce::products.delete_selected_variations') }}</a> -->
            <!-- <a href="#" class="btn-trigger-select-product-attributes" data-target="{{ route('products.store-related-attributes', $product->id) }}">{{ trans('plugins/ecommerce::products.edit_attribute') }}</a> -->
            <!-- <a href="#" class="btn-trigger-generate-all-versions" data-target="{{ route('products.generate-all-versions', $product->id) }}">{{ trans('plugins/ecommerce::products.generate_all_variations') }}</a> -->
        </div>
        <table class="table table-hover-variants">
            <thead>
                <tr>
                    <th><input class="table-check-all" data-set=".table-hover-variants .checkboxes" type="checkbox"></th>
                    <th>{{ trans('plugins/ecommerce::products.form.country') }}</th>
                    <th>Price</th>
                    <th>Sale Price</th>
                    <th class="text-center">{{ trans('plugins/ecommerce::products.form.action') }}</th>
                </tr>
            </thead>
            <tbody>


                <?php
                $prices = Botble\Ecommerce\Models\ProductPrice::where('ec_products_id', $product->id)->get();
                // dd($product->id);
                ?>
                @foreach($prices as $price)

                <tr id="variation-id-{{ $price->id }}">
                    <td style="width: 20px;"><input type="checkbox" class="checkboxes m-0 price-select" name="price-select[]" value="{{ $price->id }}"></td>
                    <td>
                        <?php
                        foreach ($countries as $key => $value) {
                            if ($value->id == $price->countries_id) {
                                echo $value->name;
                            }
                        }
                        ?>
                    </td>

                    <td>
                        {{ format_price($price->price) }}
                    </td>
                    <td>
                        {{ format_price($price->nation_sale_price) }}
                    </td>

                    <td style="width: 180px;" class="text-center">
                        <a href="#" class="btn btn-info btn-trigger-edit-product-version" data-target="{{ route('products.update-version', $price->id) }}?type=price" data-load-form="{{ route('products.get-version-form', $price->id) }}?type=price">{{ trans('plugins/ecommerce::products.edit_variation_item') }}</a>
                        <a href="#" data-target="{{ route('products.delete-version', $price->id) }}?type=price" data-id="{{ $price->id }}" class="btn-trigger-delete-version btn btn-danger">{{ trans('plugins/ecommerce::products.delete') }}</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>


        <br>
        <a href="#" class="btn-trigger-add-new-product-variation" data-target="{{ url('/amministrazione/ecommerce/products/add-version') }}/{{$product->id}}?type=price" data-load-form="{{ route('products.get-version-form', ['id' => 0, 'product_id' => $product->id , 'type' => ' price']) }}" data-processing="{{ trans('plugins/ecommerce::products.processing') }}">Add new Price</a>

        <button class="btn btn-danger" id="delte-price-form-btn" value="Delete"> Delete </button>
        <!-- <a href="#" data-target="{{ route('products.delete-version', $price->id) }}?type=price" data-id="{{ $price->id }}" class="btn-trigger-delete-version btn btn-danger price-delete"> Delete </a> -->
    </div>
</form>


{!! Form::modalAction('select-attribute-sets-modal', trans('plugins/ecommerce::products.select_attribute'), 'info', view('plugins/ecommerce::products.partials.attribute-sets', compact('productAttributeSets'))->render(), 'store-related-attributes-button', trans('plugins/ecommerce::products.save_changes')) !!}
{!! Form::modalAction('add-new-product-variation-modal', trans('plugins/ecommerce::products.add_new_variation'), 'info', view('core/base::elements.loading')->render(), 'store-product-variation-button', trans('plugins/ecommerce::products.save_changes'), 'modal-lg') !!}
{!! Form::modalAction('edit-product-variation-modal', trans('plugins/ecommerce::products.edit_variation'), 'info', view('core/base::elements.loading')->render(), 'update-product-variation-button', trans('plugins/ecommerce::products.save_changes'), 'modal-lg') !!}
{!! Form::modalAction('generate-all-versions-modal', trans('plugins/ecommerce::products.generate_all_variations'), 'info', trans('plugins/ecommerce::products.generate_all_variations_confirmation'), 'generate-all-versions-button', trans('plugins/ecommerce::products.continue')) !!}
{!! Form::modalAction('confirm-delete-version-modal', trans('plugins/ecommerce::products.delete_variation'), 'danger', trans('plugins/ecommerce::products.delete_variation_confirmation'), 'delete-version-button', trans('plugins/ecommerce::products.continue')) !!}
{!! Form::modalAction('delete-variations-modal', trans('plugins/ecommerce::products.delete_variations'), 'danger', trans('plugins/ecommerce::products.delete_variations_confirmation'), 'delete-selected-variations-button', trans('plugins/ecommerce::products.continue')) !!}
<script>
    $(document).ready(function() {
        $('#delte-price-form-btn').attr('disabled', 'true');

        $('.price-select').on('change', function() {
            let checkCount = $('.price-select:checked').length;
            if (checkCount > 0) {
                $('#delte-price-form-btn').removeAttr('disabled');

            } else {

                $('#delte-price-form-btn').attr('disabled', 'true');
            }
        });


        $("#delte-price-form-btn").on('click',(function(e) {

            e.preventDefault(); // avoid to execute the actual submit of the form.

            var form = $('#delte-price-form');
            console.log( form.attr('action'));
            var actionUrl = form.attr('action');
            let data = [];
            $(".price-select:checked").each(function(){
                data.push($(this).val());
            });
            data = JSON.stringify(data);
            console.log(data);

            $.ajax({
                type: "POST",
                url: '/amministrazione/multi-product-del',
                data: { data : data },  // serializes the form's elements.
                success: function(data) {
                    var loc = window.location; window.location=loc;
                }
            });

        }));
    });
</script>