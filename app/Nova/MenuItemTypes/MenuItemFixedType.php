<?php

namespace Outl1ne\MenuBuilder\MenuItemTypes;
use App\Models\Settings;
use Laravel\Nova\Fields\Image;
use Storage;
use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;
use AlexAzartsev\Heroicon\Heroicon;

class MenuItemFixedType extends BaseMenuItemType
{
    public static function getIdentifier(): string
    {
        return 'general-url';
    }

    public static function getName(): string
    {
        return 'General URL';
    }

    public static function getOptions($locale): array {
    // Example usecase
    return [
        '/services' => __('Services'),
        '/doctors' => __('Doctors'),
        '/branches' => __('Branches'),
        '/laboratory' => __('Laboratory'),
        '/news' => __('News'),
        '/blog' => __('Blog'),
        '/contact' => __('Contact'),
        '/promotions' =>__('Promotions'),
        '/vacancies' => __('Vacancies'),
        '/partners' => __('Partners'),
    ];
}

/**
 * Get the fields displayed by the resource.
 *
 * @return array An array of fields.
 */
public static function getFields(): array
{
    return [ 
        Heroicon::make('Icon')->registerIconSet('custom', 'Custom', resource_path('img/icons'))->disableEditor(),
];
}

    public static function getType(): string
    {
        return 'select';
    }

    public static function getRules(): array
    {
        return [
            'value' => 'required',
        ];
    }
}
