<?php

namespace Botble\Ecommerce\Models;

use Botble\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DiscountCustomerCategory extends BaseModel
{
    /**
     * @var string
     */
    protected $table = 'ec_discount_customer_category';

    /**
     * @var array
     */
    protected $fillable = [
        'discount_id',
        'customer_category_id',
    ];

    /**
     * @return BelongsTo
     */
    public function customerscategory()
    {
        return $this->belongsTo(CustomerCategory::class, 'customer_category_id')->withDefault();
    }
}
