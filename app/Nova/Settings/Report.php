<?php

namespace App\Nova\Settings;
use Stepanenko3\NovaSettings\Types\AbstractType;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Panel;
use Laravel\Nova\Fields\Password;
use Eminiarts\Tabs\Tab;
use Eminiarts\Tabs\Tabs;
use Murdercode\TinymceEditor\TinymceEditor;

class Report extends AbstractType
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
         
            
            new Tabs(__("Meta Tags"), [
               new Tab(__("Georgian"), [
                   TinymceEditor::make(__('Content'), 'content_ka')->nullable(),
                //    Trix::make(__('Content'), 'content_ka')->nullable(),
               ]),
               new Tab(__("English"), [
                   TinymceEditor::make(__('Content'), 'content_en')->nullable(),
                //    Trix::make(__('Content'), 'content_en')->nullable(),
               ]),
               new Tab(__("Russian"), [
                   TinymceEditor::make(__('Content'), 'content_ru')->nullable(),
                //    Trix::make(__('Content'), 'content_ru')->nullable(),
               ]),
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