<?php

namespace Botble\Ecommerce\Http\Controllers;

use Assets;
use Botble\Base\Events\BeforeEditContentEvent;
use Botble\Base\Forms\FormBuilder;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Ecommerce\Enums\ProductTypeEnum;
use Botble\Ecommerce\Forms\ProductForm;
use Botble\Ecommerce\Http\Requests\ProductRequest;
use Botble\Ecommerce\Repositories\Interfaces\GroupedProductInterface;
use Botble\Ecommerce\Repositories\Interfaces\ProductVariationInterface;
use Botble\Ecommerce\Repositories\Interfaces\ProductVariationItemInterface;
use Botble\Ecommerce\Services\Products\StoreAttributesOfProductService;
use Botble\Ecommerce\Services\Products\StoreProductService;
use Botble\Ecommerce\Services\StoreProductTagService;
use Botble\Ecommerce\Tables\ProductTable;
use Botble\Ecommerce\Traits\ProductActionsTrait;
use EcommerceHelper;
use Botble\Ecommerce\Models\ProductPrice;

use Illuminate\Support\Facades\DB as DB;

use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Throwable;

class ProductController extends BaseController
{
    use ProductActionsTrait;

    /**
     * @param ProductTable $dataTable
     * @return Factory|View
     * @throws Throwable
     */
    public function index(ProductTable $dataTable)
    {
        // dd($dataTable);
        page_title()->setTitle(trans('plugins/ecommerce::products.name'));

        Assets::addScripts(['bootstrap-editable'])
            ->addStyles(['bootstrap-editable']);

        return $dataTable->renderTable();
    }

    /**
     * @param FormBuilder $formBuilder
     * @param Request $request
     * @return string
     */
    public function create(FormBuilder $formBuilder, Request $request)
    {
        if (EcommerceHelper::isEnabledSupportDigitalProducts()) {
            if ($request->input('product_type') == ProductTypeEnum::DIGITAL) {
                page_title()->setTitle(trans('plugins/ecommerce::products.create_product_type.digital'));
            } else {
                page_title()->setTitle(trans('plugins/ecommerce::products.create_product_type.physical'));
            }
        } else {
            page_title()->setTitle(trans('plugins/ecommerce::products.create'));
        }

        return $formBuilder->create(ProductForm::class)->renderForm();
    }

    /**
     * @param int $id
     * @param Request $request
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function edit($id, Request $request, FormBuilder $formBuilder)
    {
        $product = $this->productRepository->findOrFail($id);

        if ($product->is_variation) {
            abort(404);
        }

        page_title()->setTitle(trans('plugins/ecommerce::products.edit', ['name' => $product->name]));

        event(new BeforeEditContentEvent($request, $product));

        return $formBuilder
            ->create(ProductForm::class, ['model' => $product])
            ->renderForm();
    }

    /**
     * @param ProductRequest $request
     * @param StoreProductService $service
     * @param BaseHttpResponse $response
     * @param ProductVariationInterface $variationRepository
     * @param ProductVariationItemInterface $productVariationItemRepository
     * @param GroupedProductInterface $groupedProductRepository
     * @param StoreAttributesOfProductService $storeAttributesOfProductService
     * @param StoreProductTagService $storeProductTagService
     * @return BaseHttpResponse
     * @throws Exception
     */
    public function store(
        ProductRequest $request,
        StoreProductService $service,
        BaseHttpResponse $response,
        ProductVariationInterface $variationRepository,
        ProductVariationItemInterface $productVariationItemRepository,
        GroupedProductInterface $groupedProductRepository,
        StoreAttributesOfProductService $storeAttributesOfProductService,
        StoreProductTagService $storeProductTagService
    ) {
        $product = $this->productRepository->getModel();
       
        $product->status = $request->input('status');
        if (EcommerceHelper::isEnabledSupportDigitalProducts() && $request->input('product_type')) {
            $product->product_type = $request->input('product_type');
        }

        $product = $service->execute($request, $product);

        
        if($request->input('product_price') != null && count($request->input('product_price')) > 0) {
            foreach($request->input('product_price') as $key => $product_price){
                $price  = [
                    'ec_products_id' => $product->id,
                    'countries_id' => $request->input('product_price_country')[$key],
                    'price' => $product_price,
                ];

                // $prod = new ProductPrice();

                $result = DB::table('ec_product_price')->where(['ec_products_id'=>$product->id , 'countries_id' => $request->input('product_price_country')[$key] ])->first();
                if(!$result){
                    DB::table('ec_product_price')->insert($price);
                }else{
                    $result->price = $product_price;
                    $result->save();
                }
            }
        }

        $storeProductTagService->execute($request, $product);

        $addedAttributes = $request->input('added_attributes', []);

        if ($request->input('is_added_attributes') == 1 && $addedAttributes) {
            $storeAttributesOfProductService->execute($product, array_keys($addedAttributes), array_values($addedAttributes));

            $variation = $variationRepository->create([
                'configurable_product_id' => $product->id,
            ]);

            foreach ($addedAttributes as $attribute) {
                $productVariationItemRepository->createOrUpdate([
                    'attribute_id' => $attribute,
                    'variation_id' => $variation->id,
                ]);
            }

            $variation = $variation->toArray();

            $variation['variation_default_id'] = $variation['id'];

            $variation['sku'] = $product->sku;
            $variation['auto_generate_sku'] = true;

            $variation['images'] = $request->input('images', []);

            $this->postSaveAllVersions([$variation['id'] => $variation], $variationRepository, $product->id, $response);
        }

        if ($request->has('grouped_products')) {
            $groupedProductRepository->createGroupedProducts($product->id, array_map(function ($item) {
                return [
                    'id'  => $item,
                    'qty' => 1,
                ];
            }, array_filter(explode(',', $request->input('grouped_products', '')))));
        }

        return $response
            ->setPreviousUrl(route('products.index'))
            ->setNextUrl(route('products.edit', $product->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    /**
     * @param int $id
     * @param ProductRequest $request
     * @param StoreProductService $service
     * @param GroupedProductInterface $groupedProductRepository
     * @param BaseHttpResponse $response
     * @param ProductVariationInterface $variationRepository
     * @param ProductVariationItemInterface $productVariationItemRepository
     * @param StoreProductTagService $storeProductTagService
     * @return BaseHttpResponse|JsonResponse|RedirectResponse
     */
    public function update(
        $id,
        ProductRequest $request,
        StoreProductService $service,
        GroupedProductInterface $groupedProductRepository,
        BaseHttpResponse $response,
        ProductVariationInterface $variationRepository,
        ProductVariationItemInterface $productVariationItemRepository,
        StoreProductTagService $storeProductTagService
    ) {
        $product = $this->productRepository->findOrFail($id);

        $product->status = $request->input('status');

        $product = $service->execute($request, $product);
        $storeProductTagService->execute($request, $product);

        if($request->input('product_price') != null && count($request->input('product_price')) > 0) {
            foreach($request->input('product_price') as $key => $product_price){
                $price  = [
                    'ec_products_id' => $product->id,
                    'countries_id' => $request->input('product_price_country')[$key],
                    'price' => $product_price,
                ];

                $result = DB::table('ec_product_price')->where(['ec_products_id'=>$product->id , 'countries_id' => $request->input('product_price_country')[$key] ])->first();
                if(!$result){
                    DB::table('ec_product_price')->insert($price);
                }else{
                    $result->price = $product_price;
                    $result->save();
                }
            }
        }

        $variationRepository
            ->getModel()
            ->where('configurable_product_id', $product->id)
            ->update(['is_default' => 0]);

        $defaultVariation = $variationRepository->findById($request->input('variation_default_id'));
        if ($defaultVariation) {
            $defaultVariation->is_default = true;
            $defaultVariation->save();
        }

        $addedAttributes = $request->input('added_attributes', []);

        if ($request->input('is_added_attributes') == 1 && $addedAttributes) {
            $result = $variationRepository->getVariationByAttributesOrCreate($id, $addedAttributes);

            /**
             * @var Collection $variation
             */
            $variation = $result['variation'];

            foreach ($addedAttributes as $attribute) {
                $productVariationItemRepository->createOrUpdate([
                    'attribute_id' => $attribute,
                    'variation_id' => $variation->id,
                ]);
            }

            $variation = $variation->toArray();
            $variation['variation_default_id'] = $variation['id'];

            $product->productAttributeSets()->sync(array_keys($addedAttributes));

            $variation['sku'] = $product->sku;
            $variation['auto_generate_sku'] = true;

            $this->postSaveAllVersions([$variation['id'] => $variation], $variationRepository, $product->id, $response);
        } elseif ($product->variations()->count() === 0) {
            $product->productAttributeSets()->detach();
        }

        if ($request->has('grouped_products')) {
            $groupedProductRepository->createGroupedProducts($product->id, array_map(function ($item) {
                return [
                    'id'  => $item,
                    'qty' => 1,
                ];
            }, array_filter(explode(',', $request->input('grouped_products', '')))));
        }

        $relatedProductIds = $product->variations()->pluck('product_id')->all();

        $this->productRepository->update([['id', 'IN', $relatedProductIds]], ['status' => $product->status]);

        return $response
            ->setPreviousUrl(route('products.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }
	
   /**
     * @param FormBuilder $formBuilder
     * @param Request $request
     * @return string
     */
    public function duplicate(Request $request)
    {
        $product = $this->productRepository->findOrFail($request->id);
		
        $duplicatedProduct = new \Botble\Ecommerce\Models\Product;
        $duplicatedProduct->name = "Copy Of " . $product->name;
        $duplicatedProduct->description = $product->description;
        $duplicatedProduct->content = $product->content;
        $duplicatedProduct->status = $product->status;


        $duplicatedProduct->sku = $product->sku ." - 1";
        $duplicatedProduct->order = $product->order;
        $duplicatedProduct->quantity = $product->quantity; 

        $duplicatedProduct->allow_checkout_when_out_of_stock = $product->allow_checkout_when_out_of_stock;
        $duplicatedProduct->with_storehouse_management = $product->with_storehouse_management;
        $duplicatedProduct->is_featured = $product->is_featured;
        $duplicatedProduct->brand_id = $product->brand_id;
        $duplicatedProduct->is_variation = $product->is_variation;
        $duplicatedProduct->sale_type = $product->sale_type;
        $duplicatedProduct->price = $product->price;
        $duplicatedProduct->sale_price = $product->sale_price; 
        $duplicatedProduct->start_date = $product->start_date; 
        $duplicatedProduct->end_date = $product->end_date; 
        $duplicatedProduct->length = $product->length; 
        $duplicatedProduct->wide = $product->wide; 
        $duplicatedProduct->height = $product->height; 
        $duplicatedProduct->weight = $product->weight; 
        $duplicatedProduct->tax_id = $product->tax_id;
        $duplicatedProduct->views = $product->views;
        //$duplicatedProduct->created_at = date('Y-m-d H:i:s');
        //$duplicatedProduct->updated_at = date('Y-m-d H:i:s');
        $duplicatedProduct->stock_status = $product->stock_status;
        $duplicatedProduct->created_by_id = $product->created_by_id;
        $duplicatedProduct->created_by_type = $product->created_by_type;
        $duplicatedProduct->image = $product->image;
        $duplicatedProduct->product_type = $product->product_type;
        $duplicatedProduct->store_id = $product->store_id;
        $duplicatedProduct->file_path = $product->file_path;
        $duplicatedProduct->btn_text = $product->btn_text;
        $duplicatedProduct->readmore = $product->readmore;
        $duplicatedProduct->approved_by = $product->approved_by;
        $duplicatedProduct->ean = $product->ean;
        $duplicatedProduct->btn_text_one = $product->btn_text_one; 
        $duplicatedProduct->btn_text_two = $product->btn_text_two;

        $duplicatedProduct->images = json_encode($product->images);
		$duplicatedProduct->save();
		
		$country_prices = DB::table('ec_product_price')->where(['ec_products_id'=>$request->id])->get();
		foreach($country_prices as $key => $country_price){
			$price  = [
				'ec_products_id' => $duplicatedProduct->id,
				'countries_id' => $country_price->countries_id,
				'price' => $country_price->price,
			];
			DB::table('ec_product_price')->insert($price);
		}
		
        return redirect('amministrazione/ecommerce/products/edit/'.$duplicatedProduct->id);
    }
}
