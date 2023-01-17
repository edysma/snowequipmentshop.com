<?php

if (is_plugin_active('ecommerce')) {
    require_once __DIR__ . '/product-tags.php';

    register_widget(ProducTagsWidget::class);
}
