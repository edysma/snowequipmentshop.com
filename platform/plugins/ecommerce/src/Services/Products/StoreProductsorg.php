<?php

namespace Botble\Ecommerce\Services\Products;

use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Ecommerce\Enums\ProductTypeEnum;
use Botble\Ecommerce\Models\Product;
use Botble\Ecommerce\Repositories\Eloquent\ProductRepository;
use Botble\Ecommerce\Repositories\Interfaces\ProductInterface;
use Botble\Media\Repositories\Interfaces\MediaFileInterface;
use Botble\Media\Services\UploadsManager;
use EcommerceHelper;
use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use Storage;

class StoreProductService
{
    /**
     * @var ProductRepository
     */
    protected $productRepository;

    /**
     * StoreProductService constructor.
     * @param ProductInterface $product
     */
    public function __construct(ProductInterface $product)
    {
        $this->productRepository = $product;
    }

    /**
     * @param Request $request
     * @param Product $product
     * @param bool $forceUpdateAll
     * @return Product
     */
    public function execute(Request $request, Product $product, bool $forceUpdateAll = false): Product
    {
        
        $data = $request->input();
        // print_r($request);
        // print_r($product);
        
        $hasVariation = $product->variations()->count() > 0;

        if ($hasVariation && !$forceUpdateAll) {
            $data = $request->except([
                'sku',
                'quantity',
                'allow_checkout_when_out_of_stock',
                'with_storehouse_management',
                'stock_status',
                'sale_type',
                'price',
                'sale_price',
                'start_date',
                'end_date',
                'length',
                'wide',
                'height',
                'weight',
            ]);
        }
       
        $product->fill($data);

        $images = [];

        if ($request->input('images', [])) {
            $images = array_values(array_filter($request->input('images', [])));
        }

        $product->images = json_encode($images);

        if (!$hasVariation || $forceUpdateAll) {
            if ($product->sale_price > $product->price) {
                $product->sale_price = null;
            }

            if ($product->sale_type == 0) {
                $product->start_date = null;
                $product->end_date = null;
            }
        }

        $exists = $product->id;

        if (!$exists && EcommerceHelper::isEnabledCustomerRecentlyViewedProducts() && $request->input('product_type')) {
            if (in_array($request->input('product_type'), ProductTypeEnum::values())) {
                $product->product_type = $request->input('product_type');
            }
        }

        /**
         * @var Product $product
         */
        $product = $this->productRepository->createOrUpdate($product);

        if (!$exists) {
            event(new CreatedContentEvent(PRODUCT_MODULE_SCREEN_NAME, $request, $product));
        } else {
            event(new UpdatedContentEvent(PRODUCT_MODULE_SCREEN_NAME, $request, $product));
        }

        if ($product) {
            $product->categories()->sync($request->input('categories', []));

            $product->productCollections()->sync($request->input('product_collections', []));

            $product->productLabels()->sync($request->input('product_labels', []));

            if ($request->has('related_products')) {
                $product->products()->detach();
                $product->products()->attach(array_filter(explode(',', $request->input('related_products', ''))));
            }

            if ($request->has('cross_sale_products')) {
                $product->crossSales()->detach();
                $product->crossSales()->attach(array_filter(explode(',', $request->input('cross_sale_products', ''))));
            }

            if ($request->has('up_sale_products')) {
                $product->upSales()->detach();
                $product->upSales()->attach(array_filter(explode(',', $request->input('up_sale_products', ''))));
            }
            if ($request->has('video')) {
                $this->saveProductvideo($request, $product);
            }
            if ($request->has('product_file_pdf')) {
                $this->saveProductproduct_files_pdf($request, $product);
            }
            if (EcommerceHelper::isEnabledSupportDigitalProducts() && $product->isTypeDigital()) {
                $this->saveProductFiles($request, $product);
                
            }

            if ($request->has('options')) {
                $this->productRepository->saveProductOptions($request->get('options'), $product);
            }
        }

        return $product;
    }

    /**
     * @param Request $request
     * @param Product $product
     * @param bool $exists
     * @return Product
     */
    public function saveProductFiles(Request $request, Product $product, $exists = true)
    {
        if ($exists) {
            foreach ($request->input('product_files', []) as $key => $value) {
                if (!$value) {
                    $product->productFiles()->where('id', $key)->delete();
                }
            }
        }

        if ($request->hasFile('product_files_input')) {

            foreach ($request->file('product_files_input', []) as $file) {
                try {
                    $data = $this->saveProductFile($file);
                    $product->productFiles()->create($data);
                } catch (Exception $ex) {
                    info($ex);
                }
            }
        }

        return $product;
    }

    /**
     * @param Request $request
     * @param Product $product
     * @param bool $exists
     * @return Product
     */
    public function saveProductproduct_files_pdf(Request $request, Product $product, $exists = true)
    {
        if ($exists) {
            foreach ($request->input('product_file_pdf', []) as $key => $value) {
                if (!$value) {
                    $product->productFiles()->where('product_id', $key)->delete();
                }
            }
        }

        if ($request->hasFile('product_file_pdf')) {

            foreach ($request->file('product_file_pdf', []) as $file) {
                try {
                    $data = $this->saveProductproduct_files_pdf($file);
                    $product->productFiles()->create($data);
                    echo $product;
                } catch (Exception $ex) {
                    info($ex);
                }
            }
        }

        return $product;
    }
    /**
     * @param Request $request
     * @param Product $product
     * @param bool $exists
     * @return Product
     */
    public function saveProductvideo(Request $request, Product $product, $exists = true)
    {
        if ($exists) {
            foreach (explode('|',$request->input('video')) as $key => $value) {
                if (!empty($value)) {
                    $product->productFiles()->where('product_id', $product->id)->delete();
                }
            }
        }

        if ($request->has('video')) {
            
            $vid=[];
            $i=1;
            foreach(explode('|', $request->input('video', '')) as $val){
                try {
                    $vid['url']=$val;
                    $vid['extras']='video'.$i;
                    $product->productFiles()->create($vid);
                    $i++;
                } catch (Exception $ex) {
                    info($ex);
                }
            }
        }

        return $product;
    }

    // public function pdf(Request $request){
    //     $fileName = null;

    //     Product::create([
    //         'product_file_pdf' => $fileName,
    //     ]);
    //     if (request()->hasFile('product_file_pdf')) 
    //     {
    //         $file = request()->file('product_file_pdf');
    //         $fileName = md5($file->getClientOriginalName()) . time() . '.' . $file->getClientOriginalExtension();
    //         $file->move('./uploads', $fileName);
    //     }
    //     return redirect()->back()->with('success', 'File uploaded successfully.');
    // }

    /**
     * @param mixed $file
     * @return array
     * @throws FileNotFoundException
     */
    public function saveProductFile($file): array
    {
        $folderPath = 'product-files';
        $fileExtension = $file->getClientOriginalExtension();
        $content = File::get($file->getRealPath());
        $name = File::name($file->getClientOriginalName());
        $fileName = app(MediaFileInterface::class)->createSlug(
            $name,
            $fileExtension,
            Storage::path($folderPath)
        );

        $filePath = $folderPath . '/' . $fileName;
        app(UploadsManager::class)->saveFile($filePath, $content, $file);
        $data = app(UploadsManager::class)->fileDetails($filePath);
        $data['name'] = $name;
        $data['extension'] = $fileExtension;

        return [
            'url'    => $filePath,
            'extras' => $data,
        ];
    }
}
