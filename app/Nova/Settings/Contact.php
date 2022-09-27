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

            new Panel(__('Receiver Email Parameters'), $this->emailFields()),
            new Panel(__('SMTP Parameters'), $this->smtpFields()),
        ];

        
    }

    /**
     * Get the Email fields for the resource.
     *
     * @return array
     */

    protected function emailFields()
    {
        return [
            Text::make(__('Vacancy form email'), 'vacancy_email')
            ->sortable()->help(
                __('Email where all messages will be sent')
            ),

            Text::make(__('Privacy statement form email'), 'privacy_email')
            ->sortable()->help(
                __('Email where all messages will be sent')
            ),
        ];
    }

    /**
     * Get the SMTP fields for the resource.
     *
     * @return array
     */

    protected function smtpFields()
    {
        return [
            Text::make(__('Host'), 'smtp_host'),
            Text::make(__('Username'), 'smtp_username')->withMeta(['extraAttributes' => [
                'placeholder' => 'example@aversiclinic.ge']
            ]),
            Password::make(__('Password'), 'smtp_password'),
            Number::make(__('Port'), 'smtp_port'),
            
        ];
    }
}