<?php

namespace App\Nova\Settings;
use Stepanenko3\NovaSettings\Types\AbstractType;

use Laravel\Nova\Fields\Image;
use Whitecube\NovaFlexibleContent\Flexible;
use Illuminate\Support\Facades\Storage;
class Partners extends AbstractType
{
    public function fields(): array
    {
        return [
            
            Image::make(__('Cover'), 'cover_image')
                                ->disk('public')
                                ->prunable()
                                ->path('pages')
                                ->preview(function ($value, $disk) {
                                    return $value
                                                ? Storage::disk($disk)->url($value)
                                                : null;
                                })
                                ->creationRules('required'),
            
        ];
    }

   

}