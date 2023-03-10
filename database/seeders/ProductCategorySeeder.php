<?php

namespace Database\Seeders;

use Botble\Base\Models\MetaBox as MetaBoxModel;
use Botble\Base\Supports\BaseSeeder;
use Botble\Ecommerce\Models\ProductCategory;
use Botble\Slug\Models\Slug;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use MetaBox;
use SlugHelper;

class ProductCategorySeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->uploadFiles('product-categories');

        $categories = [
            [
                'name'        => 'Fruits & Vegetables',
                'is_featured' => true,
                'image'       => 'product-categories/1.png',
                'icon'        => 'icon-star',
                'children'    => [
                    [
                        'name'     => 'Fruits',
                        'children' => [
                            ['name' => 'Apples'],
                            ['name' => 'Bananas'],
                            ['name' => 'Berries'],
                            ['name' => 'Oranges & Easy Peelers'],
                            ['name' => 'Grapes'],
                            ['name' => 'Lemons & Limes'],
                            ['name' => 'Peaches & Nectarines'],
                            ['name' => 'Pears'],
                            ['name' => 'Melon'],
                            ['name' => 'Avocados'],
                            ['name' => 'Plums & Apricots'],
                        ],
                    ],
                    [
                        'name'     => 'Vegetables',
                        'children' => [
                            ['name' => 'Potatoes'],
                            ['name' => 'Carrots & Root Vegetables'],
                            ['name' => 'Broccoli & Cauliflower'],
                            ['name' => 'Cabbage, Spinach & Greens'],
                            ['name' => 'Onions, Leeks & Garlic'],
                            ['name' => 'Mushrooms'],
                            ['name' => 'Tomatoes'],
                            ['name' => 'Beans, Peas & Sweetcorn'],
                            ['name' => 'Freshly Drink Orange Juice'],
                        ],
                    ],
                ],
            ],
            [
                'name'        => 'Breads Sweets',
                'is_featured' => true,
                'image'       => 'product-categories/2.png',
                'icon'        => 'icon-bread',
                'children'    => [
                    [
                        'name'     => 'Crisps, Snacks & Nuts',
                        'children' => [
                            ['name' => 'Crisps & Popcorn'],
                            ['name' => 'Nuts & Seeds'],
                            ['name' => 'Lighter Options'],
                            ['name' => 'Cereal Bars'],
                            ['name' => 'Breadsticks & Pretzels'],
                            ['name' => 'Fruit Snacking'],
                            ['name' => 'Rice & Corn Cakes'],
                            ['name' => 'Protein & Energy Snacks'],
                            ['name' => 'Toddler Snacks'],
                            ['name' => 'Meat Snacks'],
                            ['name' => 'Beans'],
                            ['name' => 'Lentils'],
                            ['name' => 'Chickpeas'],
                        ],
                    ],
                    [
                        'name'     => 'Tins & Cans',
                        'children' => [
                            ['name' => 'Tomatoes'],
                            ['name' => 'Baked Beans, Spaghetti'],
                            ['name' => 'Fish'],
                            ['name' => 'Beans & Pulses'],
                            ['name' => 'Fruit'],
                            ['name' => 'Coconut Milk & Cream'],
                            ['name' => 'Lighter Options'],
                            ['name' => 'Olives'],
                            ['name' => 'Sweetcorn'],
                            ['name' => 'Carrots'],
                            ['name' => 'Peas'],
                            ['name' => 'Mixed Vegetables'],
                        ],
                    ],
                ],
            ],
            [
                'name'        => 'Frozen Seafoods',
                'is_featured' => true,
                'image'       => 'product-categories/3.png',
                'icon'        => 'icon-hamburger',
            ],
            [
                'name'        => 'Raw Meats',
                'is_featured' => true,
                'image'       => 'product-categories/4.png',
                'icon'        => 'icon-steak',
            ],
            [
                'name'        => 'Wines & Alcohol Drinks',
                'is_featured' => true,
                'image'       => 'product-categories/5.png',
                'icon'        => 'icon-glass',
                'children'    => [
                    [
                        'name'     => 'Ready Meals',
                        'children' => [
                            ['name' => 'Meals for 1'],
                            ['name' => 'Meals for 2'],
                            ['name' => 'Indian'],
                            ['name' => 'Italian'],
                            ['name' => 'Chinese'],
                            ['name' => 'Traditional British'],
                            ['name' => 'Thai & Oriental'],
                            ['name' => 'Mediterranean & Moroccan'],
                            ['name' => 'Mexican & Caribbean'],
                            ['name' => 'Lighter Meals'],
                            ['name' => 'Lunch & Veg Pots'],
                        ],
                    ],
                    [
                        'name'     => 'Salad & Herbs',
                        'children' => [
                            ['name' => 'Salad Bags'],
                            ['name' => 'Cucumber'],
                            ['name' => 'Tomatoes'],
                            ['name' => 'Lettuce'],
                            ['name' => 'Lunch Salad Bowls'],
                            ['name' => 'Lunch Salad Bowls'],
                            ['name' => 'Fresh Herbs'],
                            ['name' => 'Avocados'],
                            ['name' => 'Peppers'],
                            ['name' => 'Coleslaw & Potato Salad'],
                            ['name' => 'Spring Onions'],
                            ['name' => 'Chilli, Ginger & Garlic'],
                        ],
                    ],
                ],
            ],
            [
                'name'        => 'Tea & Coffee',
                'is_featured' => true,
                'image'       => 'product-categories/6.png',
                'icon'        => 'icon-teacup',
            ],
            [
                'name'        => 'Milks and Dairies',
                'is_featured' => true,
                'image'       => 'product-categories/7.png',
                'icon'        => 'icon-coffee-cup',
            ],
            [
                'name'        => 'Pet Foods',
                'is_featured' => true,
                'image'       => 'product-categories/8.png',
                'icon'        => 'icon-hotdog',
            ],
            [
                'name'        => 'Food Cupboard',
                'is_featured' => true,
                'image'       => 'product-categories/1.png',
                'icon'        => 'icon-cheese',

            ],
        ];

        ProductCategory::truncate();
        Slug::where('reference_type', ProductCategory::class)->delete();
        MetaBoxModel::where('reference_type', ProductCategory::class)->delete();

        foreach ($categories as $index => $item) {
            $this->createCategoryItem($index, $item);
        }

        // Translations
        DB::table('ec_product_categories_translations')->truncate();

        $translations = [
            [
                'name'     => 'Rau c??? qu???',
                'children' => [
                    [
                        'name'     => 'Tr??i c??y',
                        'children' => [
                            ['name' => 'T??o'],
                            ['name' => 'Chu???i'],
                            ['name' => 'Qu??? M???ng'],
                            ['name' => 'Cam'],
                            ['name' => 'Nho'],
                            ['name' => 'Chanh'],
                            ['name' => 'Qu??? ????o'],
                            ['name' => 'L??'],
                            ['name' => 'D??a Gang'],
                            ['name' => 'B??'],
                            ['name' => 'M???n & M??'],
                        ],
                    ],
                    [
                        'name'     => 'Rau',
                        'children' => [
                            ['name' => 'Khoai T??y'],
                            ['name' => 'C?? r???t'],
                            ['name' => 'B??ng c???i xanh & s??p l?? tr???ng'],
                            ['name' => 'B???p c???i, rau bina & rau xanh'],
                            ['name' => 'H??nh t??y, t???i t??y'],
                            ['name' => 'N???m'],
                            ['name' => 'C?? chua'],
                            ['name' => '?????u, ?????u H?? Lan & B???p rang b??'],
                            ['name' => 'N?????c u???ng t????i'],
                        ],
                    ],
                ],
            ],
            [
                'name'     => 'B??nh m?? k???o',
                'children' => [
                    [
                        'name'     => 'Crisps, Snack & Nuts',
                        'children' => [
                            ['name' => 'Khoai t??y chi??n gi??n & b???ng ng??'],
                            ['name' => 'Nuts & Seeds'],
                            ['name' => 'Lighter Options'],
                            ['name' => 'Cereal Bars'],
                            ['name' => 'B??nh m?? que & Pretzels'],
                            ['name' => 'Fruit Snacking'],
                            ['name' => 'B??nh g???o'],
                            ['name' => 'Protein & Energy Snacks'],
                            ['name' => 'Toddler Snacks'],
                            ['name' => 'Meat Snacks'],
                            ['name' => '?????u'],
                            ['name' => 'Lentils'],
                            ['name' => 'Chickpeas'],
                        ],
                    ],
                    [
                        'name'     => 'Tins & Cans',
                        'children' => [
                            ['name' => 'Khoai t??y'],
                            ['name' => 'Baked Beans, Spaghetti'],
                            ['name' => 'C??'],
                            ['name' => '?????u & Pulses'],
                            ['name' => 'Tr??i c??y'],
                            ['name' => 'Coconut Milk & Cream'],
                            ['name' => 'Lighter Options'],
                            ['name' => 'Olives'],
                            ['name' => 'Sweetcorn'],
                            ['name' => 'C?? r???t'],
                            ['name' => '?????u H?? Lan'],
                            ['name' => 'Mixed Vegetables'],
                        ],
                    ],
                ],
            ],
            ['name' => 'H???i s???n ????ng l???nh'],
            ['name' => 'Th???t s???ng'],
            [
                'name'     => 'R?????u & ????? u???ng c?? c???n',
                'children' => [
                    [
                        'name'     => 'Ready Meals',
                        'children' => [
                            ['name' => 'Meals for 1'],
                            ['name' => 'Meals for 2'],
                            ['name' => 'Indian'],
                            ['name' => 'Italian'],
                            ['name' => 'Chinese'],
                            ['name' => 'Traditional British'],
                            ['name' => 'Thai & Oriental'],
                            ['name' => 'Mediterranean & Moroccan'],
                            ['name' => 'Mexican & Caribbean'],
                            ['name' => 'Lighter Meals'],
                            ['name' => 'Lunch & Veg Pots'],
                        ],
                    ],
                    [
                        'name'     => 'Salad & th???o m???c',
                        'children' => [
                            ['name' => 'T??i ?????ng salad'],
                            ['name' => 'Qu??? d??a chu???t'],
                            ['name' => 'C?? chua'],
                            ['name' => 'Rau x?? l??ch'],
                            ['name' => 'Lunch Salad Bowls'],
                            ['name' => 'Fresh Herbs'],
                            ['name' => 'Avocados'],
                            ['name' => 'Peppers'],
                            ['name' => 'Coleslaw & Potato Salad'],
                            ['name' => 'Spring Onions'],
                            ['name' => 'Chilli, Ginger & Garlic'],
                        ],
                    ],
                ],
            ],
            ['name' => 'Tr?? & C?? ph??'],
            ['name' => 'S???a v?? c??c lo???i s???a'],
            ['name' => 'Th???c ??n cho th?? c??ng'],
            ['name' => 'T??? ?????ng th???c ??n'],
        ];

        $count = 1;
        foreach ($translations as $translation) {
            $this->createCategoryItemTrans($count, $translation);
        }
    }

    /**
     * @param int $index
     * @param array $category
     * @param int $parentId
     */
    protected function createCategoryItem(int $index, array $category, int $parentId = 0): void
    {
        $category['parent_id'] = $parentId;
        $category['order'] = $index;

        if (Arr::has($category, 'children')) {
            $children = $category['children'];
            unset($category['children']);
        } else {
            $children = [];
        }

        $createdCategory = ProductCategory::create(Arr::except($category, ['icon']));

        Slug::create([
            'reference_type' => ProductCategory::class,
            'reference_id'   => $createdCategory->id,
            'key'            => Str::slug($createdCategory->name),
            'prefix'         => SlugHelper::getPrefix(ProductCategory::class),
        ]);

        if (isset($category['icon'])) {
            MetaBox::saveMetaBoxData($createdCategory, 'icon', $category['icon']);
        }

        if ($children) {
            foreach ($children as $childIndex => $child) {
                $this->createCategoryItem($childIndex, $child, $createdCategory->id);
            }
        }
    }

    /**
     * @param int $count
     * @param array $translation
     * @return void
     */
    protected function createCategoryItemTrans(int &$count, array $translation): void
    {
        $translation['lang_code'] = 'vi';
        $translation['ec_product_categories_id'] = $count;

        DB::table('ec_product_categories_translations')->insert(Arr::except($translation, ['children']));

        $count++;

        if (Arr::get($translation, 'children')) {
            foreach ($translation['children'] as $child) {
                $this->createCategoryItemTrans($count, $child);
            }
        }
    }
}
