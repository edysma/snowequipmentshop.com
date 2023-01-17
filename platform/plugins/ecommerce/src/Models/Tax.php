<?php

namespace Botble\Ecommerce\Models;

use App\Models\TaxCountry;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;
use Botble\Base\Traits\EnumCastable;
use Botble\Location\Models\Country;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tax extends BaseModel
{
    use EnumCastable;

    /**
     * @var string
     */
    protected $table = 'ec_taxes';

    /**
     * @var array
     */
    protected $fillable = [
        'title',
        'percentage',
        'priority',
        'status',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];

    public function country_tax(): BelongsToMany
    {
        return $this
            ->belongsToMany(Country::class, 'tax_country', 'tax_id' , 'country_id')->using(TaxCountry::class)
            ->withPivot('tax_percentage');
    }
}
