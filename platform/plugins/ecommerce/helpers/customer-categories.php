<?php

use Illuminate\Support\Collection;

if (!function_exists('get_customer_categories')) {
    /**
     * @return Collection
     * @deprecated
     */
    function get_customer_categories(): Collection
    {
        return CustomerCategoryHelper::getAllCustomerCategories();
    }
}

if (!function_exists('get_customer_categories_with_children')) {
    /**
     * @return array
     * @deprecated
     */
    function get_customer_categories_with_children(): array
    {
        return CustomerCategoryHelper::getAllCustomerCategoriesWithChildren();
    }
}
