<?php

namespace Database\Seeders;

use Botble\ACL\Models\User;
use Botble\Base\Models\MetaBox as MetaBoxModel;
use Botble\Base\Supports\BaseSeeder;
use Botble\Blog\Models\Category;
use Botble\Blog\Models\CategoryTranslation;
use Botble\Blog\Models\Post;
use Botble\Blog\Models\PostTranslation;
use Botble\Blog\Models\Tag;
use Botble\Blog\Models\TagTranslation;
use Botble\Language\Models\LanguageMeta;
use Botble\Slug\Models\Slug;
use Faker\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use MetaBox;
use SlugHelper;

class BlogSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->uploadFiles('news');

        Post::truncate();
        Category::truncate();
        Tag::truncate();
        PostTranslation::truncate();
        CategoryTranslation::truncate();
        TagTranslation::truncate();
        Slug::where('reference_type', Post::class)->delete();
        Slug::where('reference_type', Tag::class)->delete();
        Slug::where('reference_type', Category::class)->delete();
        MetaBoxModel::where('reference_type', Post::class)->delete();
        MetaBoxModel::where('reference_type', Tag::class)->delete();
        MetaBoxModel::where('reference_type', Category::class)->delete();
        LanguageMeta::where('reference_type', Post::class)->delete();
        LanguageMeta::where('reference_type', Tag::class)->delete();
        LanguageMeta::where('reference_type', Category::class)->delete();

        $faker = Factory::create();

        $categories = [
            [
                'name'       => 'Ecommerce',
                'is_default' => true,
            ],
            [
                'name' => 'Fashion',
            ],
            [
                'name' => 'Electronic',
            ],
            [
                'name' => 'Commercial',
            ],
        ];

        foreach ($categories as $index => $item) {
            $category = $this->createCategory(Arr::except($item, 'children'), 0, $index != 0);

            if (isset($item['children']) && !empty($item['children'])) {
                foreach ($item['children'] as $child) {
                    $this->createCategory($child, $category->id);
                }
            }
        }

        $tags = [
            [
                'name' => 'General',
            ],
            [
                'name' => 'Design',
            ],
            [
                'name' => 'Fashion',
            ],
            [
                'name' => 'Branding',
            ],
            [
                'name' => 'Modern',
            ],
        ];

        foreach ($tags as $item) {
            $item['author_id'] = 1;
            $item['author_type'] = User::class;
            $tag = Tag::create($item);

            Slug::create([
                'reference_type' => Tag::class,
                'reference_id'   => $tag->id,
                'key'            => Str::slug($tag->name),
                'prefix'         => SlugHelper::getPrefix(Tag::class),
            ]);
        }

        $posts = [
            [
                'name'   => '4 Expert Tips On How To Choose The Right Men???s Wallet',
            ],
            [
                'name'   => 'Sexy Clutches: How to Buy & Wear a Designer Clutch Bag',
            ],
            [
                'name'   => 'The Top 2020 Handbag Trends to Know',
            ],
            [
                'name'   => 'How to Match the Color of Your Handbag With an Outfit',
            ],
            [
                'name' => 'How to Care for Leather Bags',
            ],
            [
                'name' => "We're Crushing Hard on Summer's 10 Biggest Bag Trends",
            ],
            [
                'name' => 'Essential Qualities of Highly Successful Music',
            ],
            [
                'name' => '9 Things I Love About Shaving My Head',
            ],
            [
                'name' => 'Why Teamwork Really Makes The Dream Work',
            ],
            [
                'name' => 'The World Caters to Average People',
            ],
            [
                'name' => 'The litigants on the screen are not actors',
            ],
        ];

        foreach ($posts as $index => $item) {
            $item['content'] = '<p>I have seen many people underestimating the power of their wallets. To them, they are just a functional item they use to carry. As a result, they often end up with the wallets which are not really suitable for them.</p>

<p>You should pay more attention when you choose your wallets. There are a lot of them on the market with the different designs and styles. When you choose carefully, you would be able to buy a wallet that is catered to your needs. Not to mention that it will help to enhance your style significantly.</p>

<p style="text-align:center"><img alt="f4" src="/storage/news/1.jpg" /></p>

<p><br />
&nbsp;</p>

<p><strong><em>For all of the reason above, here are 7 expert tips to help you pick up the right men&rsquo;s wallet for you:</em></strong></p>

<h4><strong>Number 1: Choose A Neat Wallet</strong></h4>

<p>The wallet is an essential accessory that you should go simple. Simplicity is the best in this case. A simple and neat wallet with the plain color and even&nbsp;<strong>minimalist style</strong>&nbsp;is versatile. It can be used for both formal and casual events. In addition, that wallet will go well with most of the clothes in your wardrobe.</p>

<p>Keep in mind that a wallet will tell other people about your personality and your fashion sense as much as other clothes you put on. Hence, don&rsquo;t go cheesy on your wallet or else people will think that you have a funny and particular style.</p>

<p style="text-align:center"><img alt="f5" src="/storage/news/2.jpg" /></p>

<p><br />
&nbsp;</p>
<hr />
<h4><strong>Number 2: Choose The Right Size For Your Wallet</strong></h4>

<p>You should avoid having an over-sized wallet. Don&rsquo;t think that you need to buy a big wallet because you have a lot to carry with you. In addition, a fat wallet is very ugly. It will make it harder for you to slide the wallet into your trousers&rsquo; pocket. In addition, it will create a bulge and ruin your look.</p>

<p>Before you go on to buy a new wallet, clean out your wallet and place all the items from your wallet on a table. Throw away things that you would never need any more such as the old bills or the expired gift cards. Remember to check your wallet on a frequent basis to get rid of all of the old stuff that you don&rsquo;t need anymore.</p>

<p style="text-align:center"><img alt="f1" src="/storage/news/3.jpg" /></p>

<p><br />
&nbsp;</p>

<hr />
<h4><strong>Number 3: Don&rsquo;t Limit Your Options Of Materials</strong></h4>

<p>The types and designs of wallets are not the only things that you should consider when you go out searching for your best wallet. You have more than 1 option of material rather than leather to choose from as well.</p>

<p>You can experiment with other available options such as cotton, polyester and canvas. They all have their own pros and cons. As a result, they will be suitable for different needs and requirements. You should think about them all in order to choose the material which you would like the most.</p>

<p style="text-align:center"><img alt="f6" src="/storage/news/4.jpg" /></p>

<p><br />
&nbsp;</p>

<hr />
<h4><strong>Number 4: Consider A Wallet As A Long Term Investment</strong></h4>

<p>Your wallet is indeed an investment that you should consider spending a decent amount of time and effort on it. Another factor that you need to consider is how much you want to spend on your wallet. The price ranges of wallets on the market vary a great deal. You can find a wallet which is as cheap as about 5 to 7 dollars. On the other hand, you should expect to pay around 250 to 300 dollars for a high-quality wallet.</p>

<p>In case you need a wallet to use for a long time, it is a good idea that you should invest a decent amount of money on a wallet. A high quality wallet from a reputational brand with the premium quality such as cowhide leather will last for a long time. In addition, it is an accessory to show off your fashion sense and your social status.</p>

<p style="text-align:center"><img alt="f2" src="/storage/news/5.jpg" /></p>

<p>&nbsp;</p>
';

            $item['author_id'] = 1;
            $item['author_type'] = User::class;
            $item['views'] = $faker->numberBetween(100, 2500);
            $item['is_featured'] = $index < 10;
            $item['image'] = 'news/' . ($index + 1) . '.jpg';
            $item['description'] = 'You should pay more attention when you choose your wallets. There are a lot of them on the market with the different designs and styles. When you choose carefully, you would be able to buy a wallet that is catered to your needs. Not to mention that it will help to enhance your style significantly.';
            $item['content'] = str_replace(url(''), '', $item['content']);

            $post = Post::create(Arr::except($item, ['layout']));

            $layout = $item['layout'] ?? null;
            if ($layout) {
                MetaBox::saveMetaBoxData($post, 'layout', $layout);
            }

            $post->categories()->sync([
                $faker->numberBetween(1, 2),
                $faker->numberBetween(3, 4),
            ]);

            $post->tags()->sync([1, 2, 3, 4, 5]);

            Slug::create([
                'reference_type' => Post::class,
                'reference_id'   => $post->id,
                'key'            => Str::slug($post->name),
                'prefix'         => SlugHelper::getPrefix(Post::class),
            ]);
        }

        $translations = [
            [
                'name' => 'Th????ng m???i ??i???n t???',
            ],
            [
                'name' => 'Th???i trang',
            ],
            [
                'name' => '??i???n t???',
            ],
            [
                'name' => 'Th????ng m???i',
            ],
        ];

        foreach ($translations as $index => $item) {
            $item['lang_code'] = 'vi';
            $item['categories_id'] = $index + 1;

            CategoryTranslation::insert($item);
        }

        $translations = [
            [
                'name' => 'Chung',
            ],
            [
                'name' => 'Thi???t k???',
            ],
            [
                'name' => 'Th???i trang',
            ],
            [
                'name' => 'Th????ng hi???u',
            ],
            [
                'name' => 'Hi???n ?????i',
            ],
        ];

        foreach ($translations as $index => $item) {
            $item['lang_code'] = 'vi';
            $item['tags_id'] = $index + 1;

            TagTranslation::insert($item);
        }

        $translations = [
            [
                'name' => '4 L???i khuy??n c???a Chuy??n gia v??? C??ch Ch???n V?? Nam Ph?? h???p',
            ],
            [
                'name' => 'Sexy Clutches: C??ch Mua & ??eo T??i Clutch Thi???t k???',
            ],
            [
                'name' => 'Xu h?????ng t??i x??ch h??ng ?????u n??m 2020 c???n bi???t',
            ],
            [
                'name' => 'C??ch Ph???i M??u T??i X??ch C???a B???n V???i Trang Ph???c',
            ],
            [
                'name' => 'C??ch Ch??m s??c T??i Da',
            ],
            [
                'name' => 'Ch??ng t??i ??ang nghi???n ng???m 10 xu h?????ng t??i l???n nh???t c???a m??a h??',
            ],
            [
                'name' => 'Nh???ng ph???m ch???t c???n thi???t c???a ??m nh???c th??nh c??ng cao',
            ],
            [
                'name' => '9 ??i???u t??i th??ch khi c???o ?????u',
            ],
            [
                'name' => 'T???i sao l??m vi???c theo nh??m th???c s??? bi???n gi???c m?? th??nh c??ng',
            ],
            [
                'name' => 'Th??? gi???i ph???c v??? cho nh???ng ng?????i trung b??nh',
            ],
            [
                'name' => 'C??c ??????ng s??? tr??n m??n h??nh kh??ng ph???i l?? di???n vi??n',
            ],
        ];

        foreach ($translations as $index => $item) {
            $item['lang_code'] = 'vi';
            $item['posts_id'] = $index + 1;
            $item['description'] = 'B???n n??n ch?? ?? h??n khi ch???n v??. C?? r???t nhi???u trong s??? ch??ng tr??n th??? tr?????ng v???i c??c m???u m?? v?? phong c??ch kh??c nhau. Khi b???n l???a ch???n c???n th???n, b???n s??? c?? th??? mua m???t chi???c v?? ph?? h???p v???i nhu c???u c???a b???n. Ch??a k??? n?? s??? gi??p n??ng t???m phong c??ch c???a b???n m???t c??ch ????ng k???.';
            $item['content'] = Post::find($index + 1)->value('content');

            PostTranslation::insert($item);
        }
    }

    /**
     * @param array $item
     * @param int $parentId
     * @param bool $isFeatured
     * @return Category|\Illuminate\Database\Eloquent\Model
     */
    protected function createCategory(
        array $item,
        int $parentId = 0,
        bool $isFeatured = false
    ) {
        $faker = Factory::create();

        $item['description'] = $faker->text();
        $item['author_id'] = 1;
        $item['parent_id'] = $parentId;
        $item['is_featured'] = $isFeatured;

        $category = Category::create($item);

        Slug::create([
            'reference_type' => Category::class,
            'reference_id'   => $category->id,
            'key'            => Str::slug($category->name),
            'prefix'         => SlugHelper::getPrefix(Category::class),
        ]);

        return $category;
    }
}
