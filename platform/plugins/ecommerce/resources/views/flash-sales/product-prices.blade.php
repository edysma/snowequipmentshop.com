<div id="product-wrapper">
        <table class="table table-hover-variants">
            <thead>
            <tr>
                <th><input class="table-check-all" data-set=".table-hover-variants .checkboxes" type="checkbox"></th>
                <th>Categorie</th>
                <th>Discount</th>
                <th class="text-center">Action</th>
            </tr>
            </thead>
            <tbody>
               
                <?php
                        use Botble\Ecommerce\Models\CustomerCategory;
                ?>
                @foreach($categories as $category)

                    <tr id="variation-id-{{ $flashSale->id }}">
                        <td style="width: 20px;"><input type="checkbox" class="checkboxes m-0" name="id[]" value="{{ $category->category }}"></td>
                        <td>
                            <?php  echo CustomerCategory::find($category->id)->name  ?>
                        </td>
                        
                        <td>
                        {{ $category->getOriginal()['pivot_discount'] }}%
                        </td>
                       
                        
                        <td style="width: 180px;" class="text-center">
                            <a href="{{ route('flash-sale.editProductPrice',$category->getOriginal()['pivot_flash_sale_id']) }}?categorie_id={{ $category->id }}" class="btn btn-info btn-trigger-edit-product-version"
                                    data-target="{{ route('products.update-version', $flashSale->id ) }}?type=price"
                                    data-load-form="{{ route('products.get-version-form', $flashSale->id ) }}?type=price"
                            >Edit</a>
                            
                            <a href="{{ route('flash-sale.deleteProductPrice', $flashSale->id ) }}?categorie_id={{ $category->id }}"  data-id="{{ $flashSale->id }}"
                            class="btn-trigger-delete-version btn btn-danger">Delete</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    

    <br>
    <a href="{{ route('flash-sale.addProductPrice') }}?id={{ $flashSale->id}}" class="btn-trigger-add-new-product-variation"
       data-target="{{ route('products.add-version', $flashSale->id) }}?type=price"
       data-load-form="{{ route('products.get-version-form', ['id' => 0, 'product_id' => $flashSale->id , 'type' => ' price']) }}"
       data-processing="{{ trans('plugins/ecommerce::products.processing') }}"
    >Add New</a>
</div>

