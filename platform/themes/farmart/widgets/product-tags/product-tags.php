<?php

use Botble\Widget\AbstractWidget;

class ProducTagsWidget extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * @var string
     */
    protected $frontendTemplate = 'frontend';

    /**
     * @var string
     */
    protected $backendTemplate = 'backend';

    /**
     * @var string
     */
    protected $widgetDirectory = 'product-tags';

    /**
     * Widget constructor.
     */
    public function __construct()
    {
        parent::__construct([
            'name'        => __('Product Tags'),
            'description' => __('List of product tags'),
            'categories'  => [],
        ]);
    }
}
