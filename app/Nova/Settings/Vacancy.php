<?php

namespace App\Nova\Settings;

use Eminiarts\Tabs\Tab;
use Eminiarts\Tabs\Tabs;
use Laravel\Nova\Fields\Boolean;
use Stepanenko3\NovaSettings\Types\AbstractType;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Panel;
use Illuminate\Support\Facades\Storage;
use AlexAzartsev\Heroicon\Heroicon;
class Vacancy extends AbstractType
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
            new Panel(__('Receiver Email Parameters'), $this->emailFields()),
            new Panel(__('SMTP Parameters'), $this->smtpFields()),
            new Panel(__('Meta Tags'), $this->metaFields()),
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