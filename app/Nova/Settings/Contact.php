<?php

namespace App\Nova\Settings;
use Whitecube\NovaFlexibleContent\Flexible;
use Stepanenko3\NovaSettings\Types\AbstractType;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Panel;
use Dniccum\PhoneNumber\PhoneNumber;
use AlexAzartsev\Heroicon\Heroicon;
class Contact extends AbstractType
{
    public function fields(): array
    {
        return [
            new Panel(__('Content'), $this->generalFields()),
           
           
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
            Text::make(__('Address'), 'address')
                ->nullable(),

            Flexible::make(__('Social Networks'), 'social_networks')
                ->button(__('Add new'))
                ->addLayout(__('Social Network'), 'item', [
                    Text::make(__('Link'), 'url'),
                    Heroicon::make(__('Icon'))->disableEditor(),
                ]),
        ];
    }
}