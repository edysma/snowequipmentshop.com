<?php

namespace Botble\Ecommerce\Http\Controllers;

use Botble\Base\Events\BeforeEditContentEvent;
use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Forms\FormBuilder;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Ecommerce\Forms\FlashSaleForm;
use Botble\Ecommerce\Forms\FlashSaleProductPriceForm;
use Botble\Ecommerce\Http\Requests\FlashSaleRequest;
use Botble\Ecommerce\Models\FlashSale;
use Botble\Ecommerce\Models\FlashSaleProductPrice;
use Botble\Ecommerce\Repositories\Interfaces\FlashSaleInterface;
use Botble\Ecommerce\Tables\FlashSaleTable;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Throwable;

class FlashSaleController extends BaseController
{
    /**
     * @var FlashSaleInterface
     */
    protected $flashSaleRepository;

    /**
     * @param FlashSaleInterface $flashSaleRepository
     */
    public function __construct(FlashSaleInterface $flashSaleRepository)
    {
        $this->flashSaleRepository = $flashSaleRepository;
    }

    /**
     * @param FlashSaleTable $table
     * @return Factory|View
     * @throws Throwable
     */
    public function index(FlashSaleTable $table)
    {
        page_title()->setTitle(trans('plugins/ecommerce::flash-sale.name'));

        return $table->renderTable();
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/ecommerce::flash-sale.create'));
        return $formBuilder->create(FlashSaleForm::class)->renderForm();
    }

    public function addProductPrice(FormBuilder $formBuilder , Request $request){
        page_title()->setTitle(trans('plugins/ecommerce::flash-sale.create'));
        $flashSale = null;

        if((isset($request->id) && $request->id != '') ){
            $flashSale = FlashSale::find(trim($request->id));
        }

        return $formBuilder->create(FlashSaleProductPriceForm::class , ['model' => $flashSale] , ['id' => $request->id])->renderForm();
    }


    public function editProductPrice(Request $request ,FormBuilder $formBuilder ,$id){
        $flashSale = null;
        if((isset($request->categorie_id) && $request->categorie_id != '') && (isset($id) && $id != '') )
            $flashSale = FlashSaleProductPrice::where('category_id' , $request->categorie_id)->where('flash_sale_id' , $id )->first();

        event(new BeforeEditContentEvent($request, $flashSale));

        page_title()->setTitle(trans('plugins/ecommerce::flash-sale.create'));
        return $formBuilder->create(FlashSaleProductPriceForm::class ,['model' => $flashSale])->renderForm();
    }

    public function deleteProductPrice(Request $request ,BaseHttpResponse $response ,$id){

        if((isset($request->categorie_id) && $request->categorie_id != '') && (isset($id) && $id != '') )
            $result = FlashSaleProductPrice::where('category_id' , $request->categorie_id)->where('flash_sale_id' , $id )->delete();


        if($result){
        return $response->setPreviousUrl(route('flash-sale.index'))
                ->setMessage(trans('core/base::notices.delete_success_message'));
        }else{

        }
    }

    public  function saveProductPrice(Request $request , BaseHttpResponse $response)
    {
                $data = [
                    'category_id' => $request->categorie ,
                    'flash_sale_id' => $request->id,
                    'discount' => $request->discount
                ];
               $result =  DB::table('ec_flash_sale_products_category')->insert($data);
               if($result){
                return $response->setPreviousUrl(route('flash-sale.index'))
                        ->setMessage(trans('core/base::notices.create_success_message'));
               }
          
    }

    public  function updateProductPrice(Request $request , BaseHttpResponse $response)
    {
                $data = [
                    'category_id' => $request->categorie ,
                    'discount' => $request->discount
                ];
               $result =  DB::table('ec_flash_sale_products_category')->where('id' ,$request->id )->update($data);
               if($result){
                return $response->setPreviousUrl(route('flash-sale.index'))
                        ->setMessage(trans('core/base::notices.update_success_message'));
               }else{

               }
          
    }

    /**
     * @param FlashSaleRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function store(FlashSaleRequest $request, BaseHttpResponse $response)
    {
        $flashSale = $this->flashSaleRepository->createOrUpdate($request->input());

        event(new CreatedContentEvent(FLASH_SALE_MODULE_SCREEN_NAME, $request, $flashSale));

        $this->storeProducts($request, $flashSale);

        return $response
            ->setPreviousUrl(route('flash-sale.index'))
            ->setNextUrl(route('flash-sale.edit', $flashSale->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    /**
     * @param FlashSaleRequest $request
     * @param FlashSale $flashSale
     * @return int
     */
    protected function storeProducts(FlashSaleRequest $request, FlashSale $flashSale)
    {
        $products = array_filter(explode(',', $request->input('products')));

        $flashSale->products()->detach();

        // if(isset($request->categories)  && count($request->categories) > 0){
        //     foreach($request->categories as $item){
        //         // $categorie = new CustomerCategory();
        //         $flashSale->categories()->attach($item );

        //         // $categorie->category_id = $item;
        //         // $categorie->customer_id = $id;
        //         // $categorie->save();
        //     }
        // }

        foreach ($products as $index => $productId) {
            if (!(int)$productId) {
                continue;
            }

            $extra = Arr::get($request->input('products_extra', []), $index);

            if (!$extra || !isset($extra['price']) || !isset($extra['quantity'])) {
                continue;
            }

            $extra['price'] = (float)$extra['price'];
            $extra['quantity'] = (int)$extra['quantity'];

            if ($flashSale->products()->where('id', $productId)->count()) {
                $flashSale->products()->sync([(int)$productId => $extra]);
            } else {
                $flashSale->products()->attach($productId, $extra);
            }
        }

        return count($products);
    }

    /**
     * @param $id
     * @param Request $request
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function edit($id, FormBuilder $formBuilder, Request $request)
    {
        $flashSale = $this->flashSaleRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $flashSale));

        page_title()->setTitle(trans('plugins/ecommerce::flash-sale.edit') . ' "' . $flashSale->name . '"');
        return $formBuilder->create(FlashSaleForm::class, ['model' => $flashSale])->renderForm();
    }

    /**
     * @param int $id
     * @param FlashSaleRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function update($id, FlashSaleRequest $request, BaseHttpResponse $response)
    {
        /**
         * @var FlashSale
         */
        $flashSale = $this->flashSaleRepository->findOrFail($id);

        // if(isset($request->categories)  && count($request->categories) > 0){
        //     foreach($request->categories as $item){
        //         // $categorie = new CustomerCategory();
        //         $flashSale->categories()->attach($item );

        //         // $categorie->category_id = $item;
        //         // $categorie->customer_id = $id;
        //         // $categorie->save();
        //     }
        // }

        $flashSale->fill($request->input());

        $this->flashSaleRepository->createOrUpdate($flashSale);

        $this->storeProducts($request, $flashSale);

        event(new UpdatedContentEvent(FLASH_SALE_MODULE_SCREEN_NAME, $request, $flashSale));

        return $response
            ->setPreviousUrl(route('flash-sale.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    /**
     * @param $id
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function destroy(Request $request, $id, BaseHttpResponse $response)
    {
        try {
            $flashSale = $this->flashSaleRepository->findOrFail($id);

            $this->flashSaleRepository->delete($flashSale);

            event(new DeletedContentEvent(FLASH_SALE_MODULE_SCREEN_NAME, $request, $flashSale));

            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @throws Exception
     */
    public function deletes(Request $request, BaseHttpResponse $response)
    {
        $ids = $request->input('ids');
        if (empty($ids)) {
            return $response
                ->setError()
                ->setMessage(trans('core/base::notices.no_select'));
        }

        foreach ($ids as $id) {
            $flashSale = $this->flashSaleRepository->findOrFail($id);
            $this->flashSaleRepository->delete($flashSale);
            event(new DeletedContentEvent(FLASH_SALE_MODULE_SCREEN_NAME, $request, $flashSale));
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }
}
