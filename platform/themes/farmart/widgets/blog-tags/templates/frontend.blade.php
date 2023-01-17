<?php

use Botble\Blog\Models\Tag;
    // dd($config['categories']);
    $categories = Tag::
         where('status', \Botble\Base\Enums\BaseStatusEnum::PUBLISHED)
        ->whereIn('id', $config['categories'])->get();

?>
@if ($categories->count())
    <div>
        <p>
            <strong>{{ $config['name'] }}:</strong>
            @foreach ($categories as $category)
                <a href="{{ $category->url }}" title="{{ $category->name }}">{{ $category->name }}</a>
            @endforeach
        </p>
    </div>
@endif
