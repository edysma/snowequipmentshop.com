<?php

if (is_plugin_active('ecommerce')) {
    require_once __DIR__ . '/blog-tags.php';

    register_widget(BlogTagsWidget::class);
}
