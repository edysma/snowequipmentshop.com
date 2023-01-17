<?php

namespace Botble\Ecommerce\Models;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;
use Botble\Base\Traits\EnumCastable;
use Botble\Location\Models\Country;
use RvMedia;

class ProductPrice extends BaseModel
{
    use EnumCastable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ec_product_price';

    /**
     * @var array
     */
    protected $fillable = [
        'ec_products_id',
        'countries_id',
        'price',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

     public function country()
     {
        return $this->belongsTo(Country::class,'countries_id');
     }

}
