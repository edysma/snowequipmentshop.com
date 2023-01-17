<?php

namespace Botble\Ecommerce\Models;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;
use Botble\Base\Traits\EnumCastable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class FlashSaleProductPrice extends BaseModel
{
    use EnumCastable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ec_flash_sale_products_category';

    /**
     * @var array
     */
    protected $fillable = [
        'category_id',
        'flash_sale_id',
        'discount',

    ];

    /**
     * @var array
     */
    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];

    /**
     * @var string[]
     */
   

    /**
     * @return BelongsToMany
     */
   

    protected static function boot()
    {
        parent::boot();

        static::deleting(function (FlashSale $flashSale) {
            // $flashSale->products()->detach();
        });
    }
}
