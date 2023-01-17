<?php
// namespace Botble\Ecommerce\Http\Controllers\Fronts;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Ecommerce\Models\Product;
use Botble\Ecommerce\Repositories\Interfaces\ProductCategoryInterface;
use Botble\Ecommerce\Repositories\Interfaces\ProductCollectionInterface;
use Botble\Ecommerce\Repositories\Interfaces\ProductInterface;
use Botble\Ecommerce\Repositories\Interfaces\ReviewInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

$params = array([
    'condition' => [
        'ec_products.status'       => BaseStatusEnum::PUBLISHED,
        'ec_products.is_variation' => 0,
        function ($query) {
            return $query->notOutOfStock();
        },
    ],
    'order_by'  => [
        'ec_products.order'      => 'ASC',
        'ec_products.created_at' => 'DESC',
    ],
    'take'      => null,
    'paginate'  => [
        'per_page'      => null,
        'current_paged' => 1,
    ],
    'select'    => [
        'ec_products.*',
    ],
    'with'      => ['slugable'],
    'withCount' => [],
    'withAvg'   => [],
]);


$products=app(ProductInterface::class)->getProducts($params);
print_r($products);
?>