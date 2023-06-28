<?php

namespace App\Nova\Flexible\Layouts;

use Whitecube\NovaFlexibleContent\Layouts\Layout;

class OrderingLayoutBlog extends Layout
{
    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = 'orderingBlog';
    /**
     * The maximum amount of this layout type that can be added
     */
    protected $limit = 1;
    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = 'Blogs';

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            // Define the layout's fields.
        ];
    }

}
