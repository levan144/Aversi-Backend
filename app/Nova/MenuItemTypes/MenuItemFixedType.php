<?php

namespace Outl1ne\MenuBuilder\MenuItemTypes;
use App\Models\Settings;
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
        '/services' => 'სერვისები',
        '/doctors' => 'ექიმები',
        '/branches' => 'ფილიალები',
        '/laboratory' => 'ლაბორატორია',
        '/news' => 'სიახლეები',
        '/blog' => 'ბლოგი',
        '/contact' => 'კონტაქტი',
        '/promotions' => 'აქციები',
        '/vacancies' => 'ვაკანსიები',
        '/partners' => 'პარტნიორები',
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
