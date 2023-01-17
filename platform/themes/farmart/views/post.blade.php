<?php 
use Botble\Ecommerce\Models\Product;
?>
@php Theme::set('withTitle', false); @endphp
<?php
$con=mysqli_connect("localhost","snownew","Hzf53s6_6%_","snownew",3306);


?>
<div class="row mt-5">
    <div class="col-md-9">
      
        
    
        <h1 class="h2">{{ $post->name }}</h1>
        <div class="post-item__inner pb-4 my-3 border-bottom">
            <div class="entry-meta" style="display:none">
                @if ($post->author)
                    <div class="entry-meta-author">
                        <span>{{ __('By :name', ['name' => $post->author->name]) }}</span>
                    </div>
                @endif
                @if ($post->categories->count())
                    <div class="entry-meta-categories">
                        <span>{{ __('in') }}</span>
                        @foreach($post->categories as $category)
                            <a href="{{ $category->url }}">{{ $category->name }}</a> @if (!$loop->last) , @endif
                        @endforeach
                    </div>
                @endif
                <div class="entry-meta-date">
                    <span>{{ __('on') }}</span>
                    <time>{{ $post->created_at->translatedFormat('M d, Y') }}</time>
                </div>
            </div>
        </div>
        <div class="mt-5 pt-3 post-detail__content">
            <!-- <img src="/storage/{{$post->image}}"> <br><br> -->
            <?php if($post->readmore != 0){
                ?>
               
            <div id="lessdesc">  
                
            {!! BaseHelper::clean(substr($post->content,0,$post->readmore+60)) !!}
            <a href="javascript:void(0)" id="moredescbtn"> {{ __('Read More') }} </a>
            </div>
            <div id="moredesc">  
            {!! BaseHelper::clean($post->content) !!}
            <a href="javascript:void(0)" id="lessdescbtn">{{ __('show less') }}  </a>
            </div>
            <?php 
            }
            else{
                ?>
{!! BaseHelper::clean($post->content) !!}
                <?php
            }
            ?>

            <!-- @if ($post->tags->count())
                <div class="entry-meta-tags">
                    <strong>{{ __('Tags') }}:</strong>
                    @foreach($post->tags as $tag)
                        <a href="{{ $tag->url }}" class="text-link">{{ $tag->name }}</a>@if (!$loop->last), @endif
                    @endforeach
                </div>
            @endif -->

            @if (theme_option('facebook_comment_enabled_in_post', 'yes') == 'yes')
                <br />
                {!! apply_filters(BASE_FILTER_PUBLIC_COMMENT_AREA, Theme::partial('comments')) !!}
            @endif
        </div>
        <pre>
        
        </pre>
        <?php
            $tags=[];
           
            foreach ($post->tags as $key => $value) {
            
                $tags[]=$value->id;
            }
            $tag=implode(',',$tags);
            $query="SELECT * FROM  `ec_products` as pro INNER JOIN `ec_product_tag_product` as pro_tag  ON pro_tag.product_id=pro.id
            inner join slugs on pro.id = slugs.reference_id  WHERE pro_tag.tag_id IN (".$tag.")  GROUP BY pro.id";
           $res=mysqli_query($con,$query);

        ?>
         @if ($res->num_rows)
            <div class="related-posts mt-5 pt-3">
                <div class="heading">
                    <h3>{{ __('Products BY Tag') }}</h3>
                </div>
                <div class="list-post--wrapper">
                    <div class="slick-slides-carousel" data-slick="{{ json_encode([
                        'slidesToShow'   => 3,
                        'slidesToScroll' => 1,
                        'arrows'         => true,
                        'dots'           => true,
                        'infinite'        => false,
                        'responsive'     => [
                            [
                                'breakpoint' => 1200,
                                'settings'   => [
                                    'slidesToShow'   => 2,
                                    'slidesToScroll' => 1
                                ],
                            ],
                            [
                                'breakpoint' => 480,
                                'settings'   => [
                                    'slidesToShow'   => 1,
                                    'slidesToScroll' => 1
                                ],
                            ],
                        ],
                    ]) }}">
                    @while($item=mysqli_fetch_assoc($res))
                        <?php $product=(object)$item;
            $product = Product::where('id', $product->reference_id)->where('is_variation', 0)->first();
                        
                        ?>
                    {!! Theme::partial('ecommerce.product-tag-item', compact('product')) !!}
                        
                    @endwhile
                    
                    </div>
                    
                </div>
            </div>
        @endif

        @php $relatedPosts = get_related_posts($post->id, 4); @endphp

        @if ($relatedPosts->count())
            <div class="related-posts mt-5 pt-3">
                <div class="heading">
                    <h3>{{ __('Related Posts') }}</h3>
                </div>
                <div class="list-post--wrapper">
                    <div class="slick-slides-carousel" data-slick="{{ json_encode([
                        'slidesToShow'   => 3,
                        'slidesToScroll' => 1,
                        'arrows'         => true,
                        'dots'           => true,
                        'infinite'        => false,
                        'responsive'     => [
                            [
                                'breakpoint' => 1200,
                                'settings'   => [
                                    'slidesToShow'   => 2,
                                    'slidesToScroll' => 1
                                ],
                            ],
                            [
                                'breakpoint' => 480,
                                'settings'   => [
                                    'slidesToShow'   => 1,
                                    'slidesToScroll' => 1
                                ],
                            ],
                        ],
                    ]) }}">
                        @foreach ($relatedPosts as $item)
                            {!! Theme::partial('post-item', ['post' => $item]) !!}
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
    <div class="col-md-3">
        <div class="primary-sidebar">
            <aside class="widget-area" id="primary-sidebar">
                {!! dynamic_sidebar('primary_sidebar') !!}
            </aside>
        </div>
    </div>
</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
// jQuery(document).ready(function(){
//     console.log("ready");
//     // var ids=[];
//     jQuery.ajax({
//         url:'productBYTag',
//         type:'GET',
//         data:{id:'<?//=$tag?>'},
//         success:function(response){
//             console.log(response);
//         },
//     });
// });

</script>
