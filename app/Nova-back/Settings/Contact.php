<?php

namespace App\Nova\Settings;
use Whitecube\NovaFlexibleContent\Flexible;
use Stepanenko3\NovaSettings\Types\AbstractType;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Panel;
use Dniccum\PhoneNumber\PhoneNumber;
use AlexAzartsev\Heroicon\Heroicon;
use Laravel\Nova\Fields\Password;
use Eminiarts\Tabs\Tab;
use Eminiarts\Tabs\Tabs;
class Contact extends AbstractType
{
    public function fields(): array
    {
        return [
            new Panel(__('Content'), $this->generalFields()),
           new Panel(__('Meta Tags'), $this->metaFields()),
           
        ];
    }

    protected function generalFields()
    {
        return [
            PhoneNumber::make(__('Phone number'), 'phone')
            ->format('###-##-##-##')
            ->disableValidation()
            ->sortable(),

            Text::make(__('Email'), 'email')
                ->sortable(),
                
            new Panel(__('Address'), $this->addressFields()),

            Flexible::make(__('Social Networks'), 'social_networks')
                ->button(__('Add new'))
                ->addLayout(__('Social Network'), 'item', [
                    Text::make(__('Link'), 'url'),
                    Heroicon::make(__('Icon'), 'icon')->disableEditor(),
                ]),
        ];

    }
    
    /**
     * Get the Address field for the resource.
     *
     * @return array
     */

    protected function addressFields()
    {
        return [
            new Tabs(__("Address"), [
               new Tab(__("Georgian"), [
                   Text::make(__('Address'), 'address_ka')->nullable(),
               ]),
               new Tab(__("English"), [
                   Text::make(__('Address'), 'address_en')->nullable(),
               ]),
               new Tab(__("Russian"), [
                   Text::make(__('Address'), 'address_ru')->nullable(),
               ]),
           ]),
            
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