<?php

namespace Botble\Ecommerce\Models;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;
use Botble\Base\Traits\EnumCastable;
use Botble\Ecommerce\Tables\CustomerTable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Html;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class CustomerCategory extends BaseModel
{
    use EnumCastable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ec_customer_categories';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'parent_id',
        'description',
        'order',
        'status',
        'image',
        'discount',

        'is_featured',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];

    /**
     * @return BelongsToMany
     */
    public function customers(): BelongsToMany
    {
        return $this
            ->belongsToMany(Customer::class, 'ec_customer_category_customer', 'category_id', 'customer_id');
    }

   
    /**
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(CustomerCategory::class, 'parent_id')->withDefault();
    }

    /**
     * @return Collection
     */
    public function getParentsAttribute(): Collection
    {
        $parents = collect([]);

        $parent = $this->parent;

        while ($parent->id) {
            $parents->push($parent);
            $parent = $parent->parent;
        }

        return $parents;
    }

    /**
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(CustomerCategory::class, 'parent_id');
    }

    /**
     * @return HasMany
     */
    public function activeChildren(): HasMany
    {
        return $this->children()->where('status', BaseStatusEnum::PUBLISHED);
    }

    /**
     * @param $category
     * @param array $childrenIds
     * @return array
     */
    public function getChildrenIds($category, array $childrenIds = []): array
    {
        $children = $category->children()->select('id')->get();

        foreach ($children as $child) {
            $childrenIds[] = $child->id;

            $childrenIds = array_merge($childrenIds, $this->getChildrenIds($child, $childrenIds));
        }

        return array_unique($childrenIds);
    }

    /**
     * @return \Illuminate\Support\HtmlString|string
     */
    public function getBadgeWithCountAttribute()
    {
        switch ($this->status->getValue()) {
            case BaseStatusEnum::DRAFT:
                $badge = 'bg-secondary';
                break;

            case BaseStatusEnum::PENDING:
                $badge = 'bg-warning';
                break;

            default:
                $badge = 'bg-success';
                break;
        }

        $link = route('customers.index', [
            'filter_table_id'  => strtolower(Str::slug(Str::snake(CustomerTable::class))),
            'class'            => Customer::class,
            'filter_columns'   => ['category'],
            'filter_operators' => ['='],
            'filter_values'    => [$this->id],
        ]);

        return Html::link($link, (string) $this->products_count, [ //need change
            'class'               => 'badge font-weight-bold ' . $badge,
            'data-bs-toggle'         => 'tooltip',
            'data-bs-original-title' => trans('plugins/ecommerce::customer-categories.total_customers', ['total' => $this->products_count]),
        ]);
    }

    protected static function boot()
    {
        parent::boot();

        self::deleting(function (CustomerCategory $category) {
            $category->customers()->detach();

            foreach ($category->children()->get() as $child) {
                $child->delete();
            }
        });
    }
}
