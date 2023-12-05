<?php

namespace App\Nova\Settings;
use Whitecube\NovaFlexibleContent\Flexible;
use Stepanenko3\NovaSettings\Types\AbstractType;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Panel;
use Eminiarts\Tabs\Tab;
use Eminiarts\Tabs\Tabs;
class Checkup extends AbstractType
{
    public function fields(): array
    {
        return [
            
            Text::make(__("Recipient's e-mail address"), 'email')->help(
                    'When the user fills out the form, the data will be sent to the corresponding email'
                ),
            // Text::make(__('Description'), 'description'),
           
        ];
    }

}