<div class="form-group">
    <label for="widget-name">{{ trans('core/base::forms.name') }}</label>
    <input type="text" class="form-control" name="name" value="{{ $config['name'] }}">
</div>

<?php

use Botble\Blog\Models\Tag;

  $categories = Tag::all();
?>

<div class="form-group product-categories-select">
    <div class="multi-choices-widget list-item-checkbox">
        <ul>
            @foreach ($categories as $category)
                <li>
                    <label>
                        <input type="checkbox"
                               name="categories[]"
                               value="{{ $category->id }}"
                               @if (in_array($category->id, $config['categories'])) checked="checked" @endif>
                        {{ $category->name }}
                    </label>
                </li>
            @endforeach
        </ul>
    </div>
</div>

<style>
    .product-categories-select .list-item-checkbox {
        background: #f1f1f1; margin-bottom: 20px; padding-left: 15px !important;
    }

    .product-categories-select .list-item-checkbox .hrv-checkbox, input[type=checkbox] {
        margin-left : 2px;
    }
</style>
