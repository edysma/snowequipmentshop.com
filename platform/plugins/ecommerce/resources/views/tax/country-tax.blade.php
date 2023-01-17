<div id="product-wrapper">
        <table class="table table-hover-variants">
            <thead>
            <tr>
                <th><input class="table-check-all" data-set=".table-hover-variants .checkboxes" type="checkbox"></th>
                <th>Country</th>
                <th>Tax percentage</th>
                <th class="text-center">Action</th>
            </tr>
            </thead>
            <tbody>
               
              
                @foreach($country_taxes as $country_tax)

                    <tr id="variation-id-{{ $country_tax->id }}">
                        <td style="width: 20px;"><input type="checkbox" class="checkboxes m-0" name="id[]" value="{{ $country_tax->id }}"></td>
                        <td>
                            <?php  echo $country_tax->name ?>
                        </td>
                        
                        <td>
                            {{ $country_tax->pivot->tax_percentage }}%
                        </td>
                       
                        
                        <td style="width: 180px;" class="text-center">
                            <a href="{{ route('tax.editCountryTax',$country_tax->pivot->tax_id) }}?country_id={{ $country_tax->id }}&tax_id={{ $country_tax->pivot->tax_id}}" class="btn btn-info btn-trigger-edit-product-version"
                                    data-target="{{ route('products.update-version', $flashSale->id ) }}?type=price"
                                    data-load-form="{{ route('products.get-version-form', $flashSale->id ) }}?type=price"
                            >Edit</a>
                            
                            <a href="{{ route('tax.deleteCountryTax', $flashSale->id ) }}?country_id={{ $country_tax->id }}&tax_id={{ $country_tax->pivot->tax_id}}"  data-id="{{ $flashSale->id }}"
                            class="btn-trigger-delete-version btn btn-danger">Delete</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    

    <br>
    <a href="{{ route('tax.addCountryTax') }}?id={{ $flashSale->id}}" class="btn-trigger-add-new-product-variation"
       data-target="{{ route('products.add-version', $flashSale->id) }}?type=price"
       data-load-form="{{ route('products.get-version-form', ['id' => 0, 'product_id' => $flashSale->id , 'type' => ' price']) }}"
       data-processing="{{ trans('plugins/ecommerce::products.processing') }}"
    >Add New</a>
</div>

