<?php

use Botble\Widget\Factories\WidgetFactory;
use Botble\Widget\WidgetGroupCollection;

if (!function_exists('register_widget')) {
    /**
     * @param string $widgetId
     * @return WidgetFactory
     */
    function register_widget(string $widgetId): WidgetFactory
    {
        return Widget::registerWidget($widgetId);
    }
}

if (!function_exists('register_sidebar')) {
    /**
     * @param array $args
     * @return WidgetGroupCollection
     */
    function register_sidebar(array $args): WidgetGroupCollection
    {
        return WidgetGroup::setGroup($args);
    }
}

if (!function_exists('remove_sidebar')) {
    /**
     * @param string $sidebarId
     * @return WidgetGroupCollection
     */
    function remove_sidebar(string $sidebarId): WidgetGroupCollection
    {
        return WidgetGroup::removeGroup($sidebarId);
    }
}

if (!function_exists('dynamic_sidebar')) {
    /**
     * @param string $sidebarId
     * @return string
     */
    function dynamic_sidebar(string $sidebarId , $product_id = null): string
    {
        session(['product_id_for_sidebar'=>$product_id]);
        return WidgetGroup::render($sidebarId);
    }
}
