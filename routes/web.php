<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Botble\Ecommerce\Models\ProductPrice;
use Botble\Revision\Revision;
use Illuminate\Http\Request;


Route::get('clear-cache', function () {

    \Artisan::call('cache:clear');

    dd("Cache is cleared");

});


Route::get('/choose-country-region', [\App\Http\Controllers\ChooseCountryRegionController::class, 'index']);
Route::get('/productxml', [Botble\Ecommerce\Http\Controllers\Fronts\PublicProductController::class, 'getProductsxml']);


Route::post('/amministrazione/multi-product-del',function (Request $request){
    if($request->data != null && $request->data != ''){
       $data =  json_decode($request->data);
       foreach($data as $productPriceId){
           $price  = ProductPrice::find($productPriceId);
           if($price){
                $price->delete();
           }
       }
    }
});

Route::get('/revert-blog-changes' , function (Request $request){
    if(($request->id != null && $request->id != '') && ($request->back != null && $request->back != '')){
        $reversion = Revision::where('id', $request->id)->first();
        if($reversion){
            $model = $reversion->revisionable_type::where('id' , $reversion->revisionable_id)->first();
            if($model){
                $data = [
                    $reversion->key => $reversion->old_value
                ];
               $result =  $model->update($data);
               if($result){
                    $reversion->delete();
                    return redirect()->to($request->back);
               }
            }

        }
    }

});
