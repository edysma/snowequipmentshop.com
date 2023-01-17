<?php

use Botble\Widget\AbstractWidget;

class BlogTagsWidget extends AbstractWidget
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
    protected $widgetDirectory = 'blog-tags';

    /**
     * Widget constructor.
     */
    public function __construct()
    {
        parent::__construct([
            'name'        => __('Blog Tags'),
            'description' => __('List of blog tags'),
            'categories'  => [],
        ]);
    }
}
