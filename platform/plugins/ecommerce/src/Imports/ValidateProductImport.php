<?php

namespace Botble\Ecommerce\Imports;

use Botble\Ecommerce\Models\ProductPrice;
use Botble\Ecommerce\Models\ProductVariation;
use Botble\Location\Models\Country;
use Maatwebsite\Excel\Validators\Failure;

class ValidateProductImport extends ProductImport
{
    /**
     * @param array $row
     *
     * @return null
     */
    public function model(array $row)
    {
        $importType = $this->getImportType();

        $name = $this->request->input('name');

        if(isset($row['is_nation_price'])){
            $row['is_nation_price'] = trim($row['is_nation_price']);
        }


        if ($importType == 'products' && $row['import_type'] == 'product' && ( (isset($row['is_nation_price'])  && $row['is_nation_price'] != '1' ) || !isset($row['is_nation_price']) )) {
            // dd('sdfsdf');
            return $this->storeProduction();
        }

        if ($importType == 'variations' && $row['import_type'] == 'variation') {
            $product = $this->getProductByName($name);

            return $this->storeVariant($product);
        }

        if(isset($row['is_nation_price']) && $row['is_nation_price'] == '1') {
            $product = $this->getProductByName($name);
            // return null;
            return $this->storeNationPrice($product , $row);
        }

        if ($row['import_type'] == 'variation') {
            $collection = $this->successes()
                ->where('import_type', 'product')
                ->where('name', $name)
                ->first();

            if ($collection) {
                $product = $collection['model'];
            } else {
                $product = $this->getProductByName($name);
            }

            return $this->storeVariant($product);
        }

        return $this->storeProduction();
    }

    /**
     * @return null
     */
    public function storeProduction()
    {
        $product = collect($this->request->all());
        $collect = collect([
            'name'        => $product['name'],
            'import_type' => 'product',
            'model'       => $product,
        ]);
        $this->onSuccess($collect);

        return null;
    }
    /**
     * @return null
     */
    public function storeVariant($product): ?ProductVariation
    {
        if (!$product) {
            if (method_exists($this, 'onFailure')) {
                $failures[] = new Failure(
                    $this->rowCurrent,
                    'Product Name',
                    [__('Product name ":name" does not exists', ['name' => $this->request->input('name')])],
                    []
                );
                $this->onFailure(...$failures);
            }

            return null;
        }

        return null;
    }

    public function storeNationPrice($product , $rowCurrent)
    {

        if (!$product) {
            if (method_exists($this, 'onFailure')) {
                $failures[] = new Failure(
                    $this->rowCurrent,
                    'Product Name',
                    [__('Product name ":name" does not exists', ['name' => $this->request->input('name')])],
                    []
                );
                $this->onFailure(...$failures);
            }

            return null;
        
        return null;
    } else {
        // dd($rowCurrent);
        // $this->rowCurrent = $rowCurrent;
        $country_code = isset( $rowCurrent['country_code'] ) ? $rowCurrent['country_code']  : null ;
        $country_prices = isset( $rowCurrent['country_price'] ) ? $rowCurrent['country_price']  : null ;
        // var_dump($country_code);

        if($country_code  && $country_prices) {
            $countryObject = Country::where('code' , $country_code)->first();

            if($countryObject) {
                $existingProductPrice = ProductPrice::where('ec_products_id' ,$product->id)->where('countries_id' , $countryObject->id)->first();
                if(!$existingProductPrice){
                    $productPrice = new ProductPrice();
                    $productPrice->ec_products_id = $product->id;
                    $productPrice->countries_id = $countryObject->id;
                    $productPrice->price = $country_prices;
                    $productPrice->save();
                    // dd('die');
                    return  $productPrice;
                }else{
                  
                    $existingProductPrice->price = $country_prices;
                    $existingProductPrice->save();
                }
               

            }
        }

        return null;

    }
    
}

    
}
