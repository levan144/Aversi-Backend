<?php

namespace App\Nova\Settings;
use Whitecube\NovaFlexibleContent\Flexible;
use Eminiarts\Tabs\Tab;
use Eminiarts\Tabs\Tabs;
use Stepanenko3\NovaSettings\Types\AbstractType;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Trix;
use Kongulov\NovaTabTranslatable\NovaTabTranslatable;
use Laravel\Nova\Panel;
use Illuminate\Support\Facades\Storage;
use AlexAzartsev\Heroicon\Heroicon;
class Covid extends AbstractType
{
    public function fields(): array
    {
        return [
            
           
            new Tabs(__("Content"), [
                new Tab(__("Georgian"), [
                    Flexible::make(__('Data'), 'data_ka')
                    ->button(__('Add new'))
                    ->addLayout(__('FAQ'), 'faq', [
                            Text::make(__('Title'), 'title')->rules('required'),
                            Text::make(__('Description'), 'description')->rules('required'),
                            Heroicon::make(__('Icon'),'icon_url')->registerIconSet('custom', 'Custom', resource_path('img/icons'))->disableEditor()->rules('required'),
                       
                ])->rules('required'),
            ]),
            new Tab(__("English"), [
                Flexible::make(__('Data'), 'data_en')
                ->button(__('Add new'))
                ->addLayout(__('FAQ'), 'faq', [
                        Text::make(__('Title'), 'title')->rules('required'),
                        Text::make(__('Description'), 'description')->rules('required'),
                        Heroicon::make(__('Icon'),'icon_url')->registerIconSet('custom', 'Custom', resource_path('img/icons'))->disableEditor()->rules('required'),
                   
            ])->rules('required'),
        ]),
            new Tab(__("Russian"), [
                Flexible::make(__('Data'), 'data_ru')
                ->button(__('Add new'))
                ->addLayout(__('FAQ'), 'faq', [
                        Text::make(__('Title'), 'title')->rules('required'),
                        Text::make(__('Description'), 'description')->rules('required'),
                        Heroicon::make(__('Icon'),'icon_url')->registerIconSet('custom', 'Custom', resource_path('img/icons'))->disableEditor()->rules('required'),
                   
            ])->rules('required'),
            ]),
        ]),
        
        new Panel(__('Meta Tags'), $this->metaFields()),
        
        ];
    }
    
    protected function metaFields()
    {
        return [
           new Tabs(__("Meta Tags"), [
               new Tab(__("Georgian"), [
                   Text::make(__('Meta Title'), 'meta_title_ka'),
                   Text::make(__('Meta Description'), 'meta_description_ka'),
               ]),
               new Tab(__("English"), [
                   Text::make(__('Meta Title'), 'meta_title_en'),
                   Text::make(__('Meta Description'), 'meta_description_en'),
               ]),
               new Tab(__("Russian"), [
                   Text::make(__('Meta Title'), 'meta_title_ru'),
                   Text::make(__('Meta Description'), 'meta_description_ru'),
               ]),
           ]),
        ];
        
    }


}