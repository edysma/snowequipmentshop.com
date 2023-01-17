<?php

namespace Botble\Ecommerce\Facades;

use Botble\Ecommerce\Supports\CustomerCategoryHelper;

use Illuminate\Support\Facades\Facade;

class CustomerCategoryHelperFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return CustomerCategoryHelper::class;
    }
}
